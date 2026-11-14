<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('suscripcion_id')->nullable()->constrained('suscripciones')->nullOnDelete();
            $table->string('tipo', 20)->default('individual'); // individual | lote
            $table->string('ruc_emisor', 11)->nullable();
            $table->string('tipo_comprobante', 5)->nullable();
            $table->string('serie', 10)->nullable();
            $table->string('correlativo', 20)->nullable();
            $table->json('documentos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumos');
    }
};