<?php
// app/Http/Controllers/QuizController.php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizIntento;
use App\Models\QuizRespuesta;
use App\Models\QuizPregunta;
use App\Models\ProgresoLeccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{

    /** Mostrar quiz (antes de empezar) */
    public function show(Quiz $quiz)
    {
        $user     = auth()->user();
        $intentos = $quiz->intentosDeUsuario($user->id)->get();
        $mejor    = $intentos->sortByDesc('porcentaje')->first();
        $puedeIntentar = $quiz->puedeIntentar($user->id);

        return view('quiz.show', compact('quiz','intentos','mejor','puedeIntentar'));
    }

    /** Iniciar un nuevo intento */
    public function iniciar(Quiz $quiz)
    {
        $user = auth()->user();

        if (!$quiz->puedeIntentar($user->id)) {
            return back()->with('error', 'Has agotado los intentos permitidos para este quiz.');
        }

        // Verificar que la lección anterior esté completada
        $leccion = $quiz->leccion;
        $curso   = $leccion->modulo->curso;
        $todas   = \App\Models\Leccion::whereHas('modulo', fn($q) => $q->where('curso_id', $curso->id))
                    ->join('modulos', 'lecciones.modulo_id', '=', 'modulos.id')
                    ->where('lecciones.activo', true)
                    ->orderBy('modulos.orden')
                    ->orderBy('lecciones.orden')
                    ->select('lecciones.*')
                    ->get();
        $indice  = $todas->search(fn($l) => $l->id === $leccion->id);
        if ($indice > 0) {
            $anteriorId = $todas[$indice - 1]->id;
            $anteriorOk = \App\Models\ProgresoLeccion::where('user_id', $user->id)
                ->where('leccion_id', $anteriorId)
                ->where('completado', true)
                ->exists();
            if (!$anteriorOk) {
                return redirect()->route('curso.player', $curso->slug)
                    ->with('error', 'Debes completar la lección anterior antes de poder realizar este quiz.');
            }
        }

        $intento = QuizIntento::create([
            'user_id'      => $user->id,
            'quiz_id'      => $quiz->id,
            'puntaje'      => 0,
            'puntaje_total'=> $quiz->preguntas()->sum('puntos'),
            'iniciado_at'  => now(),
        ]);

        $preguntas = $quiz->aleatorio
            ? $quiz->preguntas()->with('opciones')->get()->shuffle()
            : $quiz->preguntas()->with('opciones')->get();

        return view('quiz.tomar', compact('quiz','intento','preguntas'));
    }

    /** Enviar respuestas y calcular resultado */
    public function enviar(Request $request, QuizIntento $intento)
    {
        $user = auth()->user();

        if ($intento->user_id !== $user->id) abort(403);
        if ($intento->finalizado_at) {
            return redirect()->route('quiz.resultado', $intento);
        }

        $quiz      = $intento->quiz;
        $preguntas = $quiz->preguntas()->with('opciones')->get();
        $respuestas= $request->input('respuestas', []);
        $puntaje   = 0;

        DB::transaction(function () use ($preguntas, $respuestas, $intento, &$puntaje) {
            foreach ($preguntas as $pregunta) {
                $respuestaUsuario = $respuestas[$pregunta->id] ?? null;
                $esCorrecta       = null;
                $puntosObtenidos  = 0;

                $respuesta = QuizRespuesta::create([
                    'intento_id'  => $intento->id,
                    'pregunta_id' => $pregunta->id,
                    'es_correcta' => null,
                    'puntos_obtenidos' => 0,
                ]);

                if ($pregunta->tipo === 'texto_libre') {
                    $respuesta->update([
                        'respuesta_texto' => is_string($respuestaUsuario) ? $respuestaUsuario : null,
                        'es_correcta'     => null, // revisión manual
                    ]);
                    continue;
                }

                if ($pregunta->tipo === 'verdadero_falso' || $pregunta->tipo === 'opcion_multiple') {
                    // Respuesta única
                    $opcionId = is_array($respuestaUsuario) ? ($respuestaUsuario[0] ?? null) : $respuestaUsuario;
                    if ($opcionId) {
                        $respuesta->opciones()->attach($opcionId);
                        $opcion = $pregunta->opciones->find($opcionId);
                        $esCorrecta = $opcion?->es_correcta ?? false;
                        $puntosObtenidos = $esCorrecta ? $pregunta->puntos : 0;
                    } else {
                        $esCorrecta = false;
                    }
                } elseif ($pregunta->tipo === 'multiple_respuesta') {
                    // Múltiples opciones
                    $opcionIds   = is_array($respuestaUsuario) ? $respuestaUsuario : [];
                    $correctasIds= $pregunta->opciones->where('es_correcta', true)->pluck('id')->toArray();

                    if (!empty($opcionIds)) {
                        $respuesta->opciones()->attach($opcionIds);
                    }

                    $seleccionadas = collect($opcionIds)->map(fn($id) => (int)$id);
                    $correctas     = collect($correctasIds);

                    $esCorrecta = $seleccionadas->sort()->values()->toArray() === $correctas->sort()->values()->toArray();
                    $puntosObtenidos = $esCorrecta ? $pregunta->puntos : 0;
                }

                $respuesta->update([
                    'es_correcta'      => $esCorrecta,
                    'puntos_obtenidos' => $puntosObtenidos,
                ]);

                $puntaje += $puntosObtenidos;
            }
        });

        // Calcular resultado final
        $puntajeTotal = $quiz->preguntas()->sum('puntos');
        $porcentaje   = $puntajeTotal > 0 ? round(($puntaje / $puntajeTotal) * 100, 2) : 0;
        $aprobado     = $porcentaje >= $quiz->puntaje_aprobatorio;
        $tiempoUsado  = now()->diffInSeconds($intento->iniciado_at);

        $intento->update([
            'puntaje'       => $puntaje,
            'puntaje_total' => $puntajeTotal,
            'porcentaje'    => $porcentaje,
            'aprobado'      => $aprobado,
            'finalizado_at' => now(),
            'tiempo_usado'  => $tiempoUsado,
        ]);

        // Si aprobó, marcar la lección como completada
        if ($aprobado) {
            $leccionId = $quiz->leccion_id;
            ProgresoLeccion::updateOrCreate(
                ['user_id' => auth()->id(), 'leccion_id' => $leccionId],
                ['completado' => true, 'completado_at' => now()]
            );
            // Actualizar progreso general del curso
            $this->actualizarProgresoCurso(auth()->id(), $quiz->leccion->modulo->curso_id);
        }

        return redirect()->route('quiz.resultado', $intento);
    }

    /** Ver resultado de un intento */
    public function resultado(QuizIntento $intento)
    {
        if ($intento->user_id !== auth()->id()) abort(403);

        $intento->load([
            'quiz.preguntas.opciones',
            'respuestas.opciones',
            'respuestas.pregunta.opciones',
        ]);

        return view('quiz.resultado', compact('intento'));
    }

    /** Actualizar progreso del curso basado en lecciones completadas */
    private function actualizarProgresoCurso(int $userId, int $cursoId): void
    {
        $totalLecciones = \App\Models\Leccion::whereHas('modulo', fn($q) => $q->where('curso_id', $cursoId))
                                            ->where('activo', true)->count();

        if ($totalLecciones === 0) return;

        $completadas = ProgresoLeccion::where('user_id', $userId)
            ->whereHas('leccion.modulo', fn($q) => $q->where('curso_id', $cursoId))
            ->where('completado', true)->count();

        $progreso  = round(($completadas / $totalLecciones) * 100);
        $completado = $progreso >= 100;

        \DB::table('inscripciones')
            ->where('user_id', $userId)
            ->where('curso_id', $cursoId)
            ->update([
                'progreso'        => $progreso,
                'completado'      => $completado,
                'fecha_completado'=> $completado ? now() : null,
                'updated_at'      => now(),
            ]);
    }
}