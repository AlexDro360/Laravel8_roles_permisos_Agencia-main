<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//agregamos el modelo de permisos de spatie
use Spatie\Permission\Models\Permission;

class SeederTablaMaterias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materias = [
            'Calculo Diferencial',
            'Fundamentos de programación',
            'Administracion de Base de datos',
            'Taller de Sistemas Operativos',
            'Ingenieria de Software',
            'Lenguaje de Interfaz',
            'Graficación',
            'Lenguajes y Automatas',
            'Redes de Computadoras',
            'Sistemas Operativos'
        ];

        $clave = 1000;

        foreach($materias as $permiso) {
            DB::table('materias')->insert(['nombre'=>$permiso,
            'clave'=>'SCB'.($clave),
            'creditos'=>'5',
            'num_unidades'=>'5',
            'estado'=>'1',
            'departamentos_id'=>'1',
            'created_at' => now(),
            'updated_at' => now()
            ]);
            $clave++;
        }
    }
}
