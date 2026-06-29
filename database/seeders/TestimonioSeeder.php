<?php

namespace Database\Seeders;

use App\Models\Testimonio;
use Illuminate\Database\Seeder;

class TestimonioSeeder extends Seeder
{
    public function run(): void
    {
        Testimonio::create([
            'nombre' => 'Caitlin Garcia-Ahern',
            'cargo' => 'Directora Financiera',
            'empresa' => 'Global Venture Corp',
            'texto' => 'La capacidad de Aguilar & Arce para diseccionar problemas complejos y presentar soluciones tecnológicas claras ha sido fundamental para nuestra expansión regional.',
            'activo' => true,
        ]);

        Testimonio::create([
            'nombre' => 'Roberto Sandoval',
            'cargo' => 'CEO',
            'empresa' => 'TechStream Latin America',
            'texto' => 'Encontramos un socio que entiende la tecnología tan bien como la contabilidad. Su visión digital-first no es solo marketing, es su núcleo operacional.',
            'activo' => true,
        ]);
    }
}
