<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Caché neutral de consultas DNI/RUC.
     *
     * Diseñada para poder moverse tal cual a la base compartida
     * `consultas_pe` (BYTFACT + IziPay): solo cambia la conexión.
     */
    public function up(): void
    {
        Schema::create('consultas_documento', function (Blueprint $table) {
            $table->id();
            $table->char('lookup_hash', 64)->unique();
            $table->string('tipo', 3);
            $table->text('nombre');
            $table->longText('datos')->nullable();
            $table->string('fuente', 20)->default('jsonpe');
            $table->unsignedInteger('hits')->default(0);
            $table->timestamp('consultado_at');
            $table->timestamp('expira_at');
            $table->timestamps();

            $table->index('expira_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas_documento');
    }
};
