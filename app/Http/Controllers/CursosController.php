<?php
// app/Http/Controllers/CursosController.php
namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    /** Catálogo público de cursos */
    public function index(Request $request)
    {
        $query = Curso::where('activo', true)
                    ->withCount('estudiantes')
                    ->orderByDesc('destacado')
                    ->orderBy('orden')
                    ->orderByDesc('created_at');

        // Filtro búsqueda
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('titulo', 'like', '%'.$request->q.'%')
                ->orWhere('descripcion_corta', 'like', '%'.$request->q.'%');
            });
        }

        // Filtro categoría
        if ($request->filled('categoria') && $request->categoria !== 'all') {
            $query->where('categoria', $request->categoria);
        }

        // Filtro tipo
        if ($request->filled('tipo') && $request->tipo !== 'all') {
            $query->where('tipo', $request->tipo);
        }

        $cursos = $query->get();

        return view('cursos.index', compact('cursos'));
    }

    /** Detalle público de un curso */
    public function show(Curso $curso)
    {
        if (!$curso->activo) abort(404);

        $curso->load(['modulos' => function ($q) {
            $q->orderBy('orden')->with(['lecciones' => function ($q2) {
                $q2->where('activo', true)->orderBy('orden');
            }]);
        }]);

        $totalLecciones = $curso->lecciones()->where('activo', true)->count();
        $yaInscrito = false;
        $progreso   = 0;

        if (auth()->check()) {
            $inscripcion = auth()->user()->cursos()
                ->where('curso_id', $curso->id)->first();
            if ($inscripcion) {
                $yaInscrito = true;
                $progreso   = $inscripcion->pivot->progreso;
            }
        }

        $cursosRelacionados = Curso::where('activo', true)
            ->where('categoria', $curso->categoria)
            ->where('id', '!=', $curso->id)
            ->take(3)->get();

        return view('cursos.show', compact(
            'curso','totalLecciones','yaInscrito','progreso','cursosRelacionados'
        ));
    }

    /** Inscribir usuario en un curso */
    public function inscribir(Request $request, Curso $curso)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para inscribirte.');
        }

        $user = auth()->user();

        // Verificar si ya está inscrito
        if ($user->cursos()->where('curso_id', $curso->id)->exists()) {
            return redirect()->route('cursos.show', $curso)
                            ->with('info', 'Ya estás inscrito en este curso.');
        }

        $user->cursos()->attach($curso->id, [
            'progreso'          => 0,
            'completado'        => false,
            'fecha_inscripcion' => now(),
        ]);

        return redirect()->route('dashboard.cursos')
                        ->with('success', "¡Te inscribiste en «{$curso->titulo}»! Ya puedes empezar.");
    }
}