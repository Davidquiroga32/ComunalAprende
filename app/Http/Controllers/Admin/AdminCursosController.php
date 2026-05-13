<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Modulo;
use App\Models\Leccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\B2Service;
use Illuminate\Support\Str;

class AdminCursosController extends Controller
{
    /** Lista de todos los cursos */
    public function index()
    {
        $cursos = Curso::withCount(['estudiantes', 'lecciones'])
            ->orderBy('orden')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalCursos      = $cursos->count();
        $totalEstudiantes = $cursos->sum('estudiantes_count');
        $cursosActivos    = $cursos->where('activo', true)->count();

        return view('admin.cursos.index', compact(
            'cursos', 'totalCursos', 'totalEstudiantes', 'cursosActivos'
        ));
    }

    /** Formulario de creación */
    public function create()
    {
        return view('admin.cursos.create');
    }

    /** Guardar nuevo curso */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'            => 'required|string|max:255',
            'descripcion_corta' => 'nullable|string|max:500',
            'descripcion'       => 'nullable|string',
            'categoria'         => 'required|in:gestion,normatividad,liderazgo,proyectos,participacion,contabilidad,otro',
            'tipo'              => 'required|in:free,paid',
            'precio'            => 'nullable|numeric|min:0',
            'duracion_horas'    => 'nullable|integer|min:0',
            'icono_fa'          => 'nullable|string|max:50',
            'color_gradiente'   => 'nullable|string|max:50',
            'activo'            => 'nullable|boolean',
            'destacado'         => 'nullable|boolean',
            'imagen'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data['slug']       = Str::slug($data['titulo']);
        $data['created_by'] = Auth::id();
        $data['activo']     = $request->boolean('activo', true);
        $data['destacado']  = $request->boolean('destacado');
        $data['precio']     = $data['tipo'] === 'free' ? 0 : ($data['precio'] ?? 0);

        if ($request->hasFile('imagen')) {
            $b2 = app(B2Service::class);
            $resultado      = $b2->subir($request->file('imagen'), 'cursos', 'image');
            $data['imagen'] = $resultado['url'];
        }

        $curso = Curso::create($data);

        return redirect()->route('admin.cursos.show', $curso)
            ->with('success', "Curso \"{$curso->titulo}\" creado exitosamente.");
    }

    /** Ver detalle del curso + módulos + lecciones */
    public function show(Curso $curso)
    {
        $curso->load(['modulos.lecciones', 'estudiantes']);
        $totalLecciones   = $curso->lecciones()->count();
        $totalEstudiantes = $curso->estudiantes()->count();
        $completados      = $curso->estudiantes()->wherePivot('completado', true)->count();

        return view('admin.cursos.show', compact(
            'curso', 'totalLecciones', 'totalEstudiantes', 'completados'
        ));
    }

    /** Formulario de edición */
    public function edit(Curso $curso)
    {
        return view('admin.cursos.edit', compact('curso'));
    }

    /** Guardar edición */
    public function update(Request $request, Curso $curso)
    {
        $data = $request->validate([
            'titulo'            => 'required|string|max:255',
            'descripcion_corta' => 'nullable|string|max:500',
            'descripcion'       => 'nullable|string',
            'categoria'         => 'required|in:gestion,normatividad,liderazgo,proyectos,participacion,contabilidad,otro',
            'tipo'              => 'required|in:free,paid',
            'precio'            => 'nullable|numeric|min:0',
            'duracion_horas'    => 'nullable|integer|min:0',
            'icono_fa'          => 'nullable|string|max:50',
            'color_gradiente'   => 'nullable|string|max:50',
            'activo'            => 'nullable|boolean',
            'destacado'         => 'nullable|boolean',
            'imagen'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data['activo']    = $request->boolean('activo');
        $data['destacado'] = $request->boolean('destacado');
        $data['precio']    = $data['tipo'] === 'free' ? 0 : ($data['precio'] ?? 0);

        if ($request->hasFile('imagen')) {
            $b2 = app(B2Service::class);
            // Borrar imagen anterior de B2
            $b2->eliminar(B2Service::urlAPublicId($curso->imagen ?? ''));
            $resultado      = $b2->subir($request->file('imagen'), 'cursos', 'image');
            $data['imagen'] = $resultado['url'];
        }

        $curso->update($data);

        return redirect()->route('admin.cursos.show', $curso)
            ->with('success', 'Curso actualizado correctamente.');
    }

    /** Eliminar curso */
    public function destroy(Curso $curso)
    {
        $titulo = $curso->titulo;
        if ($curso->imagen) {
            app(B2Service::class)->eliminar(B2Service::urlAPublicId($curso->imagen));
        }
        $curso->delete();

        return redirect()->route('admin.cursos.index')
            ->with('success', "Curso \"{$titulo}\" eliminado.");
    }

    /** Ver estudiantes de un curso */
    public function estudiantes(Curso $curso)
    {
        $estudiantes = $curso->estudiantes()
            ->withPivot('progreso', 'completado', 'fecha_inscripcion', 'fecha_completado')
            ->orderByPivot('fecha_inscripcion', 'desc')
            ->get();

        return view('admin.cursos.estudiantes', compact('curso', 'estudiantes'));
    }

    /** Activar/desactivar curso */
    public function toggleActivo(Curso $curso)
    {
        $curso->update(['activo' => !$curso->activo]);
        $estado = $curso->activo ? 'activado' : 'desactivado';

        return back()->with('success', "Curso {$estado} correctamente.");
    }
}