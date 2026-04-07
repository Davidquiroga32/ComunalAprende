<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('progreso_lecciones', function (Blueprint $table) {
            $table->integer('tiempo_visto')->default(0)->after('completado_at'); // segundos
        });
    }

    public function down(): void
    {
        Schema::table('progreso_lecciones', function (Blueprint $table) {
            $table->dropColumn('tiempo_visto');
        });
    }
};
