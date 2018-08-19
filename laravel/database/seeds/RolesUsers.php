<?php

use Illuminate\Database\Seeder;

class RolesUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('roles')->insert([
            [
                'name' => 'adm',
                'description' => 'creador de Usuarios'
            ],
            [
                'name' => 'usr',
                'description' => 'usuario generador de qrs'
            ]
        ]);
    }
}
