<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//agregamos el modelo de permisos de spatie
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [

            //Operaciones sobre tabla roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
            //Operaciones sobre la tabla periodo
            'ver-periodo',
            'crear-periodo',
            'borra-periodo',
            'editar-periodo',
            //Operacions sobre tabla usuarios
            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'borrar-usuario',
            //

            //Operacions sobre tabla materias
            'ver-materia',
            'crear-materia',
            'editar-materia',
            'borrar-materia',
            //Operacions sobre tabla grupos
            'ver-grupo',
            'crear-grupo',
            'editar-grupo',
            'borrar-grupo',
            'mi-grupo'
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name'=>$permiso]);
        }
    }
}
