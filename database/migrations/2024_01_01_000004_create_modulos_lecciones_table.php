<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Módulos: agrupan lecciones dentro de un curso
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained()->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        // Lecciones: contenido individual dentro de un módulo
        Schema::create('lecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modulo_id')->constrained()->cascadeOnDelete();
            $table->string('titulo');
            $table->longText('contenido')->nullable();          // HTML/Markdown
            $table->enum('tipo_contenido', [
                'texto','video','pdf','quiz','tarea'
            ])->default('texto');
            $table->string('video_url')->nullable();
            $table->string('archivo')->nullable();
            $table->integer('duracion_minutos')->default(0);
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Progreso individual por lección
        Schema::create('progreso_lecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('leccion_id')->constrained('lecciones')->cascadeOnDelete();
            $table->boolean('completado')->default(false);
            $table->timestamp('completado_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id','leccion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progreso_lecciones');
        Schema::dropIfExists('lecciones');
        Schema::dropIfExists('modulos');
    }
};