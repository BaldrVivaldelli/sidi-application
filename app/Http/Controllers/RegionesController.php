<?php

namespace App\Http\Controllers;

use App\Regions;
use App\Dispositivos;
use App\Multimedias;
use App\Archivos;
use File;
use Illuminate\Support\Facades\Request;
use DB;
use Carbon\Carbon;
use Storage;
use React\EventLoop\Factory as LoopFactory;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;
use Crypt;
use ZMQContext;
use Illuminate\Filesystem\Filesystem;

class RegionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = DB::table('regiones')->get();
        return view('/home', ['regions' => $regions, 'status' => 'new']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function showRegionToModify(Request $request)
    {
        //
        $aux = DB::table('regiones')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('dispositivos')->where('id_region', $idRegion)->count();
            $id_estado = $data->id_estado_region;
            $auxEstate =  DB::table('estados_regiones')->where('id', $id_estado)->first();
            $region['estado'] = $auxEstate->descripcion;
            $region['nombre_encryptado'] = $data->hash_code_nombre;
            array_push($regions, $region);
        }

        return view('regionModify', ['regions' => $regions, 'regionSelected' => false]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function show(Regions $regions)
    {
        dd($regions->id);
    }
    public function showSelectedRegion()
    {
        $products = Request::all();
        $idRegion = DB::table('regiones')->where('nombre', '=', $products['region-name'])->first();
        $dataMultimediales =  DB::table('multimedias')->where('id_region', $idRegion->id)->get();
        $response['archivos'] = array();
        foreach ($dataMultimediales as $multimedia) {

            $auxResponse = array();

            $fileData = DB::table('archivos')->where('id', '=', $multimedia->id_archivo)->first();

            $auxResponse['nombre_archivo'] =  "";
            $auxResponse['cuadro'] = $multimedia->cuadro;

            array_push($response['archivos'], $auxResponse);
        }

        $response['region_size'] = $idRegion->region_size;        
        $response['regionNombre'] =  $idRegion->nombre;
        $response['regionSelected'] = true;
        $response['region_hash'] = $idRegion->hash_code_nombre;

        $aux = DB::table('regiones')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('dispositivos')->where('id_region', $idRegion)->count();
            $id_estado = $data->id_estado_region;
            $auxEstate =  DB::table('estados_regiones')->where('id', $id_estado)->first();
            $region['estado'] = $auxEstate->descripcion;
            $region['nombre_encryptado'] = $data->hash_code_nombre;
            array_push($regions, $region);
        }
        return view('regionModify', ['regionData' => $response, 'regionSelected' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function showByName($name)
    {
        $decryptedValue = decrypt($name);
        $idRegion = DB::table('regiones')->where('nombre', '=', $decryptedValue)->value('id');
        $nombreRegion = DB::table('regiones')->where('nombre', '=', $decryptedValue)->value('nombre');
        $auxDispositivosAsociadosAlaRegion = DB::table('dispositivos')->where('id_region', $idRegion)->get();
        $allDisplayAssociateToRegionn['data'] = array();
        $allDisplayAssociateToRegionn['nombre_region'] = $nombreRegion;

        $region =  DB::table('regiones')->where('nombre', '=', $decryptedValue)->first();
        $status = DB::table('estados_regiones')->where('id', '=', $region->status)->first();
        $allDisplayAssociateToRegionn['status'] = $status->descripcion;
        $i = 0;
        foreach ($auxDispositivosAsociadosAlaRegion as $auxDispositivo) {
            $display = array();
            $idDetalle = $auxDispositivo->id_detalle;

            $detail =  DB::table('dispositivos_detalles')->where('id', $idDetalle)->first();
            $display['name'] = $detail->nombre;
            $display['adress'] = $detail->ip;
            $idStatus =  $auxDispositivo->id_estado_dispo;
            $status = DB::table('estados_dispositivos')->where('id', $idStatus)->first();
            $display['status'] = $status->estado;
            array_push($allDisplayAssociateToRegionn['data'], $display);
            $i++;
        }
        $allDisplayAssociateToRegionn['cant_display'] = $i;
        $allDisplayAssociateToRegionn['hash_region_key'] = $region->hash_code_nombre;

        return view('regionDetail', ['detalle_region' => $allDisplayAssociateToRegionn, 'messageType' => 'new']);
    }

    function processOneSecction($data)
    {

        $fileSeccionUna = $data['file-seccion-una'];

        // dd($fileSeccionUna->getClientMimeType());
        $regionName = $data['region-name'];
        //en caso de que sea on se clava el numero de region
        if ($data['region-priority-one'] == "on" || $data['region-priority-tres'] == "on" || $data['region-priority-one'] == "on") {
            if ($data['region-priority-one'] == "on") {
                $cuadroTotales = 1;
            } else if ($data['region-priority-tres'] == "on") {
                $cuadroTotales = 3;
            } else if ($data['region-priority-cuatro'] == "on") {
                $cuadroTotales = 4;
            }
        }
        $fileSeccionUnaName = $fileSeccionUna->getClientOriginalName();
        $fileName = encrypt($fileSeccionUnaName);
        $originalFileName = $fileName;
        if ("image/jpeg" == $fileSeccionUna->getClientMimeType()) {
            $fileName = $fileName . ".jpeg";
        }
        if ("image/gif" == $fileSeccionUna->getClientMimeType()) {
            $fileName =  $fileName . ".gif";
        }
        if ("video/x-matroska" == $fileSeccionUna->getClientMimeType()) {
            $fileName = $fileName . ".mkv";
        }
        if ("video/mp4" == $fileSeccionUna->getClientMimeType()) {
            $fileName = $fileName . ".mp4";
        }
        $fileRoute = $regionName . "//regionUna//archivoUno//";

        /**
         * ORDEN 
         * PRIMERO CREO LA REGION
         * DESPUES SUBO LOS ARCHIVOS
         * DESPUES ACTUALIZO LA TABLA DE REGIONES
         */

        //putFileAs($path, $file, $name) public
        Storage::disk('public')->putFileAs($fileRoute, $fileSeccionUna, $fileName);

        //esto en el final se va a iterar por cada $cuadroTotales que haya
        DB::table('archivos')->insert([
            'nombre' => $originalFileName,
            'formato' => $fileSeccionUna->getClientMimeType(),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $idName =  DB::table('archivos')->where('nombre', $originalFileName)->first();

        DB::table('multimedias')->insert([
            'id_archivo' => $idName->id,
            'cuadro' => $cuadroTotales,
            'id_estado' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $idMultimedial =  DB::table('multimedias')->where('id_archivo', $idName->id)->first();

        //for each de las latitudes y longitudes para insertar en regiones
        DB::table('regiones')->insert([
            'nombre' => $regionName,
            'hash_code_nombre' => encrypt($regionName),
            'id_multimedia' => $idMultimedial->id,
            'id_estado_region' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    function updateMultimedia($products, $archivoNuevo, $archivoAcambiar, $regionAcambiar)
    {
    
        $idRegion = DB::table('regiones')
            ->where('hash_code_nombre', '=', $products['region-id'])->first();

        $multimedias = DB::table('multimedias')
            ->where('cuadro', $archivoAcambiar)
            ->where('id_region', $idRegion->id)
            ->get();

        //TODO: PASO 1
        //borrar todos lo que esta en archivo que sea diferente a lo que yo quiero subir
        //PASO 2 
        //resubir con todo lo que tengo ahora para actualizar   

        foreach ($multimedias as $multimedia) {
            $archivoViejo = DB::table('archivos')->where('id', '=',  $multimedia->id_archivo)->get();
            $fileOriginalName = $archivoNuevo->getClientOriginalName();
            $fileName = encrypt($fileOriginalName);

            if ("image/jpeg" == $archivoNuevo->getClientMimeType()) {
                $fileName = $fileName . ".jpeg";
            }
            if ("image/gif" == $archivoNuevo->getClientMimeType()) {
                $fileName =  $fileName . ".gif";
            }
            if ("video/x-matroska" == $archivoNuevo->getClientMimeType()) {
                $fileName = $fileName . ".mkv";
            }
            if ("video/mp4" == $archivoNuevo->getClientMimeType()) {
                $fileName = $fileName . ".mp4";
            }
            $fileRoute = $idRegion->nombre . "//" . $regionAcambiar . "//" . $archivoAcambiar . "//";
            Storage::disk('public')->putFileAs($fileRoute, $archivoNuevo, $fileName);
            DB::table('archivos')
                ->where('id', '=',  $multimedia->id_archivo)
                ->update([
                    'nombre' => $fileName,
                    'formato' => $archivoNuevo->getClientMimeType(),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        }
    }


    function proccesMultimedia($multimediaFile, $allData, $region, $fileNumber, $regionCreada, $nombreRegion)
    {
        // dd($allData);

        $regionName = $allData['region-name'];

        //en caso de que sea on se clava el numero de region


        if (array_key_exists('region-priority-one', $allData) || array_key_exists('region-priority-tres', $allData) || array_key_exists('region-priority-cuatro', $allData)) {

            if (array_key_exists('region-priority-one', $allData)) {
                $cuadroTotales = 1;
            }
            if (array_key_exists('region-priority-tres', $allData)) {
                $cuadroTotales = 3;
            }
            if (array_key_exists('region-priority-cuatro', $allData)) {
                $cuadroTotales = 4;
            }
        }
        $fileSeccionUnaName = $multimediaFile->getClientOriginalName();
        $fileName = encrypt($fileSeccionUnaName);
        $originalFileName = $fileName;
        if ("image/jpeg" == $multimediaFile->getClientMimeType()) {
            $fileName = $fileName . ".jpeg";
        }
        if ("image/gif" == $multimediaFile->getClientMimeType()) {
            $fileName =  $fileName . ".gif";
        }
        if ("video/x-matroska" == $multimediaFile->getClientMimeType()) {
            $fileName = $fileName . ".mkv";
        }
        if ("video/mp4" == $multimediaFile->getClientMimeType()) {
            $fileName = $fileName . ".mp4";
        }
        $fileRoute = $regionName . "//" . $region . "//" . $fileNumber . "//";
        /**
         * ORDEN 
         * PRIMERO CREO LA REGION
         * DESPUES SUBO LOS ARCHIVOS
         * DESPUES ACTUALIZO LA TABLA DE REGIONES
         */

        //putFileAs($path, $file, $name)
        Storage::disk('public')->putFileAs($fileRoute, $multimediaFile, $fileName);

        //esto en el final se va a iterar por cada $cuadroTotales que haya
        DB::table('archivos')->insert([
            'nombre' => $originalFileName,
            'formato' => $multimediaFile->getClientMimeType(),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $idName =  DB::table('archivos')->where('nombre', $originalFileName)->first();

        if (array_key_exists('habilitada', $allData)) {
            $status = '1';
        } else {
            $status = '0';
        }

        if ($regionCreada) {
            $idRegionName = DB::table('regiones')->where('nombre', $regionName)->first();
            $idRegion = $idRegionName;
        } else {
            //for each de las latitudes y longitudes para insertar en regiones
            $nombreRegion = encrypt($regionName);
            DB::table('regiones')->insert([
                'nombre' => $regionName,
                'hash_code_nombre' =>  $nombreRegion,
                'id_estado_region' => '1',
                'status' => $status,
                'region_size' => $region,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $idRegion =  DB::table('regiones')->where('nombre', $regionName)->first();
        }
        DB::table('multimedias')->insert([
            'id_archivo' => $idName->id,
            'id_region' => $idRegion->id,
            'cuadro' => $fileNumber,
            'id_estado' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    public function generateNewRegionTemplate()
    {
        $products = Request::all();
        if (array_key_exists('file-seccion-una', $products)) {

            $fileSeccionUna = $products['file-seccion-una'];
            $region = "region_uno";
            $fileNumber = "archivo_uno";
            $regionCreada = false;
            $nombreRegion = "";
            self::proccesMultimedia($fileSeccionUna, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
        } else if (array_key_exists('file-seccion-tres-a', $products) && array_key_exists('file-seccion-tres-b', $products) && array_key_exists('file-seccion-tres-c', $products)) {


            $file_seccion_tres_a = $products['file-seccion-tres-a'];

            $region = "region_tres";
            $fileNumber = "archivo_uno";
            $regionCreada = false;
            $nombreRegion = "";
            self::proccesMultimedia($file_seccion_tres_a, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $regionCreada = true;
            $fileNumber = "archivo_dos";
            $file_seccion_tres_b = $products['file-seccion-tres-b'];
            self::proccesMultimedia($file_seccion_tres_b, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $fileNumber = "archivo_tres";
            $file_seccion_tres_c = $products['file-seccion-tres-c'];
            self::proccesMultimedia($file_seccion_tres_c, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
        } else if (array_key_exists('file-seccion-cuatro-a', $products) && array_key_exists('file-seccion-cuatro-b', $products) && array_key_exists('file-seccion-cuatro-c', $products)  && array_key_exists('file-seccion-cuatro-d', $products)) {

            $file_seccion_tres_a = $products['file-seccion-cuatro-a'];
            $region = "region_cuatro";
            $fileNumber = "archivo_uno";
            $regionCreada = false;
            $nombreRegion = "";
            self::proccesMultimedia($file_seccion_tres_a, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $regionCreada = true;
            $fileNumber = "archivo_dos";
            $file_seccion_tres_b = $products['file-seccion-cuatro-b'];
            self::proccesMultimedia($file_seccion_tres_b, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $fileNumber = "archivo_tres";
            $file_seccion_tres_c = $products['file-seccion-cuatro-c'];
            self::proccesMultimedia($file_seccion_tres_c, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $fileNumber = "archivo_cuatro";
            $file_seccion_tres_d = $products['file-seccion-cuatro-d'];
            self::proccesMultimedia($file_seccion_tres_d, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
        }
    }
    public function modifyRegion()
    {

        $products = Request::all();


        $idRegion = DB::table('regiones')->where('hash_code_nombre', '=', $products['region-id'])->first();


        // if (isset($products['region-priority-one']) || isset($products['region-priority-tres']) || isset($products['region-priority-cuatro'])) {

        //     if (isset($products['region-priority-one']) && $products['region-priority-one'] == "on") {
        //         $esCambioIntegro = 'region_uno';
        //     } else if (isset($products['region-priority-tres']) && $products['region-priority-tres'] == "on") {
        //         $esCambioIntegro = 'region_tres';
        //     } else if (isset($products['region-priority-cuatro']) && $products['region-priority-cuatro'] == "on") {
        //         $regionAcambiar = 'region_cuatro';
        //     }

        //     $idRegion = DB::table('regiones')->where('hash_code_nombre', '=', $products['region-id'])->first();
        //     if ($esCambioIntegro != $idRegion->region_size) {
        //         //borrar region
        //         // $idRegion->dispositivos()->delete();
        //         $idRegion->multimedias()->delete();
        //         $idRegion->delete();
        //         // nombre / region_uno                
        //         $path = $idRegion->nombre . '/' . $idRegion->region_size;
        //         $result = Storage::deleteDirectory($path);
        //         if($result){
        //             self::generateNewRegionTemplate();
        //         }
        //         // $result = File::deleteDirectory(public_path($strDirName));
        //         //esto me va a borrar del storage el archivo que le diga. De todas formas el find or fail me tiene que traer la dirreccion               
        //         // $result = Storage::deleteDirectory($directory);
        //         //dd('cambio integro de template');
        //         //crear una nueva

        //     }
        // }




        //camino normal


        if (isset($products['region-priority-one']) || isset($products['region-priority-tres']) || isset($products['region-priority-cuatro'])) {

            if (isset($products['region-priority-one']) && $products['region-priority-one'] == "on") {
                $fileSeccionUna = $products['file-seccion-una'];
                $archivoAcambiar = 'archivo_uno';
                $regionAcambiar = 'region_uno';
                self::updateMultimedia($products, $fileSeccionUna, $archivoAcambiar, $regionAcambiar);
            } else if (isset($products['region-priority-tres']) && $products['region-priority-tres'] == "on") {

                $regionAcambiar = 'region_tres';
                if (isset($products['file-seccion-tres-a'])) {
                    $fileSeccionUna = $products['file-seccion-tres-a'];
                    $archivoAcambiar = 'archivo_uno';
                    self::updateMultimedia($products, $fileSeccionUna, $archivoAcambiar, $regionAcambiar);
                }
                if (isset($products['file-seccion-tres-b'])) {
                    $archivoAcambiar = 'archivo_dos';
                    $fileSeccionDos = $products['file-seccion-tres-b'];
                    self::updateMultimedia($products, $fileSeccionDos, $archivoAcambiar, $regionAcambiar);
                }
                if (isset($products['file-seccion-tres-c'])) {
                    $archivoAcambiar = 'archivo_tres';
                    $fileSeccionTres = $products['file-seccion-tres-c'];
                    self::updateMultimedia($products, $fileSeccionTres, $archivoAcambiar, $regionAcambiar);
                }
            } else if (isset($products['region-priority-cuatro']) && $products['region-priority-cuatro'] == "on") {
                $regionAcambiar = 'region_cuatro';
                if (isset($products['file-seccion-cuatro-a'])) {
                    $fileSeccionUna = $products['file-seccion-cuatro-a'];
                    $archivoAcambiar = 'archivo_uno';
                    self::updateMultimedia($products, $fileSeccionUna, $archivoAcambiar, $regionAcambiar);
                }
                if (isset($products['file-seccion-cuatro-b'])) {
                    $archivoAcambiar = 'archivo_dos';
                    $fileSeccionDos = $products['file-seccion-cuatro-b'];
                    self::updateMultimedia($products, $fileSeccionDos, $archivoAcambiar, $regionAcambiar);
                }
                if (isset($products['file-seccion-tres-c'])) {
                    $archivoAcambiar = 'archivo_tres';
                    $fileSeccionTres = $products['file-seccion-cuatro-c'];
                    self::updateMultimedia($products, $fileSeccionTres, $archivoAcambiar, $regionAcambiar);
                }
                if (isset($products['file-seccion-tres-d'])) {
                    $archivoAcambiar = 'archivo_cuatro';
                    $fileSeccionCuatro = $products['file-seccion-cuatro-d'];
                    self::updateMultimedia($products, $fileSeccionCuatro, $archivoAcambiar, $regionAcambiar);
                }
                // $idRegion = DB::table('regiones')->where('hash_code_nombre', '=', $products['region-id'])->first();
                // if ($regionAcambiar != $idRegion->region_size) {
                //     DB::table('regiones')
                //         ->where('hash_code_nombre', '=', $products['region-id'])
                //         ->update([
                //             'region_size' => $regionAcambiar
                //         ]);
                // }
            }
        }



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

        $idRegion = DB::table('regiones')->where('hash_code_nombre', '=', $products['region-id'])->first();

        return view('/home', ['regions' => $regions, 'messageType' => 'modificacion', 'region_id' => $idRegion->nombre]);
    }

    public function createRegion()
    {


        $products = Request::all();


        if (array_key_exists('file-seccion-una', $products)) {

            $fileSeccionUna = $products['file-seccion-una'];
            $region = "region_uno";
            $fileNumber = "archivo_uno";
            $regionCreada = false;
            $nombreRegion = "";
            self::proccesMultimedia($fileSeccionUna, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
        } else if (array_key_exists('file-seccion-tres-a', $products) && array_key_exists('file-seccion-tres-b', $products) && array_key_exists('file-seccion-tres-c', $products)) {


            $file_seccion_tres_a = $products['file-seccion-tres-a'];

            $region = "region_tres";
            $fileNumber = "archivo_uno";
            $regionCreada = false;
            $nombreRegion = "";
            self::proccesMultimedia($file_seccion_tres_a, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $regionCreada = true;
            $fileNumber = "archivo_dos";
            $file_seccion_tres_b = $products['file-seccion-tres-b'];
            self::proccesMultimedia($file_seccion_tres_b, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $fileNumber = "archivo_tres";
            $file_seccion_tres_c = $products['file-seccion-tres-c'];
            self::proccesMultimedia($file_seccion_tres_c, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
        } else if (array_key_exists('file-seccion-cuatro-a', $products) && array_key_exists('file-seccion-cuatro-b', $products) && array_key_exists('file-seccion-cuatro-c', $products)  && array_key_exists('file-seccion-cuatro-d', $products)) {

            $file_seccion_tres_a = $products['file-seccion-cuatro-a'];
            $region = "region_cuatro";
            $fileNumber = "archivo_uno";
            $regionCreada = false;
            $nombreRegion = "";
            self::proccesMultimedia($file_seccion_tres_a, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $regionCreada = true;
            $fileNumber = "archivo_dos";
            $file_seccion_tres_b = $products['file-seccion-cuatro-b'];
            self::proccesMultimedia($file_seccion_tres_b, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $fileNumber = "archivo_tres";
            $file_seccion_tres_c = $products['file-seccion-cuatro-c'];
            self::proccesMultimedia($file_seccion_tres_c, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
            $fileNumber = "archivo_cuatro";
            $file_seccion_tres_d = $products['file-seccion-cuatro-d'];
            self::proccesMultimedia($file_seccion_tres_d, $products, $region, $fileNumber, $regionCreada, $nombreRegion);
        }

        return redirect('/login');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function edit(Regions $regions)
    {
        //
    }
    public function getAddRegionData(Regions $regions)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Regions $regions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regions $regions)
    {
        //
    }

    public function deleteRegion()
    {
        //
        $aux = DB::table('regiones')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('dispositivos')->where('id_region', $idRegion)->count();
            $id_estado = $data->id_estado_region;
            $auxEstate =  DB::table('estados_regiones')->where('id', $id_estado)->first();
            $region['estado'] = $auxEstate->descripcion;
            $region['nombre_encryptado'] = $data->hash_code_nombre;
            array_push($regions, $region);
        }

        return view('regionDelete', ['regions' => $regions, 'regionSelected' => false]);
    }
    public function deleteRegionByName()
    {
        $products = Request::all();
        $idRegion = Regions::where('nombre', '=', $products['region-name'])->first();

        $idRegion->dispositivos()->delete();
        $idRegion->multimedias()->delete();
        Storage::deleteDirectory($idRegion->nombre);
        $idRegion->delete();

        $aux = DB::table('regiones')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('dispositivos')->where('id_region', $idRegion)->count();
            $id_estado = $data->id_estado_region;
            $auxEstate =  DB::table('estados_regiones')->where('id', $id_estado)->first();
            $region['estado'] = $auxEstate->descripcion;
            $region['nombre_encryptado'] = $data->hash_code_nombre;
            array_push($regions, $region);
        }

        return view('regionDelete', ['regions' => $regions, 'regionSelected' => false]);
    }
    public function changeStateRegions()
    {
        $products = Request::all();

        $decryptedValue = decrypt($products['region_code']);
        $requestState = strtolower($products['region_state']);
        $getState = DB::table('estados_regiones')->where('descripcion', '=',  $requestState)->first();
        DB::table('regiones')->where('nombre', '=', $decryptedValue)->update(
            [
                'status' => $getState->id,
                'id_estado_region' => $getState->id,
            ]
        );

        $idRegion = DB::table('regiones')->where('nombre', '=', $decryptedValue)->value('id');
        $nombreRegion = DB::table('regiones')->where('nombre', '=', $decryptedValue)->value('nombre');
        $auxDispositivosAsociadosAlaRegion = DB::table('dispositivos')->where('id_region', $idRegion)->get();
        $allDisplayAssociateToRegionn['data'] = array();
        $allDisplayAssociateToRegionn['nombre_region'] = $nombreRegion;

        $region =  DB::table('regiones')->where('nombre', '=', $decryptedValue)->first();
        $status = DB::table('estados_regiones')->where('id', '=', $region->status)->first();
        $allDisplayAssociateToRegionn['status'] = $status->descripcion;
        $i = 0;
        foreach ($auxDispositivosAsociadosAlaRegion as $auxDispositivo) {
            $display = array();
            $idDetalle = $auxDispositivo->id_detalle;

            $detail =  DB::table('dispositivos_detalles')->where('id', $idDetalle)->first();
            $display['name'] = $detail->nombre;
            $display['adress'] = $detail->ip;
            $idStatus =  $auxDispositivo->id_estado_dispo;
            $status = DB::table('estados_dispositivos')->where('id', $idStatus)->first();
            $display['status'] = $status->estado;
            array_push($allDisplayAssociateToRegionn['data'], $display);
            $i++;
        }
        $allDisplayAssociateToRegionn['cant_display'] = $i;
        $allDisplayAssociateToRegionn['region_id'] = $region->id;
        $allDisplayAssociateToRegionn['hash_region_key'] = $region->hash_code_nombre;

        return view('regionDetail', ['detalle_region' => $allDisplayAssociateToRegionn, 'messageType' => 'modificacion']);
    }
}
