<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados')->insert([
            'nombre' => "En recorrido",
            'descripcion' => "El bus se encuentra en recorrido",
        ]);

        DB::table('estados')->insert([
            'nombre' => "Esperando pasajeros",
            'descripcion' => "El bus se encuentra esperando pasajeros, apresurate",
        ]);

        DB::table('estados')->insert([
            'nombre' => "Llenando gasolina",
            'descripcion' => "El bus se encuentra llenando gasolina, puede tardar un poco...",
        ]);
        DB::table('estados')->insert([
            'nombre' => "Fuera de servicio",
            'descripcion' => "El bus hoy no se encuentra trabajando :(",
        ]);
    }
}
