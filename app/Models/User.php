<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'documento',
        'email',
        'password',
        'departamento',
        'municipio',
        'celular',
        'pertenece_oac',
        'organismo_accion_comunal',
        'condicion',
        'role',
        'avatar',
        'newsletter',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'pertenece_oac'     => 'boolean',
            'newsletter'        => 'boolean',
        ];
    }

    // ── Helpers de rol ──────────────────────────────
    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    // ── Relaciones ───────────────────────────────────
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'inscripciones')
                    ->withPivot('progreso', 'completado', 'fecha_inscripcion')
                    ->withTimestamps();
    }

    /**
     * Usar la notificación personalizada en español para reset de contraseña.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}