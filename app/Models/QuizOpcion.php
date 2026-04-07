<?php
// app/Models/QuizOpcion.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuizOpcion extends Model
{
    protected $table = 'quiz_opciones';
    protected $fillable = ['pregunta_id','texto','es_correcta','orden'];
    protected $casts = ['es_correcta'=>'boolean'];

    public function pregunta() { return $this->belongsTo(QuizPregunta::class,'pregunta_id'); }
}