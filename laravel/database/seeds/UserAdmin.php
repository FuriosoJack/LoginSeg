<?php

use Illuminate\Database\Seeder;

class UserAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            ['name' => 'Admin', 'lastname' => 'Admin', 'username' => 'admin', 'password' => bcrypt('admin')]
        ]);

        \Illuminate\Support\Facades\DB::table('rol_user')->insert([
            ['user_id' => 1, 'rol_id' => 1]
        ]);

    }
}
