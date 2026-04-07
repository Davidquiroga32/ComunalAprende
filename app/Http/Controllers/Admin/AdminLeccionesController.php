<?php
// app/Http/Controllers/Admin/AdminLeccionesController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Models\Leccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\CloudinaryService;

class AdminLeccionesController extends Controller
{
    public function create(Modulo $modulo)
    {
        $curso = $modulo->curso;
        return view('admin.lecciones.create', compact('modulo','curso'));
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
            'video_archivo'    => 'nullable|file|mimes:mp4,mov,avi,webm|max:512000', // 500MB
            'duracion_minutos' => 'nullable|integer|min:0',
            'activo'           => 'nullable|boolean',
        ]);

        $data['modulo_id'] = $modulo->id;
        $data['orden']     = $modulo->lecciones()->max('orden') + 1;
        $data['activo']    = $request->boolean('activo', true);

        if ($request->hasFile('archivo')) {
            $cloudinary = app(CloudinaryService::class);
            $res = $cloudinary->subir($request->file('archivo'), 'lecciones/pdfs', 'raw');
            $data['archivo'] = $res['url'];
        }

        if ($request->hasFile('video_archivo')) {
            $cloudinary = app(CloudinaryService::class);
            $res = $cloudinary->subir($request->file('video_archivo'), 'lecciones/videos', 'video');
            $data['video_url']   = $res['url'];
            $data['video_local'] = $res['public_id']; // guardamos public_id para borrar después
        }

        Leccion::create($data);

        return redirect()->route('admin.cursos.show', $modulo->curso)
                        ->with('success', 'Lección creada correctamente.');
    }

    public function edit(Leccion $leccion)
    {
        $modulo = $leccion->modulo;
        $curso  = $modulo->curso;
        return view('admin.lecciones.edit', compact('leccion','modulo','curso'));
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
            $cloudinary = app(CloudinaryService::class);
            $cloudinary->eliminar(CloudinaryService::urlAPublicId($leccion->archivo ?? ''), 'raw');
            $res = $cloudinary->subir($request->file('archivo'), 'lecciones/pdfs', 'raw');
            $data['archivo'] = $res['url'];
        }

        if ($request->hasFile('video_archivo')) {
            $cloudinary = app(CloudinaryService::class);
            if ($leccion->video_local) $cloudinary->eliminar($leccion->video_local, 'video');
            $res = $cloudinary->subir($request->file('video_archivo'), 'lecciones/videos', 'video');
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
        $cloudinary = app(CloudinaryService::class);
        if ($leccion->archivo)     $cloudinary->eliminar(CloudinaryService::urlAPublicId($leccion->archivo), 'raw');
        if ($leccion->video_local) $cloudinary->eliminar($leccion->video_local, 'video');
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

        $cloudinary = app(CloudinaryService::class);
        $resultado  = $cloudinary->subir($request->file('file'), 'lecciones/imagenes', 'image');

        return response()->json([
            'location' => $resultado['url'],
        ]);
    }
}