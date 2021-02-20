<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class EstadosRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('roles')->insert([
            'rol' => '1',
            'descripcion' => 'usuario',  
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')          
        ]);
        DB::table('roles')->insert([
            'rol' => '2',
            'descripcion' => 'admin',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);


        DB::table('estados')->insert([
            'estado' => 'activo',
            'tipo' => 'transmision',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')            
        ]);   
        DB::table('estados')->insert([
            'estado' => 'inactivo',
            'tipo' => 'transmision',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);   
        DB::table('estados')->insert([
            'estado' => 'inhabilitado',
            'tipo' => 'cliente',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);  
        DB::table('estados')->insert([
            'estado' => 'habilitado',
            'tipo' => 'cliente',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);          
   
    }
}

