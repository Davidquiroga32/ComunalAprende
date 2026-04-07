<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificado extends Model
{
    protected $fillable = ['user_id', 'curso_id', 'codigo', 'fecha_emision'];

    protected $casts = ['fecha_emision' => 'datetime'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($cert) {
            if (empty($cert->codigo)) {
                $cert->codigo = strtoupper(Str::random(4)) . '-' .
                                strtoupper(Str::random(4)) . '-' .
                                strtoupper(Str::random(4));
            }
        });
    }

    public function user()  { return $this->belongsTo(User::class); }
    public function curso() { return $this->belongsTo(Curso::class); }
}