<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->text('imagen')->nullable()->change();
            $table->text('autor_imagen')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('articulos', function (Blueprint $table) {
            $table->string('imagen')->nullable()->change();
            $table->string('autor_imagen')->nullable()->change();
        });
    }
};
