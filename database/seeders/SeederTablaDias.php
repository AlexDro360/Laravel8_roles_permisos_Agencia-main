<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dia;

class SeederTablaDias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dias = [

            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
            'Domingo'
        ];

        foreach($dias as $dia) {
            Dia::create(['nombre'=>$dia]);
        }
    }
}
