<?php
// app/Http/Controllers/Admin/AdminQuizController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leccion;
use App\Models\Quiz;
use App\Models\QuizPregunta;
use App\Models\QuizOpcion;
use Illuminate\Http\Request;

class AdminQuizController extends Controller
{
    /** Crear/editar quiz de una lección */
    public function edit(Leccion $leccion)
    {
        $leccion->load('modulo.curso');

        $quiz = $leccion->quiz;

        if ($quiz) {
            $quiz->load('preguntas.opciones');
        } else {
            $quiz = new Quiz(['leccion_id' => $leccion->id]);
        }

        $curso  = $leccion->modulo->curso;
        $modulo = $leccion->modulo;

        return view('admin.quiz.edit', compact('leccion', 'quiz', 'curso', 'modulo'));
    }

    /** Guardar configuración del quiz */
    public function save(Request $request, Leccion $leccion)
    {
        $data = $request->validate([
            'titulo'              => 'nullable|string|max:255',
            'descripcion'         => 'nullable|string',
            'tiempo_limite'       => 'nullable|integer|min:1|max:300',
            'intentos_permitidos' => 'required|integer|min:-1',
            'puntaje_aprobatorio' => 'required|integer|min:1|max:100',
            'mostrar_respuestas'  => 'nullable|boolean',
            'aleatorio'           => 'nullable|boolean',
        ]);

        $data['mostrar_respuestas'] = $request->boolean('mostrar_respuestas');
        $data['aleatorio']          = $request->boolean('aleatorio');
        $data['leccion_id']         = $leccion->id;

        Quiz::updateOrCreate(['leccion_id' => $leccion->id], $data);

        return redirect()->route('admin.quiz.edit', $leccion)
                ->with('success', 'Configuración del quiz guardada.');
    }

    /** Agregar pregunta */
    public function agregarPregunta(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'pregunta'    => 'required|string',
            'tipo'        => 'required|in:opcion_multiple,multiple_respuesta,verdadero_falso,texto_libre',
            'puntos'      => 'required|integer|min:1',
            'explicacion' => 'nullable|string',
        ]);

        $data['quiz_id'] = $quiz->id;
        $data['orden']   = $quiz->preguntas()->max('orden') + 1;

        $pregunta = QuizPregunta::create($data);

        // Auto-crear opciones para verdadero/falso
        if ($data['tipo'] === 'verdadero_falso') {
            QuizOpcion::create(['pregunta_id'=>$pregunta->id,'texto'=>'Verdadero','es_correcta'=>false,'orden'=>1]);
            QuizOpcion::create(['pregunta_id'=>$pregunta->id,'texto'=>'Falso','es_correcta'=>false,'orden'=>2]);
        }

        return back()->with('success', 'Pregunta agregada.');
    }

    /** Actualizar pregunta + sus opciones */
    public function actualizarPregunta(Request $request, QuizPregunta $pregunta)
    {
        $data = $request->validate([
            'pregunta'       => 'required|string',
            'tipo'           => 'required|in:opcion_multiple,multiple_respuesta,verdadero_falso,texto_libre',
            'puntos'         => 'required|integer|min:1',
            'explicacion'    => 'nullable|string',
            'opciones'       => 'nullable|array',
            'opciones.*.id'  => 'nullable|exists:quiz_opciones,id',
            'opciones.*.texto'      => 'required_with:opciones|string',
            'opciones.*.es_correcta'=> 'nullable',
        ]);

        $pregunta->update([
            'pregunta'    => $data['pregunta'],
            'tipo'        => $data['tipo'],
            'puntos'      => $data['puntos'],
            'explicacion' => $data['explicacion'] ?? null,
        ]);

        // Sincronizar opciones
        if (!empty($data['opciones'])) {
            $idsExistentes = [];
            foreach ($data['opciones'] as $index => $op) {
                $opData = [
                    'pregunta_id' => $pregunta->id,
                    'texto'       => $op['texto'],
                    'es_correcta' => isset($op['es_correcta']) && $op['es_correcta'] == '1',
                    'orden'       => $index + 1,
                ];

                if (!empty($op['id'])) {
                    QuizOpcion::where('id', $op['id'])->update($opData);
                    $idsExistentes[] = (int)$op['id'];
                } else {
                    $nueva = QuizOpcion::create($opData);
                    $idsExistentes[] = $nueva->id;
                }
            }
            // Eliminar opciones que ya no existen
            $pregunta->opciones()->whereNotIn('id', $idsExistentes)->delete();
        }

        return back()->with('success', 'Pregunta actualizada.');
    }

    /** Eliminar pregunta */
    public function eliminarPregunta(QuizPregunta $pregunta)
    {
        $leccionId = $pregunta->quiz->leccion_id;
        $pregunta->delete();

        return redirect()->route('admin.quiz.edit', $leccionId)
                        ->with('success', 'Pregunta eliminada.');
    }

    /** Estadísticas del quiz */
    public function estadisticas(Quiz $quiz)
    {
        $intentos = $quiz->intentos()->with('user')->orderByDesc('created_at')->get();
        $stats = [
            'total_intentos'  => $intentos->count(),
            'aprobados'       => $intentos->where('aprobado', true)->count(),
            'promedio'        => round($intentos->avg('porcentaje'), 1),
            'mejor_puntaje'   => $intentos->max('porcentaje'),
            'usuarios_unicos' => $intentos->pluck('user_id')->unique()->count(),
        ];

        return view('admin.quiz.estadisticas', compact('quiz','intentos','stats'));
    }
}