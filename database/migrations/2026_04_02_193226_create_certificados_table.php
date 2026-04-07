<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained()->cascadeOnDelete();
            $table->string('codigo')->unique(); // UUID de verificación
            $table->timestamp('fecha_emision');
            $table->timestamps();
            $table->unique(['user_id', 'curso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
