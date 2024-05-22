<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SeederTablaUsuarios extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        for ($i = 1; $i <=5; $i++) {
            DB::table('users')->insert([
                'name' => 'Pedro'.($i+1),
                'apellidoP' => 'Marin' . ($i + 1),
                'apellidoM' => 'Mar' . ($i + 1),
                'sexo' => '0',
                'numero_tarjeta' => '121234345656787' . ($i + 1),
                'curp' => 'BALG040506HOCFTHR' . ($i + 1),
                'email' => 'profesor' . ($i + 1) . '@gmail.com',
                'password' => Hash::make('123456789' . ($i + 1)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('model_has_roles')->insert([
                'role_id' => '1',
                'model_type' => 'App\Models\User',
                'model_id' => ($i + 1),
            ]);
        }
        
        for ($i = 1; $i <=5; $i++) {
            DB::table('users')->insert([
                'name' => 'Uriana'.($i+1),
                'apellidoP' => 'Salomar' . ($i + 1),
                'apellidoM' => 'Furete' . ($i + 1),
                'sexo' => '1',
                'numero_tarjeta' => '521234345656787' . ($i + 1),
                'curp' => 'IIGR040506HOCFTHR' . ($i + 1),
                'email' => 'secretaria' . ($i + 1) . '@gmail.com',
                'password' => Hash::make('123456789' . ($i + 1)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('model_has_roles')->insert([
                'role_id' => '2',
                'model_type' => 'App\Models\User',
                'model_id' => ($i + 6),
            ]);
        }
    }
}
