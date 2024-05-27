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
                'name' => 'Pedro'.($i),
                'apellidoP' => 'Marin',
                'apellidoM' => 'Mar',
                'sexo' => '0',
                'numero_tarjeta' => '121234345656787' . ($i),
                'curp' => 'BALG040506HOCFTHR' . ($i),
                'email' => 'profesor' . ($i) . '@gmail.com',
                'password' => Hash::make('123456789'),
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
                'name' => 'Uriana'.($i),
                'apellidoP' => 'Salomar',
                'apellidoM' => 'Furete',
                'sexo' => '1',
                'numero_tarjeta' => '521234345656787' . ($i),
                'curp' => 'IIGR040506HOCFTHR' . ($i),
                'email' => 'secretaria' . ($i) . '@gmail.com',
                'password' => Hash::make('123456789'),
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
