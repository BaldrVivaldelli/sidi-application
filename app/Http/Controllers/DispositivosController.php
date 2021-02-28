<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regions;
use DB; 
use Carbon\Carbon;
use Log;

class DispositivosController extends Controller
{
    //
    public function index(Request $request){
                
        $aux = DB::table('clientes')->get();
        $clientes = array();
        
        foreach ($aux as $data){
            $cliente = array();            
            $cliente['name'] =  $data->clientId;
            $cliente['nombre_dispositivo'] = $data->nombreDispositivo;
            $id_estado = $data->id_estado;
            $auxEstate =  DB::table('estados')->where('id',$id_estado)->first();            
            $cliente['estado'] = $auxEstate->estado;

            $auxContenido = DB::table('contenidos')->where('id',$data->id_contenido)->first();            
            $cliente['nombre_contenido'] = $auxContenido->nombre;
            $auxContenidosNombre = DB::table('contenidos')->get();
            $totalContenidosNombre = array();
            foreach ($auxContenidosNombre as $data){     
                $cliente['contenido_general_nombre'] = $data->nombre;           
                array_push($totalContenidosNombre, $cliente['contenido_general_nombre']);
            }
            $cliente['total_nombreContenido'] = $totalContenidosNombre;            
            


            $totalEstados = array();
            $auxTotalesEstados = DB::table('estados')->get();
            foreach ($auxTotalesEstados as $data){     
                $auxEstado = $data->estado;           
                $tipoEstado = $data->tipo;           
                if($tipoEstado=="cliente"){
                    array_push($totalEstados, $auxEstado);
                }
            }
            $cliente['total_estados']   = $totalEstados;

            $cliente['ultima_conexion'] = $data->created_at;     
            array_push($clientes,$cliente);
        }               
        return view('displayShow', ['clientes' => $clientes]);
    }

    public function createDispositivo (Request $request){

        $regionName = $request['region-category'];
        $displayName = $request['display-name'];
        $displayMacAdress = $request['display-mac-adress'];
        $displayDetails = $request['display-detail'];


        if( $request['habilitado'] == "on"){
            $estado = '1';
        }else{
            $estado = '0';
        }
        $idRegion   =  DB::table('regiones')->where('nombre',$regionName)->first(); 
        $idEstado   =  DB::table('estados_dispositivos')->where('id',$estado)->first(); 

        
        $fechaAlta = Carbon::now()->format('Y-m-d');
        DB::table('dispositivos_detalles')->insert([
            'nombre'    => $displayName,
            'ip'        => $displayMacAdress,
            'detalle'   => $displayDetails,
            'fecha_alta'=> $fechaAlta,
            'created_at'=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'=> Carbon::now()->format('Y-m-d H:i:s')                         
        ]);
        $idDetalle =  DB::table('dispositivos_detalles')->where('ip',$displayMacAdress)->first(); 
        DB::table('dispositivos')->insert([
            'id_region' => $idRegion->id,
            'id_detalle' => $idDetalle->id,
            'id_estado_dispo' => $idEstado->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')                         
        ]);
        $aux = DB::table('regiones')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('dispositivos')->where('id_region', $idRegion)->count();
            $id_estado = $data->id_estado_region;
            $auxEstate =  DB::table('estados_regiones')->where('id', $id_estado)->first();
            $region['region_size'] = $data->region_size;
            $region['estado'] = $auxEstate->descripcion;
            $region['nombre_encryptado'] = $data->hash_code_nombre;
            array_push($regions, $region);
        }

        Log::info('Se creo dispositivo');
        return view('/home', ['regions' => $regions, 'messageType' => 'saveNewDisplay', 'data' => $displayMacAdress]);
    }

    // public function changeDisplayView(){

    //     $aux = DB::table('dispositivos_detalles')->get();
    //     $displays = array();

    //     foreach ($aux as $data) {
    //         $display = array();
    //         $display['name'] = $data->nombre;
    //         $display['ip'] = $data->ip;
    //         $display['detalle'] = $data->detalle;
    //         array_push($displays, $display);
    //     }

    //     $aux = DB::table('regiones')->get();
    //     $regions = array();

    //     foreach ($aux as $data) {
    //         $region = array();
    //         $region['name'] = $data->nombre;
    //         $idRegion = $data->id;
    //         $region['cant_disp'] = DB::table('dispositivos')->where('id_region', $idRegion)->count();
    //         $id_estado = $data->id_estado_region;
    //         $auxEstate =  DB::table('estados_regiones')->where('id', $id_estado)->first();
    //         $region['estado'] = $auxEstate->descripcion;
    //         $region['nombre_encryptado'] = $data->hash_code_nombre;
    //         array_push($regions, $region);
    //     }
    //     return view('displayChange', ['regions' => $regions, 'displays'=> $displays]);
    // }

    public function deleteDisplay(Request $request){
        DB::table('clientes')->where('ip', $request->cliente)->delete();
        Log::info('Se borro dispositivo con exito');
        return response("Dispositivo eliminado con exito", 200);
    }
    public function changeDisplayRegion(Request $request)    
    {

        $aux = DB::table('regiones')->where('nombre', $request['region-category'])->first();
        $idRegion = $aux->id;
        $dispoositivoID = DB::table('dispositivos_detalles')->where('nombre', $request['display-category'])->first();
        $data = DB::table('dispositivos')->where('id_detalle', $dispoositivoID->id)
                                ->update(
                                [
                                'id_region' => $idRegion
                                ]
                                );


        $aux = DB::table('regiones')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('dispositivos')->where('id_region', $idRegion)->count();
            $id_estado = $data->id_estado_region;
            $auxEstate =  DB::table('estados_regiones')->where('id', $id_estado)->first();
            $region['region_size'] = $data->region_size;
            $region['estado'] = $auxEstate->descripcion;
            $region['nombre_encryptado'] = $data->hash_code_nombre;
            array_push($regions, $region);
        }

        $displayMacAdress = $dispoositivoID->ip;
        Log::info('Se cambio el dispositivo de contenido');
        return view('/home', ['regions' => $regions, 'messageType' => 'updateDisplay', 'data' => $displayMacAdress]);

    }
   
    public function updateName(Request $request){
        Log::info('llego un cambio de nombre '. $request["displayNewName"]);
        Log::info('el cliente original es el siguiente  '.$request["displayOriginalName"]);
        
        $aux = DB::table('clientes')->where('nombreDispositivo',$request["displayNewName"])->first();        
        if($aux === null){        
            Log::info('el cliente original es el siguiente  '.$aux);
            $newName = $request["displayNewName"];
            DB::table('clientes')->where('nombreDispositivo', $request["displayOriginalName"])->update([
                'nombreDispositivo'=>   $newName
            ]);
            return [
                'status' => "ok"
            ];
        }else{
            return [
                'status' => "error",
                'desc' => "Nombre invalido, actualmente se encuentra asignado a un dispositivo con ese nombre"
            ];
        }
    }
}
