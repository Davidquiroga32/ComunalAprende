<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leccion_id')->unique()->constrained('lecciones')->cascadeOnDelete();
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('tiempo_limite')->nullable();
            $table->integer('intentos_permitidos')->default(3);
            $table->integer('puntaje_aprobatorio')->default(70);
            $table->boolean('mostrar_respuestas')->default(true);
            $table->boolean('aleatorio')->default(false);
            $table->timestamps();
        });

        Schema::create('quiz_preguntas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('pregunta');
            $table->enum('tipo', ['opcion_multiple','multiple_respuesta','verdadero_falso','texto_libre'])->default('opcion_multiple');
            $table->text('explicacion')->nullable();
            $table->integer('puntos')->default(1);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz_opciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregunta_id')->constrained('quiz_preguntas')->cascadeOnDelete();
            $table->text('texto');
            $table->boolean('es_correcta')->default(false);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz_intentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->integer('puntaje')->default(0);
            $table->integer('puntaje_total')->default(0);
            $table->decimal('porcentaje', 5, 2)->default(0);
            $table->boolean('aprobado')->default(false);
            $table->timestamp('iniciado_at')->useCurrent();
            $table->timestamp('finalizado_at')->nullable();
            $table->integer('tiempo_usado')->nullable();
            $table->timestamps();
        });

        Schema::create('quiz_respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intento_id')->constrained('quiz_intentos')->cascadeOnDelete();
            $table->foreignId('pregunta_id')->constrained('quiz_preguntas')->cascadeOnDelete();
            $table->text('respuesta_texto')->nullable();
            $table->boolean('es_correcta')->nullable();
            $table->integer('puntos_obtenidos')->default(0);
            $table->timestamps();
        });

        Schema::create('quiz_respuesta_opciones', function (Blueprint $table) {
            $table->foreignId('respuesta_id')->constrained('quiz_respuestas')->cascadeOnDelete();
            $table->foreignId('opcion_id')->constrained('quiz_opciones')->cascadeOnDelete();
            $table->primary(['respuesta_id','opcion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_respuesta_opciones');
        Schema::dropIfExists('quiz_respuestas');
        Schema::dropIfExists('quiz_intentos');
        Schema::dropIfExists('quiz_opciones');
        Schema::dropIfExists('quiz_preguntas');
        Schema::dropIfExists('quizzes');
    }
};