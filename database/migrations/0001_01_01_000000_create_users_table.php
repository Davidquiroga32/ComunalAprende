<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Datos básicos
            $table->string('name');                                    // Nombre completo
            $table->string('documento')->unique();                     // Documento de identidad
            $table->string('email')->unique();                         // Correo electrónico
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Ubicación
            $table->string('departamento', 100)->nullable();           // Departamento
            $table->string('municipio', 150)->nullable();              // Municipio

            // Contacto
            $table->string('celular', 20)->nullable();                 // Número de celular

            // Acción comunal
            $table->boolean('pertenece_oac')->default(false);          // ¿Pertenece a OAC?
            $table->string('organismo_accion_comunal')->nullable();    // Nombre del organismo

            // Condición
            $table->enum('condicion', ['afiliado', 'particular'])
                  ->default('particular');                             // Afiliado o Particular

            // Rol en el sistema
            $table->enum('role', ['student', 'admin'])->default('student');

            // Perfil adicional
            $table->string('avatar')->nullable();
            $table->boolean('newsletter')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};