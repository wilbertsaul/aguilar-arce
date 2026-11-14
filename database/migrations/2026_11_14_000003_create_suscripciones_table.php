<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained('planes')->restrictOnDelete();
            $table->enum('periodo', ['mensual', 'anual'])->default('mensual');
            $table->unsignedInteger('consultas_incluidas');
            $table->unsignedInteger('consultas_usadas')->default(0);
            $table->timestamp('inicia_at')->nullable();
            $table->timestamp('expira_at')->nullable();
            $table->enum('estado', ['activa', 'vencida', 'suspendida'])->default('activa');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suscripciones');
    }
};