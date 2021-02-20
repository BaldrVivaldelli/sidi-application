<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * COMANDO PARA EJECUTAR TODO EL PORT FORWARD ngrok.exe start --all
     * @return void
     */
    public function run()
    {           
        DB::table('users')->insert([
            'name' => 'platform',
            'lastname' => 'administrator',
            'user' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('#plAy@d1t0'),
            'id_rol' => '2',
            'id_estado' => '1',
            'tipoLogeo' => 'local',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

