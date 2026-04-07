<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCursosController;
use App\Http\Controllers\Admin\AdminModulosController;
use App\Http\Controllers\Admin\AdminLeccionesController;
use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\CursoPlayerController;
use App\Http\Controllers\CertificadoController;


/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [PaginasController::class, 'inicio'])->name('inicio');

Route::get('/cursos', [CursosController::class, 'index'])->name('cursos.index');
Route::get('/cursos/{curso}', [CursosController::class, 'show'])->name('cursos.show');
Route::post('/cursos/{curso}/inscribir', [CursosController::class, 'inscribir'])
    ->middleware('auth')->name('cursos.inscribir');

Route::get('/contacto', [PaginasController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [PaginasController::class, 'enviarContacto'])->name('contacto.enviar');

Route::get('/normatividad', [PaginasController::class, 'normatividad'])->name('normatividad');

Route::get('/verificar/{codigo}', [CertificadoController::class, 'verificar'])->name('certificado.verificar');
/*
|--------------------------------------------------------------------------
| Auth Breeze
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil
    Route::get('/dashboard/perfil',   [DashboardController::class, 'editarPerfil'])->name('dashboard.perfil');
    Route::put('/dashboard/perfil',   [DashboardController::class, 'actualizarPerfil'])->name('dashboard.perfil.update');
    Route::put('/dashboard/password', [DashboardController::class, 'cambiarPassword'])->name('dashboard.password.update');

    // Mis cursos
    Route::get('/dashboard/mis-cursos', [DashboardController::class, 'misCursos'])->name('dashboard.cursos');

    // Certificados
    Route::get('/dashboard/certificados', [DashboardController::class, 'certificados'])->name('dashboard.certificados');

    // Quiz
    Route::get('/quiz/{quiz}',                        [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quiz}/iniciar',               [QuizController::class, 'iniciar'])->name('quiz.iniciar');
    Route::post('/quiz/intento/{intento}/enviar',     [QuizController::class, 'enviar'])->name('quiz.enviar');
    Route::get('/quiz/intento/{intento}/resultado',   [QuizController::class, 'resultado'])->name('quiz.resultado');

    // Reproductor de curso
    Route::get('/aprender/{slug}',              [CursoPlayerController::class, 'show'])->name('curso.player');
    Route::get('/aprender/{slug}/{leccion}',    [CursoPlayerController::class, 'show'])->name('curso.player.leccion');
    Route::post('/leccion/{leccion}/completar', [CursoPlayerController::class, 'completar'])->name('leccion.completar');
    Route::post('/leccion/{leccion}/tiempo',    [CursoPlayerController::class, 'registrarTiempo'])->name('leccion.tiempo');

    // Certificados
    Route::get('/certificado/{curso}/descargar', [CertificadoController::class, 'descargar'])->name('certificado.descargar');
});


/*
|--------------------------------------------------------------------------
| Auth routes Breeze
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'es_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/',            [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/estudiantes', [AdminDashboardController::class, 'estudiantes'])->name('estudiantes');

    // CRUD Cursos
    Route::resource('cursos', AdminCursosController::class);
    Route::patch('cursos/{curso}/toggle',    [AdminCursosController::class, 'toggleActivo'])->name('cursos.toggle');
    Route::get('cursos/{curso}/estudiantes', [AdminCursosController::class, 'estudiantes'])->name('cursos.estudiantes');

    // Módulos
    Route::post('cursos/{curso}/modulos',       [AdminModulosController::class, 'store'])->name('modulos.store');
    Route::put('modulos/{modulo}',              [AdminModulosController::class, 'update'])->name('modulos.update');
    Route::delete('modulos/{modulo}',           [AdminModulosController::class, 'destroy'])->name('modulos.destroy');
    Route::post('cursos/{curso}/modulos/orden', [AdminModulosController::class, 'reordenar'])->name('modulos.reordenar');

    // Lecciones
    Route::get('modulos/{modulo}/lecciones/create', [AdminLeccionesController::class, 'create'])->name('lecciones.create');
    Route::post('modulos/{modulo}/lecciones',        [AdminLeccionesController::class, 'store'])->name('lecciones.store');
    Route::get('lecciones/{leccion}/edit',           [AdminLeccionesController::class, 'edit'])->name('lecciones.edit');
    Route::put('lecciones/{leccion}',                [AdminLeccionesController::class, 'update'])->name('lecciones.update');
    Route::delete('lecciones/{leccion}',             [AdminLeccionesController::class, 'destroy'])->name('lecciones.destroy');

    // Upload de imágenes para TinyMCE
    Route::post('lecciones/upload-imagen', [AdminLeccionesController::class, 'uploadImagen'])->name('lecciones.upload-imagen');

    // Quiz
    Route::get('lecciones/{leccion}/quiz',     [AdminQuizController::class, 'edit'])->name('quiz.edit');
    Route::post('lecciones/{leccion}/quiz',    [AdminQuizController::class, 'save'])->name('quiz.save');
    Route::post('quiz/{quiz}/pregunta',        [AdminQuizController::class, 'agregarPregunta'])->name('quiz.agregarPregunta');
    Route::put('pregunta/{pregunta}',          [AdminQuizController::class, 'actualizarPregunta'])->name('quiz.actualizarPregunta');
    Route::delete('pregunta/{pregunta}',       [AdminQuizController::class, 'eliminarPregunta'])->name('quiz.eliminarPregunta');
    Route::get('quiz/{quiz}/estadisticas',     [AdminQuizController::class, 'estadisticas'])->name('quiz.estadisticas');
});