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
        $materiasC = [
            'Calculo Diferencial',
            'Calculo Integral',
            'Probabilidad y estadística',
            'Ecuaciones diferenciales',
            'Matematicas discretas'
        ];
        $materiasS = [
            'Fundamentos de programación',
            'Administracion de Base de datos',
            'Taller de Sistemas Operativos',
            'Lenguaje de Interfaz',
            'Graficación',
            'Lenguajes y Automatas',
            'Redes de Computadoras',
        ];

        $clave = 1000;

        foreach($materiasC as $permiso) {
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
        foreach($materiasS as $permiso) {
            DB::table('materias')->insert(['nombre'=>$permiso,
            'clave'=>'SCB'.($clave),
            'creditos'=>'5',
            'num_unidades'=>'5',
            'estado'=>'1',
            'departamentos_id'=>'2',
            'created_at' => now(),
            'updated_at' => now()
            ]);
            $clave++;
        }
    }
}
