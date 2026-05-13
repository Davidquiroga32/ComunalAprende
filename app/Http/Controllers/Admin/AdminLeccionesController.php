<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Models\Leccion;
use Illuminate\Http\Request;
use App\Services\B2Service;

class AdminLeccionesController extends Controller
{
    public function create(Modulo $modulo)
    {
        $curso = $modulo->curso;

        return view('admin.lecciones.create', compact('modulo', 'curso'));
    }

    public function store(Request $request, Modulo $modulo)
    {
        $data = $request->validate([
            'titulo'           => 'required|string|max:255',
            'tipo_contenido'   => 'required|in:texto,video,pdf,quiz,tarea',
            'contenido'        => 'nullable|string',
            'video_url'        => 'nullable|url|max:500',
            'archivo'          => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'video_archivo'    => 'nullable|file|mimes:mp4,mov,avi,webm|max:512000',
            'duracion_minutos' => 'nullable|integer|min:0',
            'activo'           => 'nullable|boolean',
        ]);

        $data['modulo_id'] = $modulo->id;
        $data['orden']     = $modulo->lecciones()->max('orden') + 1;
        $data['activo']    = $request->boolean('activo', true);

        if ($request->hasFile('archivo')) {
            $b2  = app(B2Service::class);
            $res = $b2->subir($request->file('archivo'), 'lecciones/pdfs', 'raw');
            $data['archivo'] = $res['url'];
        }

        if ($request->hasFile('video_archivo')) {
            $b2  = app(B2Service::class);
            $res = $b2->subir($request->file('video_archivo'), 'lecciones/videos', 'video');
            $data['video_url']   = $res['url'];
            $data['video_local'] = $res['public_id'];
        }

        Leccion::create($data);

        return redirect()->route('admin.cursos.show', $modulo->curso)
            ->with('success', 'Lección creada correctamente.');
    }

    public function edit(Leccion $leccion)
    {
        $modulo = $leccion->modulo;
        $curso  = $modulo->curso;

        return view('admin.lecciones.edit', compact('leccion', 'modulo', 'curso'));
    }

    public function update(Request $request, Leccion $leccion)
    {
        $data = $request->validate([
            'titulo'           => 'required|string|max:255',
            'tipo_contenido'   => 'required|in:texto,video,pdf,quiz,tarea',
            'contenido'        => 'nullable|string',
            'video_url'        => 'nullable|url|max:500',
            'archivo'          => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'video_archivo'    => 'nullable|file|mimes:mp4,mov,avi,webm|max:512000',
            'duracion_minutos' => 'nullable|integer|min:0',
            'activo'           => 'nullable|boolean',
        ]);

        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('archivo')) {
            $b2 = app(B2Service::class);
            $b2->eliminar(B2Service::urlAPublicId($leccion->archivo ?? ''));
            $res = $b2->subir($request->file('archivo'), 'lecciones/pdfs', 'raw');
            $data['archivo'] = $res['url'];
        }

        if ($request->hasFile('video_archivo')) {
            $b2 = app(B2Service::class);
            if ($leccion->video_local) {
                $b2->eliminar($leccion->video_local);
            }
            $res = $b2->subir($request->file('video_archivo'), 'lecciones/videos', 'video');
            $data['video_url']   = $res['url'];
            $data['video_local'] = $res['public_id'];
        }

        $leccion->update($data);

        return redirect()->route('admin.cursos.show', $leccion->modulo->curso)
            ->with('success', 'Lección actualizada correctamente.');
    }

    public function destroy(Leccion $leccion)
    {
        $curso = $leccion->modulo->curso;
        $b2    = app(B2Service::class);

        if ($leccion->archivo) {
            $b2->eliminar(B2Service::urlAPublicId($leccion->archivo));
        }
        if ($leccion->video_local) {
            $b2->eliminar($leccion->video_local);
        }

        $leccion->delete();

        return redirect()->route('admin.cursos.show', $curso)
            ->with('success', 'Lección eliminada.');
    }

    /**
     * Sube una imagen desde el editor TinyMCE y retorna su URL.
     * Ruta: POST /admin/lecciones/upload-imagen
     */
    public function uploadImagen(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ]);

        $b2        = app(B2Service::class);
        $resultado = $b2->subir($request->file('file'), 'lecciones/imagenes', 'image');

        return response()->json([
            'location' => $resultado['url'],
        ]);
    }
}