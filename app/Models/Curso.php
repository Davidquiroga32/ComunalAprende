<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Curso extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'titulo','slug','descripcion','descripcion_corta',
        'categoria','tipo','precio','duracion_horas',
        'imagen','color_gradiente','icono_fa',
        'activo','destacado','orden','created_by',
    ];

    protected $casts = [
        'activo'    => 'boolean',
        'destacado' => 'boolean',
        'precio'    => 'decimal:2',
    ];

    // ── Auto-slug ─────────────────────────────────
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($curso) {
            if (empty($curso->slug)) {
                $curso->slug = Str::slug($curso->titulo);
            }
        });
    }

    // ── Relaciones ────────────────────────────────
    public function modulos()
    {
        return $this->hasMany(Modulo::class)->orderBy('orden');
    }

    public function lecciones()
    {
        return $this->hasManyThrough(Leccion::class, Modulo::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'inscripciones')
                    ->withPivot('progreso','completado','fecha_inscripcion','fecha_completado')
                    ->withTimestamps();
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Helpers ───────────────────────────────────
    public function categoriaLabel(): string
    {
        return match($this->categoria) {
            'gestion'       => 'Gestión Comunal',
            'normatividad'  => 'Normatividad',
            'liderazgo'     => 'Liderazgo',
            'proyectos'     => 'Formulación de Proyectos',
            'participacion' => 'Participación Ciudadana',
            'contabilidad'  => 'Contabilidad',
            default         => 'Otro',
        };
    }

    public function precioFormateado(): string
    {
        return $this->tipo === 'free' ? 'Gratis' : '$'.number_format($this->precio, 0, ',', '.');
    }

    public function totalEstudiantes(): int
    {
        return $this->estudiantes()->count();
    }

    public function totalLecciones(): int
    {
        return $this->lecciones()->count();
    }
}