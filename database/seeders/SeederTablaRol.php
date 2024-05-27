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
        DB::table('role_has_permissions')->insert([
            ['permission_id'=>'17',
            'role_id'=>'1']
        ]);
        for($x=5;$x<=16;$x++){
                DB::table('role_has_permissions')->insert([
                    ['permission_id'=>$x,
                    'role_id'=>'2']
                ]);
        }
    }

}
