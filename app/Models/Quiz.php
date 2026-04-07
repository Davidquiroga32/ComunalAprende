<?php
// app/Models/Quiz.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Leccion;

class Quiz extends Model
{
    protected $fillable = [
        'leccion_id','titulo','descripcion','tiempo_limite',
        'intentos_permitidos','puntaje_aprobatorio','mostrar_respuestas','aleatorio',
    ];
    protected $casts = ['mostrar_respuestas'=>'boolean','aleatorio'=>'boolean'];

    public function leccion()   { return $this->belongsTo(Leccion::class, 'leccion_id'); }
    public function preguntas() { return $this->hasMany(QuizPregunta::class,'quiz_id')->orderBy('orden'); }
    public function intentos()  { return $this->hasMany(QuizIntento::class,'quiz_id'); }

    public function intentosDeUsuario(int $userId)
    {
        return $this->intentos()->where('user_id',$userId)->orderBy('created_at','desc');
    }

    public function puedeIntentar(int $userId): bool
    {
        if ($this->intentos_permitidos === -1) return true;
        return $this->intentosDeUsuario($userId)->count() < $this->intentos_permitidos;
    }

    public function mejorIntento(int $userId)
    {
        return $this->intentosDeUsuario($userId)->orderBy('porcentaje','desc')->first();
    }
}