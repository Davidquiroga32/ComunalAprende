<?php
// app/Models/Leccion.php
namespace App\Models;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;

class Leccion extends Model
{
    protected $table = 'lecciones'; 

    protected $fillable = [
        'modulo_id','titulo','contenido','tipo_contenido',
        'video_url','video_local','archivo','duracion_minutos','orden','activo',
    ];

    protected $casts = ['activo' => 'boolean'];

    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class, 'leccion_id');
    }

    public function progresosUsuarios()
    {
        return $this->hasMany(ProgresoLeccion::class);
    }

    public function tipoLabel(): string
    {
        return match($this->tipo_contenido) {
            'texto'  => 'Texto',
            'video'  => 'Video',
            'pdf'    => 'PDF',
            'quiz'   => 'Quiz',
            'tarea'  => 'Tarea',
            default  => 'Texto',
        };
    }
}