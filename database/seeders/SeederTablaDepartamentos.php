<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Departamento;
//agregamos el modelo de permisos de spatie
use Spatie\Permission\Models\Permission;

class SeederTablaDepartamentos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create([
            'nombre'=>'Ciencias Basicas',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Departamento::create([
            'nombre'=>'Sistemas Computacionales',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
    }
}
