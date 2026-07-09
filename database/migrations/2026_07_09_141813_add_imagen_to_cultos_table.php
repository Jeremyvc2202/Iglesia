<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cultos', function (Blueprint $table) {
            // Solo añadimos la columna si NO existe
            if (!Schema::hasColumn('cultos', 'imagen')) {
                $table->string('imagen')->nullable()->after('horario');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cultos', function (Blueprint $table) {
            // Solo eliminamos la columna si existe
            if (Schema::hasColumn('cultos', 'imagen')) {
                $table->dropColumn('imagen');
            }
        });
    }
};