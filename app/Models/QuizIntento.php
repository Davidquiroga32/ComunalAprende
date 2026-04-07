<?php
// app/Models/QuizIntento.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class QuizIntento extends Model
{
    protected $table = 'quiz_intentos';
    protected $fillable = [
        'user_id','quiz_id','puntaje','puntaje_total',
        'porcentaje','aprobado','iniciado_at','finalizado_at','tiempo_usado',
    ];
    protected $casts = [
        'aprobado'      => 'boolean',
        'iniciado_at'   => 'datetime',
        'finalizado_at' => 'datetime',
        'porcentaje'    => 'decimal:2',
    ];

    public function quiz()      { return $this->belongsTo(Quiz::class); }
    public function user()      { return $this->belongsTo(User::class); }
    public function respuestas(){ return $this->hasMany(QuizRespuesta::class,'intento_id'); }
}