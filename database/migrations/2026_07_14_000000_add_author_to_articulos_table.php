<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->string('autor_nombre')->after('imagen')->default('Aguilar & Arce');
            $table->string('autor_rol')->nullable()->after('autor_nombre');
            $table->string('autor_imagen')->nullable()->after('autor_rol');
        });
    }

    public function down(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->dropColumn(['autor_nombre', 'autor_rol', 'autor_imagen']);
        });
    }
};
