<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Reemplaza la mención de la marca anterior en los artículos ya publicados.
     * El contenido nuevo ya se genera como BYT SOLUTION desde el seeder.
     */
    public function up(): void
    {
        DB::table('articulos')
            ->select(['id', 'contenido'])
            ->orderBy('id')
            ->get()
            ->each(function ($articulo) {
                $contenido = (string) $articulo->contenido;

                $nuevo = str_replace(
                    ['En Aguilar &amp; Arce', 'En Aguilar & Arce'],
                    'En BYT SOLUTION',
                    $contenido,
                );

                if ($nuevo !== $contenido) {
                    DB::table('articulos')->where('id', $articulo->id)->update(['contenido' => $nuevo]);
                }
            });
    }

    public function down(): void
    {
        // Sin reversión: el contenido editorial no se reescribe hacia atrás.
    }
};
