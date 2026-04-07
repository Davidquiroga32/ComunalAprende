<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->text('descripcion_corta')->nullable();
            $table->enum('categoria', [
                'gestion','normatividad','liderazgo',
                'proyectos','participacion','contabilidad','otro'
            ])->default('otro');
            $table->enum('tipo', ['free','paid'])->default('free');
            $table->decimal('precio', 10, 2)->default(0);
            $table->integer('duracion_horas')->default(0);
            $table->string('imagen')->nullable();
            $table->string('color_gradiente')->nullable();     // ej: "#0A4D8C,#3B88D4"
            $table->string('icono_fa')->default('fa-graduation-cap');
            $table->boolean('activo')->default(true);
            $table->boolean('destacado')->default(false);
            $table->integer('orden')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained()->cascadeOnDelete();
            $table->integer('progreso')->default(0);
            $table->boolean('completado')->default(false);
            $table->timestamp('fecha_inscripcion')->useCurrent();
            $table->timestamp('fecha_completado')->nullable();
            $table->timestamps();
            $table->unique(['user_id','curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
        Schema::dropIfExists('cursos');
    }
};