<?php
// app/Models/QuizRespuesta.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuizRespuesta extends Model
{
    protected $table = 'quiz_respuestas';
    protected $fillable = ['intento_id','pregunta_id','respuesta_texto','es_correcta','puntos_obtenidos'];
    protected $casts = ['es_correcta'=>'boolean'];

    public function intento()  { return $this->belongsTo(QuizIntento::class,'intento_id'); }
    public function pregunta() { return $this->belongsTo(QuizPregunta::class,'pregunta_id'); }
    public function opciones() {
        return $this->belongsToMany(QuizOpcion::class,'quiz_respuesta_opciones','respuesta_id','opcion_id');
    }
}