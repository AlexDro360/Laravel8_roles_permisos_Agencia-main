<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeederTablaRol extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Profesor',
            'guard_name'=>'web'],
            ['name' => 'Secretaria',
            'guard_name'=>'web'],
            // Puedes agregar más roles si es necesario
        ]);
    }
}
