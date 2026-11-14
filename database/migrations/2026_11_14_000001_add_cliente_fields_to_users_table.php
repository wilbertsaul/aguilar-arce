<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol', 20)->default('cliente')->after('email');
            $table->string('ruc', 11)->nullable()->after('rol');
            $table->string('telefono', 20)->nullable()->after('ruc');
            $table->boolean('activo')->default(true)->after('telefono');
            $table->boolean('debe_cambiar_password')->default(false)->after('activo');
        });

        // Los usuarios existentes son administradores.
        \Illuminate\Support\Facades\DB::table('users')->update(['rol' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'ruc', 'telefono', 'activo', 'debe_cambiar_password']);
        });
    }
};