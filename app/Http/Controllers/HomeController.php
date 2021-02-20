<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Regions;
use DB; 
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $contenidos = DB::table('contenidos')->get();
        $regions = array();
        
        foreach ($contenidos as $contenido){
            $region = array();
            $region['name'] = $contenido->nombre;
            $region['cant_disp'] = DB::table('clientes')->where('id_contenido',$contenido->id)->count();
            $id_estado = $contenido->id_estado;
            $auxEstate =  DB::table('estados')->where('id',$id_estado)->first();
            $region['estado'] = $auxEstate->estado;                
            $region['region_size'] = $contenido->formato_template;

            if($contenido->id_archivo_uno != null){
                $id_archivo_uno = DB::table('archivos')->where('id',$contenido->id_archivo_uno)->first();                
                $region['archivoUnoUrl'] = $id_archivo_uno->youtube_url;
                $region['archivoUnoTipo'] = $id_archivo_uno->tipo;
                $region['archivoUnoUbicacion'] = $id_archivo_uno->ubicacion;
                $region['archivoUnoTexto'] = $id_archivo_uno->texto_archivo;
            }
            if($contenido->id_archivo_dos != null){
                $id_archivo_dos = DB::table('archivos')->where('id',$contenido->id_archivo_dos)->first();     
                $region['archivoDosUrl'] = $id_archivo_dos->youtube_url;
                $region['archivoDosTipo'] = $id_archivo_dos->tipo;
                $region['archivoDosUbicacion'] = $id_archivo_dos->ubicacion;          
                $region['archivoDosTexto'] = $id_archivo_dos->texto_archivo;
            }
            if($contenido->id_archivo_tres != null){
                $id_archivo_tres = DB::table('archivos')->where('id',$contenido->id_archivo_tres)->first();  
                $region['archivoTresUrl'] = $id_archivo_tres->youtube_url;
                $region['archivoTresTipo'] =  $id_archivo_tres->tipo;     
                $region['archivoTresUbicacion'] = $id_archivo_tres->ubicacion;                
                $region['archivoTresTexto'] = $id_archivo_tres->texto_archivo;
            }
            if($contenido->id_archivo_cuatro != null){
                $id_archivo_cuatro = DB::table('archivos')->where('id',$contenido->id_archivo_cuatro)->first();                
                $region['archivoCuatroUrl'] = $id_archivo_cuatro->youtube_url;
                $region['archivoCuatroTipo'] = $id_archivo_cuatro->tipo;
                $region['archivoCuatroUbicacion'] = $id_archivo_cuatro->ubicacion;                
                $region['archivoCuatroTexto'] = $id_archivo_cuatro->texto_archivo;
            }


            
            array_push($regions,$region);        
        }        
        // dd($regions);
        $messageType = 'new';
        return view('/home', ['regions' => $regions, 'messageType' =>   $messageType]);

    }
}