<?php
// app/Models/QuizPregunta.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuizPregunta extends Model
{
    protected $table = 'quiz_preguntas';
    protected $fillable = ['quiz_id','pregunta','tipo','explicacion','puntos','orden'];

    public function quiz()    { return $this->belongsTo(Quiz::class); }
    public function opciones(){ return $this->hasMany(QuizOpcion::class,'pregunta_id')->orderBy('orden'); }

    public function tipoLabel(): string
    {
        return match($this->tipo) {
            'opcion_multiple'   => 'Opción Múltiple',
            'multiple_respuesta'=> 'Múltiple Respuesta',
            'verdadero_falso'   => 'Verdadero / Falso',
            'texto_libre'       => 'Texto Libre',
            default             => 'Opción Múltiple',
        };
    }
}