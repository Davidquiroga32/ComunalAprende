<?php
// ══════════════════════════════════════════════════════════
// app/Http/Controllers/Admin/AdminModulosController.php
// ══════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Modulo;
use Illuminate\Http\Request;

class AdminModulosController extends Controller
{
    public function store(Request $request, Curso $curso)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $data['curso_id'] = $curso->id;
        $data['orden']    = $curso->modulos()->max('orden') + 1;

        Modulo::create($data);

        return back()->with('success', 'Módulo creado correctamente.');
    }

    public function update(Request $request, Modulo $modulo)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $modulo->update($data);

        return back()->with('success', 'Módulo actualizado.');
    }

    public function destroy(Modulo $modulo)
    {
        $curso = $modulo->curso;
        $modulo->delete();
        
        return redirect()->route('admin.cursos.show', $curso)
                        ->with('success', 'Módulo eliminado.');
    }

    public function reordenar(Request $request, Curso $curso)
    {
        $request->validate(['orden' => 'required|array']);
        foreach ($request->orden as $index => $moduloId) {
            Modulo::where('id', $moduloId)->update(['orden' => $index + 1]);
        }
        return response()->json(['ok' => true]);
    }
}