<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultorias', function (Blueprint $table) {
            $table->string('empresa_ruc')->nullable()->after('nombre');
            $table->string('whatsapp')->nullable()->after('email');
            $table->string('etapa')->nullable()->after('whatsapp');
            $table->string('requerimientos')->nullable()->after('etapa');
            $table->text('mensaje')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('consultorias', function (Blueprint $table) {
            $table->dropColumn(['empresa_ruc', 'whatsapp', 'etapa', 'requerimientos']);
            $table->text('mensaje')->nullable(false)->change();
        });
    }
};
