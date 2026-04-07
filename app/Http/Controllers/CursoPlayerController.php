<?php
// app/Http/Controllers/CursoPlayerController.php
namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Leccion;
use App\Models\ProgresoLeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoPlayerController extends Controller
{
    /**
     * Reproductor del curso — muestra el contenido de una lección
     */
    public function show(string $slug, int $leccionId = null)
    {
        $user  = Auth::user();
        $curso = Curso::where('slug', $slug)->firstOrFail();

        // Verificar inscripción
        $inscripcion = $user->cursos()->where('curso_id', $curso->id)->first();
        if (!$inscripcion) {
            return redirect()->route('cursos.show', $slug)
                ->with('error', 'Debes inscribirte en el curso para acceder al contenido.');
        }

        // Cargar módulos y lecciones
        $curso->load(['modulos' => function ($q) {
            $q->orderBy('orden')->with(['lecciones' => function ($q2) {
                $q2->where('activo', true)->orderBy('orden');
            }]);
        }]);

        // Todas las lecciones del curso en orden
        $todasLecciones = $curso->modulos->flatMap(fn($m) => $m->lecciones);

        if ($todasLecciones->isEmpty()) {
            return redirect()->route('cursos.show', $slug)
                ->with('info', 'Este curso aún no tiene lecciones disponibles.');
        }

        // Lección activa — si no se especifica, buscar la primera no completada
        $leccionesCompletadasIds = ProgresoLeccion::where('user_id', $user->id)
            ->where('completado', true)
            ->pluck('leccion_id')
            ->toArray();
        $leccionesCompletadas = $leccionesCompletadasIds;

        if ($leccionId) {
            $leccionActiva = $todasLecciones->firstWhere('id', $leccionId)
                ?? $todasLecciones->first();
        } else {
            // Primera lección no completada, o la primera si todas están completas
            $leccionActiva = $todasLecciones->first(fn($l) => !in_array($l->id, $leccionesCompletadasIds))
                ?? $todasLecciones->first();
        }

        // Cargar relaciones de la lección activa
        $leccionActiva->load('modulo', 'quiz.preguntas');

        // Determinar si la lección activa está completada
        $leccionCompletada = in_array($leccionActiva->id, $leccionesCompletadasIds);

        // ── Lecciones desbloqueadas (orden secuencial) ──
        $idsOrdenados = $todasLecciones->pluck('id')->toArray();
        $leccionesDesbloqueadas = [];
        foreach ($idsOrdenados as $i => $id) {
            if ($i === 0) {
                $leccionesDesbloqueadas[] = $id;
            } else {
                $anteriorId = $idsOrdenados[$i - 1];
                if (in_array($anteriorId, $leccionesCompletadasIds)) {
                    $leccionesDesbloqueadas[] = $id;
                } else {
                    break;
                }
            }
        }

        // ¿La lección activa está bloqueada?
        $leccionBloqueada = !in_array($leccionActiva->id, $leccionesDesbloqueadas);

        // ── Tiempo acumulado en la lección activa ──
        $tiempoAcumulado = ProgresoLeccion::where('user_id', $user->id)
            ->where('leccion_id', $leccionActiva->id)
            ->value('tiempo_visto') ?? 0;

        // Lección anterior y siguiente
        $indiceActual    = $todasLecciones->search(fn($l) => $l->id === $leccionActiva->id);
        $leccionAnterior = $indiceActual > 0 ? $todasLecciones[$indiceActual - 1] : null;
        $leccionSiguiente = $indiceActual < $todasLecciones->count() - 1
            ? $todasLecciones[$indiceActual + 1]
            : null;

        // Estadísticas de progreso
        $totalLecciones            = $todasLecciones->count();
        $leccionesCompletadasCount = count(array_intersect($leccionesCompletadasIds, $todasLecciones->pluck('id')->toArray()));
        $progreso                  = $totalLecciones > 0
            ? round(($leccionesCompletadasCount / $totalLecciones) * 100)
            : 0;

        return view('curso-player', compact(
            'curso',
            'leccionActiva',
            'leccionCompletada',
            'leccionBloqueada',
            'leccionesDesbloqueadas',
            'tiempoAcumulado',
            'leccionAnterior',
            'leccionSiguiente',
            'leccionesCompletadas',
            'leccionesCompletadasCount',
            'totalLecciones',
            'progreso'
        ));
    }

    /**
     * Marcar una lección como completada
     */
    public function completar(Request $request, Leccion $leccion)
    {
        $user  = Auth::user();
        $curso = Curso::findOrFail($request->curso_id);

        // Verificar secuencia: la lección anterior debe estar completada
        $cursoTmp = Curso::with(['modulos' => function ($q) {
            $q->orderBy('orden')->with(['lecciones' => function ($q2) {
                $q2->where('activo', true)->orderBy('orden');
            }]);
        }])->find($curso->id);
        $todas   = $cursoTmp->modulos->flatMap(fn($m) => $m->lecciones);
        $indice  = $todas->search(fn($l) => $l->id === $leccion->id);
        if ($indice > 0) {
            $anteriorId = $todas[$indice - 1]->id;
            $anteriorOk = ProgresoLeccion::where('user_id', $user->id)
                ->where('leccion_id', $anteriorId)
                ->where('completado', true)
                ->exists();
            if (!$anteriorOk) {
                return redirect()->route('curso.player.leccion', [$curso->slug, $leccion->id])
                    ->with('error', 'Debes completar la lección anterior antes de continuar.');
            }
        }

        // Registrar progreso de la lección
        ProgresoLeccion::updateOrCreate(
            ['user_id' => $user->id, 'leccion_id' => $leccion->id],
            ['completado' => true, 'completado_at' => now()]
        );

        // Recalcular progreso del curso
        $curso->load(['modulos.lecciones' => fn($q) => $q->where('activo', true)]);
        $todasLecciones = $curso->modulos->flatMap(fn($m) => $m->lecciones);
        $totalLecciones = $todasLecciones->count();

        $completadas = ProgresoLeccion::where('user_id', $user->id)
            ->where('completado', true)
            ->whereIn('leccion_id', $todasLecciones->pluck('id'))
            ->count();

        $progreso   = $totalLecciones > 0 ? round(($completadas / $totalLecciones) * 100) : 0;
        $completado = $progreso >= 100;

        // Actualizar tabla pivote inscripciones
        $user->cursos()->updateExistingPivot($curso->id, [
            'progreso'          => $progreso,
            'completado'        => $completado,
        ]);

        return redirect()->route('curso.player.leccion', [$curso->slug, $leccion->id])
            ->with('success', '¡Lección completada! ' . ($completado ? '🎉 ¡Felicitaciones, completaste el curso!' : ''));
    }

    
    //Registrar tiempo dedicado a una lección
    
    public function registrarTiempo(Request $request, Leccion $leccion)
    {
        $request->validate(['segundos' => 'required|integer|min:1|max:3600']);

        ProgresoLeccion::updateOrCreate(
            ['user_id' => Auth::id(), 'leccion_id' => $leccion->id],
            ['tiempo_visto' => \DB::raw('tiempo_visto + ' . $request->segundos)]
        );

        return response()->json(['ok' => true]);
    }
}