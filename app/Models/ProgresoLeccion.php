<?php
// app/Models/ProgresoLeccion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoLeccion extends Model
{
    protected $table = 'progreso_lecciones'; 

    protected $fillable = ['user_id','leccion_id','completado','completado_at','tiempo_visto'];
    protected $casts    = ['completado' => 'boolean', 'completado_at' => 'datetime'];

    public function user()    { return $this->belongsTo(User::class); }
    public function leccion() { return $this->belongsTo(Leccion::class); }
}