<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Grupo;
use App\Models\Horario;
//agregamos el modelo de permisos de spatie
use Spatie\Permission\Models\Permission;

class SeederTablaGrupos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profesores = User::role('profesor')->get();
        $materia = 1;
        $periodo = 2024;
        

        foreach($profesores as $profesor) {
            Grupo::create([
                'clave'=>'6SA',
                'cupo' =>'30',
                'users_id' => $profesor->id,
                'materias_id' => $materia,
                'periodos_id'=> '1',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $periodo--;
            $materia++;
        }

        $periodo = 2024;
        foreach($profesores as $profesor) {
            Grupo::create([
                'clave'=>'6SA',
                'cupo' =>'30',
                'users_id' => $profesor->id,
                'materias_id' => $materia,
                'periodos_id'=> '1',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $periodo--;
            $materia++;
        }

        foreach($profesores as $profesor) {
            $periodo--;
            $materia--;
            Grupo::create([
                'clave'=>'6SA',
                'cupo' =>'30',
                'users_id' => $profesor->id,
                'materias_id' => $materia,
                'periodos_id'=> '2',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $hora = 7;
        $grupos = Grupo::all();
        foreach($grupos as $grupo) {
            for ($i = 1; $i <=5; $i++) {
                Horario::create([
                    'horaInicio'=>($hora).':00:00',
                    'horaFin'=>($hora+1).':00:00',
                    'dias_id' =>$i,
                    'grupos_id' => $grupo->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            $hora++;
        }
    }
}
