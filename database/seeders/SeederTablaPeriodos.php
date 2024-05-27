<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Periodo;
//agregamos el modelo de permisos de spatie
use Spatie\Permission\Models\Permission;

class SeederTablaPeriodos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Periodo::create([
            'nombre'=>'2024-A',
            'fechaInicio'=>'2024-02-07',
            'fechaFinal' =>'2024-06-15',
            'estado' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Periodo::create([
            'nombre'=>'2024-B',
            'fechaInicio'=>'2024-08-07',
            'fechaFinal' =>'2024-12-15',
            'estado' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
    }
}
