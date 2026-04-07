<?php
// app/Http/Controllers/Admin/AdminDashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalCursos      = Curso::count();
        $cursosActivos    = Curso::where('activo', true)->count();
        $totalEstudiantes = User::where('role', 'student')->count();
        $totalInscripciones = \DB::table('inscripciones')->count();

        $cursosRecientes = Curso::withCount('estudiantes')
                                ->orderBy('created_at','desc')
                                ->take(5)->get();

        $estudiantesRecientes = User::where('role','student')
                                    ->orderBy('created_at','desc')
                                    ->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCursos','cursosActivos','totalEstudiantes',
            'totalInscripciones','cursosRecientes','estudiantesRecientes'
        ));
    }

    public function estudiantes()
    {
        $estudiantes = User::where('role','student')
                        ->withCount('cursos')
                        ->orderBy('created_at','desc')
                        ->paginate(20);

        return view('admin.estudiantes', compact('estudiantes'));
    }
}