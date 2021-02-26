<?php

namespace App\Http\Controllers;

use App\Content;
use Illuminate\Http\Request;
use App\Archivos;
use Storage;
use DB;
use Carbon\Carbon;
use Validator;
use App\Rules\UniqueContentName;
use Illuminate\Support\Str;
use Redirect;
use Log;


class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = DB::table('contenidos')->get();
        return view('/home', ['contenidos' => $content, 'status' => 'new']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('Entre al ContentController.');
        return view('contentCreate');
    }
    public function delete()
    {
        Log::info('Voy a borrar un controlador.');
        $aux = DB::table('contenidos')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('clientes')->where('id_contenido', $idRegion)->count();
            $id_estado = $data->id_estado;
            $auxEstate =  DB::table('estados')->where('id', $id_estado)->first();
            $region['estado'] = $auxEstate->estado;
            $region['nombre_encryptado'] = $data->nombre;
            array_push($regions, $region);
        }
        Log::info('vuelvo al contentDelete');
        return view('contentDelete', ['regions' => $regions, 'regionSelected' => false]);
    }

    public function destroyContent(Request $request)
    {
        $contentName = $request["content-name"];
        Log::info('Se destruye por el panel del home el siguiente controller' . $contentName);

        $contentData = DB::table('contenidos')->where('nombre', $contentName)->first();

        //agregar if para los demas casos
        $archivoUno = DB::table('archivos')->where('id', $contentData->id_archivo_uno)->first();

        // DB::table('clientes')->where('id_contenido', $contentData->id)->delete();

        $pepe = DB::table('contenidos')->where('nombre', "=", $contentName);
        $pepe->delete();
        //borro los archivos en la nube
        // Storage::disk('s3')->delete($archivoUno->ubicacion);
        //borro los archivos asociados
        // DB::table('archivos')->where('id', $contentData->id_archivo_uno)->delete();
        //borro los clientes asociados

        return redirect('home');
    }

    public function update(Request $request)
    {
        
        //si solo modificaste el habilitado des habilitado lo impacto aca y el resto lo saleto        
        $previousState = DB::table('contenidos')->where('nombre', $request["content-name"])->first();        
        if($previousState  == null){
            return redirect("/content/modify")->withErrors(['Operatoria de inputs invalida']);
        }
        if ($request['estado-contenido'] == 'on') {
            // previousState
            $newState = 4;
        } else {
            $newState = 3;
        }
        
        //si todo esta en blanco menos el cambio de estrado
        if ($previousState->id_estado != $newState &&  $request->input('tipo-region') == null) {

            Log::info('Se actualiza el estado del sigueinte contenido ' . $request["content-name"]);

            //              Creo el registro en la tabla contenidos                
            DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                'id_estado' => $newState,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);


            $contenidos = DB::table('contenidos')->get();
            $regions = array();

            foreach ($contenidos as $contenido) {
                $region = array();
                $region['name'] = $contenido->nombre;
                $region['cant_disp'] = DB::table('clientes')->where('id_contenido', $contenido->id)->count();
                $id_estado = $contenido->id_estado;
                $auxEstate =  DB::table('estados')->where('id', $id_estado)->first();
                $region['estado'] = $auxEstate->estado;
                $region['region_size'] = $contenido->formato_template;

                if ($contenido->id_archivo_uno != null) {
                    $id_archivo_uno = DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                    $region['archivoUnoUrl'] = $id_archivo_uno->youtube_url;
                    $region['archivoUnoTipo'] = $id_archivo_uno->tipo;
                    $region['archivoUnoUbicacion'] = $id_archivo_uno->ubicacion;
                    $region['archivoUnoTexto'] = $id_archivo_uno->texto_archivo;
                }
                if ($contenido->id_archivo_dos != null) {
                    $id_archivo_dos = DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                    $region['archivoDosUrl'] = $id_archivo_dos->youtube_url;
                    $region['archivoDosTipo'] = $id_archivo_dos->tipo;
                    $region['archivoDosUbicacion'] = $id_archivo_dos->ubicacion;
                    $region['archivoDosTexto'] = $id_archivo_dos->texto_archivo;
                }
                if ($contenido->id_archivo_tres != null) {
                    $id_archivo_tres = DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                    $region['archivoTresUrl'] = $id_archivo_tres->youtube_url;
                    $region['archivoTresTipo'] =  $id_archivo_tres->tipo;
                    $region['archivoTresUbicacion'] = $id_archivo_tres->ubicacion;
                    $region['archivoTresTexto'] = $id_archivo_tres->texto_archivo;
                }
                if ($contenido->id_archivo_cuatro != null) {
                    $id_archivo_cuatro = DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
                    $region['archivoCuatroUrl'] = $id_archivo_cuatro->youtube_url;
                    $region['archivoCuatroTipo'] = $id_archivo_cuatro->tipo;
                    $region['archivoCuatroUbicacion'] = $id_archivo_cuatro->ubicacion;
                    $region['archivoCuatroTexto'] = $id_archivo_cuatro->texto_archivo;
                }



                array_push($regions, $region);
            }

            return view('/home', ['regions' => $regions, 'messageType' => 'modificacion', 'region_id' => $request->input('content-name')]);

            //COMIENZA VALIDACIONES DE UPDATE 
        }
        if ($request->input('tipo-region') == null) {
            Log::info('region no seleccionada');
            return redirect("/content/selectContentEmergency/" . $request["content-name"])->withErrors(['Tiene que seleccionar un formato de template']);
        }
        //  augusto validador de archivos 
        //VALIDACION DE BLANCOS Y DE YOTUUBE Y DE CARACTERES EN TEXTOS VA NULL EN EL ULTIMO PARAMETRO PORQUE EN ESTE LENGUAJE NEFASTO NO EXISTE UN HANDLER COMO EN TEORIA DE OBJETOS
        $validatorBlank = self::contentGeneralValidator($request, true, $previousState);
        // //VALIDACION DE ARCHIVOS

        if ($validatorBlank["value"] == false) {
            return redirect("/content/selectContentEmergency/" . $request["content-name"])->withErrors([$validatorBlank["desc"]]);
        }
        if ($request["estado-contenido"] == "on") {
            $estadoDispo = 4;
        } else {
            $estadoDispo = 3;
        }
        switch ($request->input('tipo-region')) {
            case "1":

                if ($request['file-seccion-una-a-url'] != null) {
                    $this->processYoutube($request['file-seccion-una-a-url']);
                    $idArchivooUnoNombreOriginal = $request['file-seccion-una-a-url'];
                } else if ($request['mensaje-seccion-una-a'] != null) {
                    DB::table('archivos')->insert([
                        'nombre' => $request['mensaje-seccion-una-a'], 'tipo' => 'texto',
                        'texto_archivo' => $request['mensaje-seccion-una-a'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $idArchivooUnoNombreOriginal = $request['mensaje-seccion-una-a'];
                } else {
                    if ($request->file('file-seccion-una-a-upload-manual') != null) {
                        $fileUno = $request->file('file-seccion-una-a-upload-manual');
                    } else {
                        $fileUno = $request->file('file-seccion-una-a');
                    }
                    $this->processData($fileUno, 1);
                    $idArchivooUnoNombreOriginal = $fileUno->getClientOriginalName();
                }
                $idArchivoUno =  DB::table('archivos')->where('nombre', $idArchivooUnoNombreOriginal)->first();

                //              Creo el registro en la tabla contenidos                
                DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                    // 'nombre' =>             $request->input('content-name'),
                    'formato_template' =>   $request->input('tipo-region'),
                    'id_archivo_uno' =>     $idArchivoUno->id,
                    'id_estado' => $estadoDispo,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
                Log::info('Se actualizo a un solo contenido template con exito');
                break;
            case "3":

                if ($request['regionTresDetalleUno'] != "default") {

                    if ($request['file-seccion-tres-a-url'] != null) {
                        $this->processYoutube($request['file-seccion-tres-a-url']);
                        $idArchivooUnoNombreOriginal = $request['file-seccion-tres-a-url'];
                    } else if ($request['mensaje-seccion-tres-a'] != null) {
                        DB::table('archivos')->insert([
                            'nombre' => $request['mensaje-seccion-tres-a'], 'tipo' => 'texto',
                            'texto_archivo' => $request['mensaje-seccion-tres-a'],
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                        $idArchivooUnoNombreOriginal = $request['mensaje-seccion-tres-a'];
                    } else {
                        if ($request->file('file-seccion-tres-a-upload-manual') != null) {
                            $fileUno = $request->file('file-seccion-tres-a-upload-manual');
                        } else {
                            $fileUno = $request->file('file-seccion-tres-a');
                        }
                        $this->processData($fileUno, 1);
                        $idArchivooUnoNombreOriginal = $fileUno->getClientOriginalName();
                    }

                    $idArchivoUno =  DB::table('archivos')->where('nombre', $idArchivooUnoNombreOriginal)->first();
                    //              Creo el registro en la tabla contenidos                
                    DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                        // 'nombre' =>             $request->input('content-name'),
                        'formato_template' =>   $request->input('tipo-region'),
                        'id_archivo_uno' =>     $idArchivoUno->id,
                        'id_estado' => $estadoDispo,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }

                if ($request['regionTresDetalleDos'] != "default") {

                    if ($request['file-seccion-tres-b-url'] != null) {
                        $this->processYoutube($request['file-seccion-tres-b-url']);
                        $idArchivooDosNombreOriginal = $request['file-seccion-tres-b-url'];
                    } else if ($request['mensaje-seccion-tres-b'] != null) {
                        DB::table('archivos')->insert([
                            'nombre' => $request['mensaje-seccion-tres-b'], 'tipo' => 'texto',
                            'texto_archivo' => $request['mensaje-seccion-tres-b'],
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                        $idArchivooDosNombreOriginal = $request['mensaje-seccion-tres-b'];
                    } else {
                        if ($request->file('file-seccion-tres-b-upload-manual') != null) {
                            $fileUno = $request->file('file-seccion-tres-b-upload-manual');
                        } else {
                            $fileUno = $request->file('file-seccion-tres-b');
                        }
                        $this->processData($fileUno, 2);
                        $idArchivooDosNombreOriginal = $fileUno->getClientOriginalName();
                    }
                    $idArchivoDos =  DB::table('archivos')->where('nombre', $idArchivooDosNombreOriginal)->first();
                    DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                        // 'nombre' =>             $request->input('content-name'),
                        'formato_template' =>   $request->input('tipo-region'),
                        'id_archivo_dos' =>     $idArchivoDos->id,
                        'id_estado' => $estadoDispo,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                if ($request['regionTresDetalleTres'] != "default") {
                    if ($request['file-seccion-tres-c-url'] != null) {
                        $this->processYoutube($request['file-seccion-tres-c-url']);
                        $idArchivooTresNombreOriginal = $request['file-seccion-tres-c-url'];
                    } else if ($request['mensaje-seccion-tres-c'] != null) {
                        DB::table('archivos')->insert([
                            'nombre' => $request['mensaje-seccion-tres-c'], 'tipo' => 'texto',
                            'texto_archivo' => $request['mensaje-seccion-tres-c'],
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                        $idArchivooTresNombreOriginal = $request['mensaje-seccion-tres-c'];
                    } else {
                        if ($request->file('file-seccion-tres-c-upload-manual') != null) {
                            $fileUno = $request->file('file-seccion-tres-c-upload-manual');
                        } else {
                            $fileUno = $request->file('file-seccion-tres-c');
                        }
                        $this->processData($fileUno, 3);
                        $idArchivooTresNombreOriginal = $fileUno->getClientOriginalName();
                    }
                    $idArchivoTres =  DB::table('archivos')->where('nombre', $idArchivooTresNombreOriginal)->first();
                    DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                        // 'nombre' =>             $request->input('content-name'),
                        'formato_template' =>   $request->input('tipo-region'),
                        'id_archivo_tres' =>    $idArchivoTres->id,
                        'id_estado' => $estadoDispo,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                Log::info('Se actualizo a tres contenidos  template con exito');
                break;

            case "4":

                if ($request['regionCuatroDetalleUno'] != "default") {

                    if ($request['file-seccion-cuatro-a-url'] != null) {
                        $this->processYoutube($request['file-seccion-cuatro-a-url']);
                        $idArchivooUnoNombreOriginal = $request['file-seccion-cuatro-a-url'];
                    } else if ($request['mensaje-seccion-cuatro-a'] != null) {
                        DB::table('archivos')->insert([
                            'nombre' => $request['mensaje-seccion-cuatro-a'], 'tipo' => 'texto',
                            'texto_archivo' => $request['mensaje-seccion-cuatro-a'],
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                        $idArchivooUnoNombreOriginal = $request['mensaje-seccion-cuatro-a'];
                    } else {
                        if ($request->file('file-seccion-cuatro-a-upload-manual') != null) {
                            $fileUno = $request->file('file-seccion-cuatro-a-upload-manual');
                        } else {
                            $fileUno = $request->file('file-seccion-cuatro-a');
                        }
                        $this->processData($fileUno, 1);
                        $idArchivooUnoNombreOriginal = $fileUno->getClientOriginalName();
                    }
                    $idArchivoUno =  DB::table('archivos')->where('nombre', $idArchivooUnoNombreOriginal)->first();

                    //              Creo el registro en la tabla contenidos                
                    DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                        // 'nombre' =>             $request->input('content-name'),
                        'formato_template' =>   $request->input('tipo-region'),
                        'id_archivo_uno' =>     $idArchivoUno->id,
                        'id_estado' => $estadoDispo,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                if ($request['regionCuatroDetalleDos'] != "default") {

                    if ($request['file-seccion-cuatro-b-url'] != null) {
                        $this->processYoutube($request['file-seccion-cuatro-b-url']);
                        $idArchivooDosNombreOriginal = $request['file-seccion-cuatro-b-url'];
                    } else if ($request['mensaje-seccion-cuatro-b'] != null) {
                        DB::table('archivos')->insert([
                            'nombre' => $request['mensaje-seccion-cuatro-b'], 'tipo' => 'texto',
                            'texto_archivo' => $request['mensaje-seccion-cuatro-b'],
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                        $idArchivooDosNombreOriginal = $request['mensaje-seccion-cuatro-b'];
                    } else {
                        if ($request->file('file-seccion-cuatro-b-upload-manual') != null) {
                            $fileUno = $request->file('file-seccion-cuatro-b-upload-manual');
                        } else {
                            $fileUno = $request->file('file-seccion-cuatro-b');
                        }
                        $this->processData($fileUno, 2);
                        $idArchivooDosNombreOriginal = $fileUno->getClientOriginalName();
                    }
                    $idArchivoDos =  DB::table('archivos')->where('nombre', $idArchivooDosNombreOriginal)->first();

                    //              Creo el registro en la tabla contenidos                
                    DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                        // 'nombre' =>             $request->input('content-name'),
                        'formato_template' =>   $request->input('tipo-region'),
                        'id_archivo_dos' =>     $idArchivoDos->id,
                        'id_estado' => $estadoDispo,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                if ($request['regionCuatroDetalleTres'] != "default") {

                    if ($request['file-seccion-cuatro-c-url'] != null) {
                        $this->processYoutube($request['file-seccion-cuatro-c-url']);
                        $idArchivooTresNombreOriginal = $request['file-seccion-cuatro-c-url'];
                    } else if ($request['mensaje-seccion-cuatro-c'] != null) {
                        DB::table('archivos')->insert([
                            'nombre' => $request['mensaje-seccion-cuatro-c'], 'tipo' => 'texto',
                            'texto_archivo' => $request['mensaje-seccion-cuatro-c'],
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                        $idArchivooTresNombreOriginal = $request['mensaje-seccion-cuatro-c'];
                    } else {
                        if ($request->file('file-seccion-cuatro-c-upload-manual') != null) {
                            $fileUno = $request->file('file-seccion-cuatro-c-upload-manual');
                        } else {
                            $fileUno = $request->file('file-seccion-cuatro-c');
                        }
                        $this->processData($fileUno, 3);
                        $idArchivooTresNombreOriginal = $fileUno->getClientOriginalName();
                    }
                    $idArchivoTres =  DB::table('archivos')->where('nombre', $idArchivooTresNombreOriginal)->first();

                    //              Creo el registro en la tabla contenidos                
                    DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                        // 'nombre' =>             $request->input('content-name'),
                        'formato_template' =>   $request->input('tipo-region'),
                        'id_archivo_tres' =>    $idArchivoTres->id,
                        'id_estado' => $estadoDispo,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                if ($request['regionCuatroDetalleCuatro'] != "default") {

                    if ($request['file-seccion-cuatro-d-url'] != null) {
                        $this->processYoutube($request['file-seccion-cuatro-d-url']);
                        $idArchivooCuatroNombreOriginal = $request['file-seccion-cuatro-d-url'];
                    } else if ($request['mensaje-seccion-cuatro-d'] != null) {
                        DB::table('archivos')->insert([
                            'nombre' => $request['mensaje-seccion-cuatro-d'], 'tipo' => 'texto',
                            'texto_archivo' => $request['mensaje-seccion-cuatro-d'],
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                        $idArchivooCuatroNombreOriginal = $request['mensaje-seccion-cuatro-d'];
                    } else {
                        if ($request->file('file-seccion-cuatro-d-upload-manual') != null) {
                            $fileUno = $request->file('file-seccion-cuatro-d-upload-manual');
                        } else {
                            $fileUno = $request->file('file-seccion-cuatro-d');
                        }
                        $this->processData($fileUno, 4);
                        $idArchivooCuatroNombreOriginal = $fileUno->getClientOriginalName();
                    }
                    $idArchivoCuatro =  DB::table('archivos')->where('nombre', $idArchivooCuatroNombreOriginal)->first();

                    //              Creo el registro en la tabla contenidos                
                    DB::table('contenidos')->where('nombre', $request->input('content-name'))->update([
                        // 'nombre' =>             $request->input('content-name'),
                        'formato_template' =>   $request->input('tipo-region'),
                        'id_archivo_cuatro' =>    $idArchivoCuatro->id,
                        'id_estado' => $estadoDispo,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }
                Log::info('Se actualizo a cuatro contenidos  template con exito');
                break;
        }

        $contenidos = DB::table('contenidos')->get();
        $regions = array();

        foreach ($contenidos as $contenido) {
            $region = array();
            $region['name'] = $contenido->nombre;
            $region['cant_disp'] = DB::table('clientes')->where('id_contenido', $contenido->id)->count();
            $id_estado = $contenido->id_estado;
            $auxEstate =  DB::table('estados')->where('id', $id_estado)->first();
            $region['estado'] = $auxEstate->estado;
            $region['region_size'] = $contenido->formato_template;

            if ($contenido->id_archivo_uno != null) {
                $id_archivo_uno = DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                $region['archivoUnoUrl'] = $id_archivo_uno->youtube_url;
                $region['archivoUnoTipo'] = $id_archivo_uno->tipo;
                $region['archivoUnoUbicacion'] = $id_archivo_uno->ubicacion;
                $region['archivoUnoTexto'] = $id_archivo_uno->texto_archivo;
            }
            if ($contenido->id_archivo_dos != null) {
                $id_archivo_dos = DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                $region['archivoDosUrl'] = $id_archivo_dos->youtube_url;
                $region['archivoDosTipo'] = $id_archivo_dos->tipo;
                $region['archivoDosUbicacion'] = $id_archivo_dos->ubicacion;
                $region['archivoDosTexto'] = $id_archivo_dos->texto_archivo;
            }
            if ($contenido->id_archivo_tres != null) {
                $id_archivo_tres = DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                $region['archivoTresUrl'] = $id_archivo_tres->youtube_url;
                $region['archivoTresTipo'] =  $id_archivo_tres->tipo;
                $region['archivoTresUbicacion'] = $id_archivo_tres->ubicacion;
                $region['archivoTresTexto'] = $id_archivo_tres->texto_archivo;
            }
            if ($contenido->id_archivo_cuatro != null) {
                $id_archivo_cuatro = DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
                $region['archivoCuatroUrl'] = $id_archivo_cuatro->youtube_url;
                $region['archivoCuatroTipo'] = $id_archivo_cuatro->tipo;
                $region['archivoCuatroUbicacion'] = $id_archivo_cuatro->ubicacion;
                $region['archivoCuatroTexto'] = $id_archivo_cuatro->texto_archivo;
            }



            array_push($regions, $region);
        }

        return view('/home', ['regions' => $regions, 'messageType' => 'modificacion', 'region_id' => $request->input('content-name')]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //VALIDACION DE FORMATO
        if ($request->input('tipo-region') == null) {            
            return redirect("/content/create")->withErrors(['Tiene que seleccionar un formato de template']);
        }
        if ($request->input('content-name') == null) {            
            return redirect("/content/create")->withErrors(['Todo contenido tiene que llevar un nombre']);
        } else if (
            Str::contains(strtolower($request['content-name']), "<script>") || 
            Str::contains(strtolower($request['content-name']), "select * from") ||
            Str::contains(strtolower($request['content-name']), "drop down")) {
            $return["value"] = false;
            $return["desc"] = 'No se permite esa operatoria en los input de texto';
            return  $return;
        }
        
        
        
        //VALIDACION DE BLANCOS Y DE YOTUUBE Y DE CARACTERES EN TEXTOS VA NULL EN EL ULTIMO PARAMETRO PORQUE EN ESTE LENGUAJE NEFASTO NO EXISTE UN HANDLER COMO EN TEORIA DE OBJETOS
        //PARAMETROS : REQUEST, SI ES O NO MODIFICACION Y EL ESTADO ANTERIOR
        $validatorBlank = self::contentGeneralValidator($request, false, null);
        
        if ($validatorBlank["value"] == false) {
            // dd($validatorBlank);
            return redirect("/content/create")->withErrors([$validatorBlank["desc"]]);
        }

        // $this->checkEmptyValue($request);
        //VALIDACION DE ARCHIVOS
        $request->validate([
            'content-name' => ['required', new UniqueContentName],
            // Region una
            'file-seccion-una-a' => ['mimes:jpeg,png,jpg', 'max:5048',],
            // Region tres
            'file-seccion-tres-a' => ['mimes:jpeg,png,jpg', 'max:5048',],
            'file-seccion-tres-b' => ['mimes:jpeg,png,jpg', 'max:5048',],
            'file-seccion-tres-c' => ['mimes:jpeg,png,jpg', 'max:5048',],
            // Region Cuatro
            'file-seccion-cuatro-a' => ['mimes:jpeg,png,jpg', 'max:5048',],
            'file-seccion-cuatro-b' => ['mimes:jpeg,png,jpg', 'max:5048',],
            'file-seccion-cuatro-c' => ['mimes:jpeg,png,jpg', 'max:5048',],
            'file-seccion-cuatro-d' => ['mimes:jpeg,png,jpg', 'max:5048',],
        ]);
        //     'file-seccion-una-a-upload-manual' => ['mimes:mp4 ', 'max:20000',],
        //     'file-seccion-tres-a-upload-manual' =>  ['mimes:mp4 ', 'max:20000',],
        //     'file-seccion-tres-b-upload-manual' =>  ['mimes:mp4 ', 'max:20000',],
        //     'file-seccion-tres-c' => ['mimes:jpeg,png,jpg', 'max:5048',],
        //     'file-seccion-tres-c-upload-manual' =>  ['mimes:mp4 ', 'max:20000',],
        //     // Region Cuatro
        //     'file-seccion-cuatro-a' => ['mimes:jpeg,png,jpg', 'max:5048',],
        //     'file-seccion-cuatro-a-upload-manual' =>  ['mimes:mp4 ', 'max:20000',],
        //     'file-seccion-cuatro-b' => ['mimes:jpeg,png,jpg', 'max:5048',],
        //     'file-seccion-cuatro-b-upload-manual' =>  ['mimes:mp4 ', 'max:20000',],
        //     'file-seccion-cuatro-c' => ['mimes:jpeg,png,jpg', 'max:5048',],
        //     'file-seccion-cuatro-c-upload-manual' =>  ['mimes:mp4 ', 'max:20000',],
        //     'file-seccion-cuatro-d' => ['mimes:jpeg,png,jpg', 'max:5048',],
        //     'file-seccion-cuatro-d-upload-manual' =>  ['mimes:mp4 ', 'max:20000',],
        // ]);

        if ($request->get("estado-contenido", 0) === "on") {
            $estadoDispo = 4;
        } else {
            $estadoDispo = 3;
        }
        switch ($request->input('tipo-region')) {
            case "1":
                switch ($request->input('regionUnoDetalleUno')) {
                    case "imagen":
                        $this->processData($request->file('file-seccion-una-a'), 1);
                        $idArchivooUnoNombreOriginal = $request->file('file-seccion-una-a')->getClientOriginalName();
                        $idArchivoUno =  DB::table('archivos')->where('nombre', $idArchivooUnoNombreOriginal)->first();

                        DB::table('contenidos')->insert([
                            'nombre' => $request->input('content-name'),
                            'formato_template' => $request->input('tipo-region'),
                            'id_archivo_uno' => $idArchivoUno->id,
                            'id_estado' => $estadoDispo,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        break;
                    case "texto";
                        DB::table('archivos')->insert([
                            'nombre' => $request['mensaje-seccion-una-a'], 'tipo' => 'texto',
                            'texto_archivo' => $request['mensaje-seccion-una-a'],
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);
                        $idArchivoUno =  DB::table('archivos')->where('nombre', $request['mensaje-seccion-una-a'])->first();
                        DB::table('contenidos')->insert([
                            'nombre' => $request->input('content-name'),
                            'formato_template' => $request->input('tipo-region'),
                            'id_archivo_uno' => $idArchivoUno->id,
                            'id_estado' => $estadoDispo,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                        ]);

                        break;
                    case "video":
                        if ($request->file('file-seccion-una-a-upload-manual') == null) {
                            $idArchivooUnoNombreOriginal = $request['file-seccion-una-a-url'];
                            $this->processYoutube($request['file-seccion-una-a-url']);
                            $idArchivoUno =  DB::table('archivos')->where('nombre', $idArchivooUnoNombreOriginal)->first();
                            DB::table('contenidos')->insert([
                                'nombre' => $request->input('content-name'),
                                'formato_template' => $request->input('tipo-region'),
                                'id_archivo_uno' => $idArchivoUno->id,
                                'id_estado' => $estadoDispo,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                        } else {
                            $this->processData($request->file('file-seccion-una-a-upload-manual'), 1);
                            $idArchivooUnoNombreOriginal = $request->file('file-seccion-una-a-upload-manual')->getClientOriginalName();
                            $idArchivoUno =  DB::table('archivos')->where('nombre', $idArchivooUnoNombreOriginal)->first();
                            DB::table('contenidos')->insert([
                                'nombre' => $request->input('content-name'),
                                'formato_template' => $request->input('tipo-region'),
                                'id_archivo_uno' => $idArchivoUno->id,
                                'id_estado' => $estadoDispo,
                                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                        }
                        break;
                }
                Log::info('Se creo contenido template con exito');
                break;

            case "3":

                if ($request['file-seccion-tres-a-url'] != null) {
                    $this->processYoutube($request['file-seccion-tres-a-url']);
                    $idArchivooUnoNombreOriginal = $request['file-seccion-tres-a-url'];
                } else if ($request['mensaje-seccion-tres-a'] != null) {
                    DB::table('archivos')->insert([
                        'nombre' => $request['mensaje-seccion-tres-a'], 'tipo' => 'texto',
                        'texto_archivo' => $request['mensaje-seccion-tres-a'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $idArchivooUnoNombreOriginal = $request['mensaje-seccion-tres-a'];
                } else {
                    if ($request->file('file-seccion-tres-a-upload-manual') != null) {
                        $fileUno = $request->file('file-seccion-tres-a-upload-manual');
                    } else {
                        $fileUno = $request->file('file-seccion-tres-a');
                    }
                    $this->processData($fileUno, 1);
                    $idArchivooUnoNombreOriginal = $fileUno->getClientOriginalName();
                }


                if ($request['file-seccion-tres-b-url'] != null) {
                    $this->processYoutube($request['file-seccion-tres-b-url']);
                    $idArchivooDosNombreOriginal = $request['file-seccion-tres-b-url'];
                } else if ($request['mensaje-seccion-tres-b'] != null) {
                    DB::table('archivos')->insert([
                        'nombre' => $request['mensaje-seccion-tres-b'], 'tipo' => 'texto',
                        'texto_archivo' => $request['mensaje-seccion-tres-b'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $idArchivooDosNombreOriginal = $request['mensaje-seccion-tres-b'];
                } else {
                    if ($request->file('file-seccion-tres-b-upload-manual') != null) {
                        $fileUno = $request->file('file-seccion-tres-b-upload-manual');
                    } else {
                        $fileUno = $request->file('file-seccion-tres-b');
                    }
                    $this->processData($fileUno, 2);
                    $idArchivooDosNombreOriginal = $fileUno->getClientOriginalName();
                }

                if ($request['file-seccion-tres-c-url'] != null) {
                    $this->processYoutube($request['file-seccion-tres-c-url']);
                    $idArchivooTresNombreOriginal = $request['file-seccion-tres-c-url'];
                } else if ($request['mensaje-seccion-tres-c'] != null) {
                    DB::table('archivos')->insert([
                        'nombre' => $request['mensaje-seccion-tres-c'], 'tipo' => 'texto',
                        'texto_archivo' => $request['mensaje-seccion-tres-c'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $idArchivooTresNombreOriginal = $request['mensaje-seccion-tres-c'];
                } else {
                    if ($request->file('file-seccion-tres-c-upload-manual') != null) {
                        $fileUno = $request->file('file-seccion-tres-c-upload-manual');
                    } else {
                        $fileUno = $request->file('file-seccion-tres-c');
                    }
                    $this->processData($fileUno, 3);
                    $idArchivooTresNombreOriginal = $fileUno->getClientOriginalName();
                }



                $idArchivoUno =  DB::table('archivos')->where('nombre', $idArchivooUnoNombreOriginal)->first();
                $idArchivoDos =  DB::table('archivos')->where('nombre', $idArchivooDosNombreOriginal)->first();
                $idArchivoTres =  DB::table('archivos')->where('nombre', $idArchivooTresNombreOriginal)->first();

                //              Creo el registro en la tabla contenidos                
                DB::table('contenidos')->insert([
                    'nombre' =>             $request->input('content-name'),
                    'formato_template' =>   $request->input('tipo-region'),
                    'id_archivo_uno' =>     $idArchivoUno->id,
                    'id_archivo_dos' =>     $idArchivoDos->id,
                    'id_archivo_tres' =>    $idArchivoTres->id,
                    'id_estado' => $estadoDispo,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
                Log::info('Se creo contenidos de template 3 con exito');
                break;
            case "4":

                if ($request['file-seccion-cuatro-a-url'] != null) {
                    $this->processYoutube($request['file-seccion-cuatro-a-url']);
                    $idArchivooUnoNombreOriginal = $request['file-seccion-cuatro-a-url'];
                } else                 if ($request['mensaje-seccion-cuatro-a'] != null) {
                    DB::table('archivos')->insert([
                        'nombre' => $request['mensaje-seccion-cuatro-a'], 'tipo' => 'texto',
                        'texto_archivo' => $request['mensaje-seccion-cuatro-a'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $idArchivooUnoNombreOriginal = $request['mensaje-seccion-cuatro-a'];
                } else {
                    if ($request->file('file-seccion-cuatro-a-upload-manual') != null) {
                        $fileUno = $request->file('file-seccion-cuatro-a-upload-manual');
                    } else {
                        $fileUno = $request->file('file-seccion-cuatro-a');
                    }
                    $this->processData($fileUno, 1);
                    $idArchivooUnoNombreOriginal = $fileUno->getClientOriginalName();
                }


                if ($request['file-seccion-cuatro-b-url'] != null) {
                    $this->processYoutube($request['file-seccion-cuatro-b-url']);
                    $idArchivooDosNombreOriginal = $request['file-seccion-cuatro-b-url'];
                } else                 if ($request['mensaje-seccion-cuatro-b'] != null) {
                    DB::table('archivos')->insert([
                        'nombre' => $request['mensaje-seccion-cuatro-b'], 'tipo' => 'texto',
                        'texto_archivo' => $request['mensaje-seccion-cuatro-b'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $idArchivooDosNombreOriginal = $request['mensaje-seccion-cuatro-b'];
                } else {
                    if ($request->file('file-seccion-cuatro-b-upload-manual') != null) {
                        $fileUno = $request->file('file-seccion-cuatro-b-upload-manual');
                    } else {
                        $fileUno = $request->file('file-seccion-cuatro-b');
                    }
                    $this->processData($fileUno, 2);
                    $idArchivooDosNombreOriginal = $fileUno->getClientOriginalName();
                }

                if ($request['file-seccion-cuatro-c-url'] != null) {
                    $this->processYoutube($request['file-seccion-cuatro-c-url']);
                    $idArchivooTresNombreOriginal = $request['file-seccion-cuatro-c-url'];
                } else  if ($request['mensaje-seccion-cuatro-c'] != null) {
                    DB::table('archivos')->insert([
                        'nombre' => $request['mensaje-seccion-cuatro-c'], 'tipo' => 'texto',
                        'texto_archivo' => $request['mensaje-seccion-cuatro-c'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $idArchivooTresNombreOriginal = $request['mensaje-seccion-cuatro-c'];
                } else {
                    if ($request->file('file-seccion-cuatro-c-upload-manual') != null) {
                        $fileUno = $request->file('file-seccion-cuatro-c-upload-manual');
                    } else {
                        $fileUno = $request->file('file-seccion-cuatro-c');
                    }
                    $this->processData($fileUno, 3);
                    $idArchivooTresNombreOriginal = $fileUno->getClientOriginalName();
                }

                if ($request['file-seccion-cuatro-d-url'] != null) {
                    $this->processYoutube($request['file-seccion-cuatro-d-url']);
                    $idArchivooCuatroNombreOriginal = $request['file-seccion-cuatro-d-url'];
                } else if ($request['mensaje-seccion-cuatro-d'] != null) {
                    DB::table('archivos')->insert([
                        'nombre' => $request['mensaje-seccion-cuatro-d'], 'tipo' => 'texto',
                        'texto_archivo' => $request['mensaje-seccion-cuatro-d'],
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    $idArchivooCuatroNombreOriginal = $request['mensaje-seccion-cuatro-d'];
                } else {
                    if ($request->file('file-seccion-cuatro-d-upload-manual') != null) {
                        $fileUno = $request->file('file-seccion-cuatro-d-upload-manual');
                    } else {
                        $fileUno = $request->file('file-seccion-cuatro-d');
                    }
                    $this->processData($fileUno, 4);
                    $idArchivooCuatroNombreOriginal = $fileUno->getClientOriginalName();
                }


                $idArchivoUno =  DB::table('archivos')->where('nombre', $idArchivooUnoNombreOriginal)->first();
                $idArchivoDos =  DB::table('archivos')->where('nombre', $idArchivooDosNombreOriginal)->first();
                $idArchivoTres =  DB::table('archivos')->where('nombre', $idArchivooTresNombreOriginal)->first();
                $idArchivoCuatro =  DB::table('archivos')->where('nombre', $idArchivooCuatroNombreOriginal)->first();

                //              Creo el registro en la tabla contenidos                
                DB::table('contenidos')->insert([
                    'nombre' =>             $request->input('content-name'),
                    'formato_template' =>   $request->input('tipo-region'),
                    'id_archivo_uno' =>     $idArchivoUno->id,
                    'id_archivo_dos' =>     $idArchivoDos->id,
                    'id_archivo_tres' =>    $idArchivoTres->id,
                    'id_archivo_cuatro' =>    $idArchivoCuatro->id,
                    'id_estado' => $estadoDispo,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
                Log::info('Se creo contenidos de template 4 con exito');
                break;
        }
        return redirect("/home");
    }


    function processYoutube($url)
    {

        DB::table('archivos')->insert([
            'nombre' => $url,
            'ubicacion' => "",
            'tipo' => "youtube",
            'youtube_url' => $url,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
    function processData($data)
    {
        $originalFileName = $data->getClientOriginalName();

        $path = $data->store('image', 's3');
        Log::info('Se subio a s3 con exito');
        DB::table('archivos')->insert([
            'nombre' => $originalFileName,
            'ubicacion' => $path,
            'tipo' => $data->getMimeType(),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        Storage::disk('s3')->setVisibility($path, "public");
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy($contentName)
    {

        // $aux = Content::find($contentName);
        // dd($aux);
        $contentData = DB::table('contenidos')->where('nombre', $contentName)->first();

        //agregar if para los demas casos
        $archivoUno = DB::table('archivos')->where('id', $contentData->id_archivo_uno)->first();

        DB::table('clientes')->where('id_contenido', $contentData->id)->delete();
        DB::table('contenidos')->where('nombre', $contentName)->delete();
        //borro los archivos en la nube
        Storage::disk('s3')->delete($archivoUno->ubicacion);
        Log::info('Se borro de s3 con exito');
        //borro los archivos asociados
        DB::table('archivos')->where('id', $contentData->id_archivo_uno)->delete();
        //borro los clientes asociados

        // return response($contentName, 200);
    }



    public function showByName($name)
    {        
        $idRegion = DB::table('contenidos')->where('nombre', '=', $name)->value('id');
        $nombreRegion = $name;
        $auxDispositivosAsociadosAlaRegion = DB::table('clientes')->where('id_contenido', $idRegion)->get();
        $allDisplayAssociateToRegionn['data'] = array();
        $allDisplayAssociateToRegionn['nombre_region'] = $nombreRegion;

        $contenido =  DB::table('contenidos')->where('nombre', '=', $name)->first();
        $status = DB::table('estados')->where('id', '=', $contenido->id_estado)->first();
        $allDisplayAssociateToRegionn['status'] = $status->estado;
        $i = 0;
        $region = array();
        $region["region_size"] = $contenido->formato_template;
        $region["name"] = $contenido->nombre;
        foreach ($auxDispositivosAsociadosAlaRegion as $auxDispositivo) {
            $display = array();
            $idDetalle = $auxDispositivo->id_contenido;

            $detail =  DB::table('contenidos')->where('id', $idDetalle)->first();
            $display['name'] = $detail->nombre;
            $display['adress'] = $auxDispositivo->clientId;
            $idStatus =  $auxDispositivo->id_estado;
            $status = DB::table('estados')->where('id', $idStatus)->first();
            $display['status'] = $status->estado;
            array_push($allDisplayAssociateToRegionn['data'], $display);
            $i++;
        }


        if ($contenido->id_archivo_uno != null) {
            $id_archivo_uno = DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
            $region['archivoUnoUrl'] = $id_archivo_uno->youtube_url;
            $region['archivoUnoTipo'] = $id_archivo_uno->tipo;
            $region['archivoUnoUbicacion'] = $id_archivo_uno->ubicacion;
            $region['archivoUnoTexto'] = $id_archivo_uno->texto_archivo;
        }
        if ($contenido->id_archivo_dos != null) {
            $id_archivo_dos = DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
            $region['archivoDosUrl'] = $id_archivo_dos->youtube_url;
            $region['archivoDosTipo'] = $id_archivo_dos->tipo;
            $region['archivoDosUbicacion'] = $id_archivo_dos->ubicacion;
            $region['archivoDosTexto'] = $id_archivo_dos->texto_archivo;
        }
        if ($contenido->id_archivo_tres != null) {
            $id_archivo_tres = DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
            $region['archivoTresUrl'] = $id_archivo_tres->youtube_url;
            $region['archivoTresTipo'] =  $id_archivo_tres->tipo;
            $region['archivoTresUbicacion'] = $id_archivo_tres->ubicacion;
            $region['archivoTresTexto'] = $id_archivo_tres->texto_archivo;
        }
        if ($contenido->id_archivo_cuatro != null) {
            $id_archivo_cuatro = DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
            $region['archivoCuatroUrl'] = $id_archivo_cuatro->youtube_url;
            $region['archivoCuatroTipo'] = $id_archivo_cuatro->tipo;
            $region['archivoCuatroUbicacion'] = $id_archivo_cuatro->ubicacion;
            $region['archivoCuatroTexto'] = $id_archivo_cuatro->texto_archivo;
        }

        $allDisplayAssociateToRegionn['cant_display'] = $i;
        $allDisplayAssociateToRegionn['hash_region_key'] = $contenido->nombre;
        // dd($allDisplayAssociateToRegionn);
        return view('contentDetail', ['detalle_contenido' => $allDisplayAssociateToRegionn, 'messageType' => 'new', 'region' => $region]);
    }

    public function getSelectedContentEmergency($contentName)
    {
        $idRegion = DB::table('contenidos')->where('nombre', '=', $contentName)->first();
        $estado = DB::table('estados')->where('id', '=', $idRegion->id_estado)->first();
        $dataMultimediales =  DB::table('archivos')->where('id', $idRegion->id)->get();
        $response['archivos'] = array();
        foreach ($dataMultimediales as $multimedia) {

            $auxResponse = array();


            $auxResponse['nombre_archivo'] =  $multimedia->nombre;

            array_push($response['archivos'], $auxResponse);
        }

        $response['content_size'] = $idRegion->formato_template;
        $response['contentNombre'] =  $idRegion->nombre;
        $response['regionSelected'] = true;
        $response['content_hash'] = $idRegion->nombre;
        $response['estado'] =  $estado->estado;

        $aux = DB::table('contenidos')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('clientes')->where('id_contenido', $idRegion)->count();
            $id_estado = $data->id_estado;
            $auxEstate =  DB::table('estados')->where('id', $id_estado)->first();
            $region['estado'] = $auxEstate->estado;
            $region['nombre_encryptado'] = $data->nombre;
            array_push($regions, $region);
        }

        return view('contentModify', ['regionData' => $response, 'regionSelected' => true]);
    }
    public function getSelectedContent(Request $request)
    {

        $idRegion = DB::table('contenidos')->where('nombre', '=', $request['region-name'])->first();
        $estado = DB::table('estados')->where('id', '=', $idRegion->id_estado)->first();
        $dataMultimediales =  DB::table('archivos')->where('id', $idRegion->id)->get();
        $response['archivos'] = array();
        foreach ($dataMultimediales as $multimedia) {

            $auxResponse = array();


            $auxResponse['nombre_archivo'] =  $multimedia->nombre;

            array_push($response['archivos'], $auxResponse);
        }

        $response['content_size'] = $idRegion->formato_template;
        $response['contentNombre'] =  $idRegion->nombre;
        $response['regionSelected'] = true;
        $response['content_hash'] = $idRegion->nombre;
        $response['estado'] =  $estado->estado;
        return view('contentModify', ['regionData' => $response, 'regionSelected' => true]);
    }


    public function getContentToModify(Request $request)
    {
        //
        $aux = DB::table('contenidos')->get();
        $regions = array();

        foreach ($aux as $data) {
            $region = array();
            $region['name'] = $data->nombre;
            $idRegion = $data->id;
            $region['cant_disp'] = DB::table('clientes')->where('id_contenido', $idRegion)->count();
            $id_estado = $data->id_estado;
            $auxEstate =  DB::table('estados')->where('id', $id_estado)->first();
            $region['estado'] = $auxEstate->estado;
            $region['nombre'] = $data->nombre;
            array_push($regions, $region);
        }

        return view('contentModify', ['regions' => $regions, 'regionSelected' => false]);
    }

    // VALIDADOR GENERAL
    function contentGeneralValidator($request, $isUpdate, $previousState)
    {
        $return = array();
        switch ($request->input('tipo-region')) {
            case "1":
                // REGION UNO

                if ($isUpdate) {
                    if ($previousState->formato_template != $request['tipo-region']) {
                        if ($request['regionUnoDetalleUno'] == "default") {
                            $return["value"] = false;
                            $return["desc"] = 'Usted cambio de formato de template, es mandatorio tener todos los campos completados';
                            return  $return;
                        }
                    } else {
                        if ($request['regionUnoDetalleUno'] == "default") {
                            $return["value"] = false;
                            $return["desc"] = 'Datos sin cargar para el template selecionado';
                            return $return;
                        }
                    }
                }

                if ($request['regionUnoDetalleUno'] == "imagen") {
                    if ($request->file('file-seccion-una-a') == null) {
                        $return["value"] = false;
                        $return["desc"] = 'Archivo imagen vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-una-a') != null) {
                        if (($request->file('file-seccion-una-a')->getMimeType() != "image/jpeg") &&
                            ($request->file('file-seccion-una-a')->getMimeType() != "image/png")  &&
                            ($request->file('file-seccion-una-a')->getMimeType() != "image/jpg") 
                            ){                    
                            $return["value"] = false;
                            $return["desc"] = 'Archivo imagen solo en JPEG, PNG o JPG';
                            return  $return;                        
                        }
                    }
                } else if ($request['regionUnoDetalleUno'] == "video") {                    
                    if ($request->file('file-seccion-una-a-upload-manual') == null && $request['file-seccion-una-a-url'] == null) {
                        $return["value"] = false;
                        $return["desc"] = 'Archivo Video o Link de youtube vacio';
                        return  $return;
                    }else if ($request->file('file-seccion-una-a-upload-manual') != null){
                        if($request->file('file-seccion-una-a-upload-manual')->getMimeType() !="video/mp4"){                            
                            $return["value"] = false;
                            $return["desc"] = 'Solo se permite video/mp4 en videos subidos manual';
                            return $return;
                        }
                    }
                    
                    if ($request['file-seccion-una-a-url'] != null) {
                        $contains = Str::contains($request['file-seccion-una-a-url'], ['www.youtube.com/embed/']);
                        if ($contains == false) {
                            $return["value"] = false;
                            $return["desc"] = 'Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ';
                            return  $return;
                        }else if (
                            Str::contains(strtolower($request['file-seccion-una-a-url']), "<script>") || 
                            Str::contains(strtolower($request['file-seccion-una-a-url']), "select * from") ||
                            Str::contains(strtolower($request['file-seccion-una-a-url']), "drop down")) {
                            $return["value"] = false;
                            $return["desc"] = 'No se permite esa operatoria en los input de texto';
                            return  $return;
                        }
                    }
                } else if ($request['regionUnoDetalleUno'] == "texto") {
                    if ($request['mensaje-seccion-una-a'] == null) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto esta vacio';
                        return  $return;
                    } else if (strlen($request['mensaje-seccion-una-a']) > 255) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto supera el limite permitido (limite 255 caracteres)';
                        return  $return;
                    } else if (
                        Str::contains(strtolower($request['mensaje-seccion-una-a']), "<script>") || 
                        Str::contains(strtolower($request['mensaje-seccion-una-a']), "select * from") ||
                        Str::contains(strtolower($request['mensaje-seccion-una-a']), "drop down")) {
                        $return["value"] = false;
                        $return["desc"] = 'No se permite esa operatoria en los input de texto';
                        return  $return;
                    }
                } else if ($request['regionUnoDetalleUno'] == "default") {
                    if ($request['mensaje-seccion-una-a'] == null) {
                        $return["value"] = false;
                        $return["desc"] = 'Se tiene que ingresar un contenido';
                        return  $return;
                    }
                }
                break;
            case "3":
                // ['regionTresDetalleDos']
                // ['regionTresDetalleTres']
                // REGION TRES

                if ($isUpdate) {
                    if ($previousState->formato_template != $request['tipo-region']) {
                        if ($request['regionTresDetalleUno'] == "default" ||  $request['regionTresDetalleDos'] == "default" || $request['regionTresDetalleTres'] == "default") {
                            $return["value"] = false;
                            $return["desc"] = 'Usted cambio de formato de template, es mandatorio tener todos los campos completados';
                            return  $return;
                        }
                    } else {
                        if ($request['regionTresDetalleUno'] == "default" &&  $request['regionTresDetalleDos'] == "default" && $request['regionTresDetalleTres'] == "default") {
                            $return["value"] = false;
                            $return["desc"] = 'Datos sin cargar para el template selecionado';
                            return $return;
                        }
                    }
                }else{
                    if ($request['regionTresDetalleTres'] == "default" && $request['regionTresDetalleDos'] == "default" && $request['regionTresDetalleUno'] == "default") {
                        if ($request['mensaje-seccion-tres-a'] == null) {
                            $return["value"] = false;
                            $return["desc"] = 'Datos sin cargar para el template selecionado';
                            return  $return;
                        }
                    }
                }

                if ($request['regionTresDetalleUno'] == "imagen") {

                    if ($request->file('file-seccion-tres-a') == null) {
                        // return redirect("/content/create")->withErrors(['Archivo imagen vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo imagen vacio';
                        return  $return;
                    }
                    if($request->file('file-seccion-tres-a') != null){
                        if (($request->file('file-seccion-tres-a')->getMimeType() != "image/jpeg") &&
                        ($request->file('file-seccion-tres-a')->getMimeType() != "image/png")  &&
                        ($request->file('file-seccion-tres-a')->getMimeType() != "image/jpg") 
                        ){                    
                            $return["value"] = false;
                            $return["desc"] = 'Archivo imagen solo en JPEG, PNG o JPG';
                            return  $return;                        
                        }
                    }
                } else if ($request['regionTresDetalleUno'] == "video") {
                    if ($request->file('file-seccion-tres-a-upload-manual') == null && $request['file-seccion-tres-a-url'] == null) {
                        // return redirect("/content/create")->withErrors(['Archivo Video o Link de youtube vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo Video o Link de youtube vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-tres-a-upload-manual') != null){
                        if($request->file('file-seccion-tres-a-upload-manual')->getMimeType() !="video/mp4"){                            
                            $return["value"] = false;
                            $return["desc"] = 'Solo se permite video/mp4 en videos subidos manual';
                            return $return;
                        }
                    }
                    if ($request['file-seccion-tres-a-url'] != null) {
                        $contains = Str::contains($request['file-seccion-tres-a-url'], ['www.youtube.com/embed/']);
                        if ($contains == false) {
                            // return redirect("/content/create")->withErrors(['Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ']);
                            $return["value"] = false;
                            $return["desc"] = 'Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ';
                            return  $return;
                        }else if (
                            Str::contains(strtolower($request['file-seccion-tres-a-url']), "<script>") || 
                            Str::contains(strtolower($request['file-seccion-tres-a-url']), "select * from") ||
                            Str::contains(strtolower($request['file-seccion-tres-a-url']), "drop down")) {
                            $return["value"] = false;
                            $return["desc"] = 'No se permite esa operatoria en los input de texto';
                            return  $return;
                        }
                    }
                } else if ($request['regionTresDetalleUno'] == "texto") {
                    if ($request['mensaje-seccion-tres-a'] == null) {
                        // return redirect("/content/create")->withErrors(['El texto esta vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'El texto esta vacio';
                        return  $return;
                    } else if (strlen($request['mensaje-seccion-tres-a']) > 255) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto supera el limite permitido (limite 255 caracteres)';
                        return  $return;
                    }else if (
                        Str::contains(strtolower($request['mensaje-seccion-tres-a']), "<script>") || 
                        Str::contains(strtolower($request['mensaje-seccion-tres-a']), "select * from") ||
                        Str::contains(strtolower($request['mensaje-seccion-tres-a']), "drop down")) {
                        $return["value"] = false;
                        $return["desc"] = 'No se permite esa operatoria en los input de texto';
                        return  $return;
                    }
                }


                if ($request['regionTresDetalleDos'] == "imagen") {
                    if ($request->file('file-seccion-tres-b') == null) {
                        // return redirect("/content/create")->withErrors(['Archivo imagen vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo imagen vacio';
                        return  $return;
                    }
                    if($request->file('file-seccion-tres-b') != null){
                        if (($request->file('file-seccion-tres-b')->getMimeType() != "image/jpeg") &&
                        ($request->file('file-seccion-tres-b')->getMimeType() != "image/png")  &&
                        ($request->file('file-seccion-tres-b')->getMimeType() != "image/jpg") 
                        ){                    
                            $return["value"] = false;
                            $return["desc"] = 'Archivo imagen solo en JPEG, PNG o JPG';
                            return  $return;                        
                        }
                    }
                } else if ($request['regionTresDetalleDos'] == "video") {
                    if ($request->file('file-seccion-tres-b-upload-manual') == null && $request['file-seccion-tres-b-url'] == null) {
                        // return redirect("/content/create")->withErrors(['Archivo Video o Link de youtube vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo Video o Link de youtube vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-tres-b-upload-manual') != null){
                        if($request->file('file-seccion-tres-b-upload-manual')->getMimeType() !="video/mp4"){                            
                            $return["value"] = false;
                            $return["desc"] = 'Solo se permite video/mp4 en videos subidos manual';
                            return $return;
                        }
                    }
                    if ($request['file-seccion-tres-b-url'] != null) {
                        $contains = Str::contains($request['file-seccion-tres-b-url'], ['www.youtube.com/embed/']);
                        if ($contains == false) {
                            // return redirect("/content/create")->withErrors(['Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ']);
                            $return["value"] = false;
                            $return["desc"] = 'Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ';
                            return  $return;
                        }else if (
                            Str::contains(strtolower($request['file-seccion-tres-b-url']), "<script>") || 
                            Str::contains(strtolower($request['file-seccion-tres-b-url']), "select * from") ||
                            Str::contains(strtolower($request['file-seccion-tres-b-url']), "drop down")) {
                            $return["value"] = false;
                            $return["desc"] = 'No se permite esa operatoria en los input de texto';
                            return  $return;
                        }
                    }
                } else if ($request['regionTresDetalleDos'] == "texto") {
                    if ($request['mensaje-seccion-tres-b'] == null) {
                        // return redirect("/content/create")->withErrors(['El texto esta vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'El texto esta vacio';
                        return  $return;
                    } else if (strlen($request['mensaje-seccion-tres-b']) > 255) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto supera el limite permitido (limite 255 caracteres)';
                        return  $return;
                    }else if (
                        Str::contains(strtolower($request['mensaje-seccion-tres-b']), "<script>") || 
                        Str::contains(strtolower($request['mensaje-seccion-tres-b']), "select * from") ||
                        Str::contains(strtolower($request['mensaje-seccion-tres-b']), "drop down")) {
                        $return["value"] = false;
                        $return["desc"] = 'No se permite esa operatoria en los input de texto';
                        return  $return;
                    }
                }
                if ($request['regionTresDetalleTres'] == "imagen") {
                    if ($request->file('file-seccion-tres-c') == null) {
                        // return redirect("/content/create")->withErrors(['Archivo imagen vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo imagen vacio';
                        return  $return;
                    }
                    if($request->file('file-seccion-tres-c') != null){
                        if (($request->file('file-seccion-tres-c')->getMimeType() != "image/jpeg") &&
                        ($request->file('file-seccion-tres-c')->getMimeType() != "image/png")  &&
                        ($request->file('file-seccion-tres-c')->getMimeType() != "image/jpg") 
                        ){                    
                            $return["value"] = false;
                            $return["desc"] = 'Archivo imagen solo en JPEG, PNG o JPG';
                            return  $return;                        
                        }
                    }
                } else if ($request['regionTresDetalleTres'] == "video") {
                    if ($request->file('file-seccion-tres-c-upload-manual') == null && $request['file-seccion-tres-c-url'] == null) {
                        // return redirect("/content/create")->withErrors(['Archivo Video o Link de youtube vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo Video o Link de youtube vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-tres-c-upload-manual') != null){
                        if($request->file('file-seccion-tres-c-upload-manual')->getMimeType() !="video/mp4"){                            
                            $return["value"] = false;
                            $return["desc"] = 'Solo se permite video/mp4 en videos subidos manual';
                            return $return;
                        }
                    }
                    if ($request['file-seccion-tres-c-url'] != null) {
                        $contains = Str::contains($request['file-seccion-tres-c-url'], ['www.youtube.com/embed/']);
                        if ($contains == false) {
                            // return redirect("/content/create")->withErrors(['Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ']);
                            $return["value"] = false;
                            $return["desc"] = 'Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ';
                            return  $return;
                        }else if (
                            Str::contains(strtolower($request['file-seccion-tres-c-url']), "<script>") || 
                            Str::contains(strtolower($request['file-seccion-tres-c-url']), "select * from") ||
                            Str::contains(strtolower($request['file-seccion-tres-c-url']), "drop down")) {
                            $return["value"] = false;
                            $return["desc"] = 'No se permite esa operatoria en los input de texto';
                            return  $return;
                        }
                    }
                } else if ($request['regionTresDetalleTres'] == "texto") {
                    if ($request['mensaje-seccion-tres-c'] == null) {
                        // return redirect("/content/create")->withErrors(['El texto esta vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'El texto esta vacio';
                        return  $return;
                    } else if (strlen($request['mensaje-seccion-tres-c']) > 255) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto supera el limite permitido (limite 255 caracteres)';
                        return  $return;
                    }else if (
                        Str::contains(strtolower($request['mensaje-seccion-tres-c']), "<script>") || 
                        Str::contains(strtolower($request['mensaje-seccion-tres-c']), "select * from") ||
                        Str::contains(strtolower($request['mensaje-seccion-tres-c']), "drop down")) {
                        $return["value"] = false;
                        $return["desc"] = 'No se permite esa operatoria en los input de texto';
                        return  $return;
                    }
                }                

                break;
            case "4":                
                if ($isUpdate) {
                    if ($previousState->formato_template != $request['tipo-region']) {
                        if ($request['regionCuatroDetalleUno'] == "default" ||  $request['regionCuatroDetalleDos'] == "default" || $request['regionCuatroDetalleTres'] == "default" || $request['regionCuatroDetalleCuatro'] == "default") {
                            $return["value"] = false;
                            $return["desc"] = 'Usted cambio de formato de template, es mandatorio tener todos los campos completados';
                            return  $return;
                        }
                    } else {
                        if ($request['regionCuatroDetalleUno'] == "default" &&  $request['regionCuatroDetalleDos'] == "default" && $request['regionCuatroDetalleTres'] == "default" && $request['regionCuatroDetalleCuatro'] == "default") {
                            $return["value"] = false;
                            $return["desc"] = 'Datos sin cargar para el template selecionado';
                            return  $return;
                        }
                    }
                } else {
                    if ($request['regionCuatroDetalleUno'] == "default" &&  $request['regionCuatroDetalleDos'] == "default" && $request['regionCuatroDetalleTres'] == "default" && $request['regionCuatroDetalleCuatro'] == "default") {
                        $return["value"] = false;
                        $return["desc"] = 'Datos sin cargar para el template selecionado';
                        return  $return;
                    }
                }

                if ($request['regionCuatroDetalleUno'] == "imagen") {
                    if ($request->file('file-seccion-cuatro-a') == null) {
                        // return redirect("/content/create")->withErrors(['Archivo imagen vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo imagen vacio';
                        return  $return;
                    }
                    if($request->file('file-seccion-cuatro-a') != null){
                        if (($request->file('file-seccion-cuatro-a')->getMimeType() != "image/jpeg") &&
                            ($request->file('file-seccion-cuatro-a')->getMimeType() != "image/png")  &&
                            ($request->file('file-seccion-cuatro-a')->getMimeType() != "image/jpg") 
                            ){                    
                            $return["value"] = false;
                            $return["desc"] = 'Archivo imagen solo en JPEG, PNG o JPG';
                            return  $return;                        
                        }
                    }
                } else if ($request['regionCuatroDetalleUno'] == "video") {
                    if ($request->file('file-seccion-cuatro-a-upload-manual') == null && $request['file-seccion-cuatro-a-url'] == null) {
                        // return redirect("/content/create")->withErrors(['Archivo Video o Link de youtube vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo Video o Link de youtube vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-cuatro-a-upload-manual') != null){
                        if($request->file('file-seccion-cuatro-a-upload-manual')->getMimeType() !="video/mp4"){                            
                            $return["value"] = false;
                            $return["desc"] = 'Solo se permite video/mp4 en videos subidos manual';
                            return $return;
                        }
                    }
                    if ($request['file-seccion-cuatro-a-url'] != null) {
                        $contains = Str::contains($request['file-seccion-cuatro-a-url'], ['www.youtube.com/embed/']);
                        if ($contains == false) {
                            // return redirect("/content/create")->withErrors(['Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ']);
                            $return["value"] = false;
                            $return["desc"] = 'Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ';
                            return  $return;
                        }else if (
                            Str::contains(strtolower($request['file-seccion-cuatro-a-url']), "<script>") || 
                            Str::contains(strtolower($request['file-seccion-cuatro-a-url']), "select * from") ||
                            Str::contains(strtolower($request['file-seccion-cuatro-a-url']), "drop down")) {
                            $return["value"] = false;
                            $return["desc"] = 'No se permite esa operatoria en los input de texto';
                            return  $return;
                        }
                    }
                } else if ($request['regionCuatroDetalleUno'] == "texto") {
                    if ($request['mensaje-seccion-cuatro-a'] == null) {
                        // return redirect("/content/create")->withErrors(['El texto esta vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'El texto esta vacio';
                        return  $return;
                    } else if (strlen($request['mensaje-seccion-cuatro-a']) > 255) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto supera el limite permitido (limite 255 caracteres)';
                        return  $return;
                    }else if (
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-a']), "<script>") || 
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-a']), "select * from") ||
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-a']), "drop down")) {
                        $return["value"] = false;
                        $return["desc"] = 'No se permite esa operatoria en los input de texto';
                        return  $return;
                    }
                }

                if ($request['regionCuatroDetalleDos'] == "imagen") {
                    if ($request->file('file-seccion-cuatro-b') == null) {
                        // return redirect("/content/create")->withErrors(['Archivo imagen vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo imagen vacio';
                        return  $return;
                    }
                    if($request->file('file-seccion-cuatro-b') != null){
                        if (($request->file('file-seccion-cuatro-b')->getMimeType() != "image/jpeg") &&
                        ($request->file('file-seccion-cuatro-b')->getMimeType() != "image/png")  &&
                        ($request->file('file-seccion-cuatro-b')->getMimeType() != "image/jpg") 
                        ){                    
                            $return["value"] = false;
                            $return["desc"] = 'Archivo imagen solo en JPEG, PNG o JPG';
                            return  $return;                        
                        }
                    }
                } else if ($request['regionCuatroDetalleDos'] == "video") {
                    if ($request->file('file-seccion-cuatro-b-upload-manual') == null && $request['file-seccion-cuatro-b-url'] == null) {
                        // return redirect("/content/create")->withErrors(['Archivo Video o Link de youtube vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo Video o Link de youtube vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-cuatro-b-upload-manual') != null){
                        if($request->file('file-seccion-cuatro-b-upload-manual')->getMimeType() !="video/mp4"){                            
                            $return["value"] = false;
                            $return["desc"] = 'Solo se permite video/mp4 en videos subidos manual';
                            return $return;
                        }
                    }
                    if ($request['file-seccion-cuatro-b-url'] != null) {
                        $contains = Str::contains($request['file-seccion-cuatro-b-url'], ['www.youtube.com/embed/']);
                        if ($contains == false) {
                            // return redirect("/content/create")->withErrors(['Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ']);
                            $return["value"] = false;
                            $return["desc"] = 'Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ';
                            return  $return;
                        }else if (
                            Str::contains(strtolower($request['file-seccion-cuatro-b-url']), "<script>") || 
                            Str::contains(strtolower($request['file-seccion-cuatro-b-url']), "select * from") ||
                            Str::contains(strtolower($request['file-seccion-cuatro-b-url']), "drop down")) {
                            $return["value"] = false;
                            $return["desc"] = 'No se permite esa operatoria en los input de texto';
                            return  $return;
                        }
                    }
                } else if ($request['regionCuatroDetalleDos'] == "texto") {
                    if ($request['mensaje-seccion-cuatro-b'] == null) {
                        // return redirect("/content/create")->withErrors(['El texto esta vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'El texto esta vacio';
                        return  $return;
                    } else if (strlen($request['mensaje-seccion-cuatro-b']) > 255) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto supera el limite permitido (limite 255 caracteres)';
                        return  $return;
                    }else if (
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-b']), "<script>") || 
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-b']), "select * from") ||
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-b']), "drop down")) {
                        $return["value"] = false;
                        $return["desc"] = 'No se permite esa operatoria en los input de texto';
                        return  $return;
                    }
                }

                if ($request['regionCuatroDetalleTres'] == "imagen") {
                    if ($request->file('file-seccion-cuatro-c') == null) {
                        // return redirect("/content/create")->withErrors(['Archivo imagen vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo imagen vacio';
                        return  $return;
                    }

                    if($request->file('file-seccion-cuatro-c') != null){

                        if (($request->file('file-seccion-cuatro-c')->getMimeType() != "image/jpeg") &&
                            ($request->file('file-seccion-cuatro-c')->getMimeType() != "image/png")  &&
                            ($request->file('file-seccion-cuatro-c')->getMimeType() != "image/jpg") 
                        ){                    
                            $return["value"] = false;
                            $return["desc"] = 'Archivo imagen solo en JPEG, PNG o JPG';
                            return  $return;                        
                        }                    
                    }                        
                } else if ($request['regionCuatroDetalleTres'] == "video") {
                    if ($request->file('file-seccion-cuatro-c-upload-manual') == null && $request['file-seccion-cuatro-c-url'] == null) {
                        // return redirect("/content/create")->withErrors(['Archivo Video o Link de youtube vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo Video o Link de youtube vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-cuatro-c-upload-manual') != null){
                        if($request->file('file-seccion-cuatro-c-upload-manual')->getMimeType() !="video/mp4"){                            
                            $return["value"] = false;
                            $return["desc"] = 'Solo se permite video/mp4 en videos subidos manual';
                            return $return;
                        }
                    }
                    if ($request['file-seccion-cuatro-c-url'] != null) {
                        $contains = Str::contains($request['file-seccion-cuatro-c-url'], ['www.youtube.com/embed/']);
                        if ($contains == false) {
                            // return redirect("/content/create")->withErrors(['Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ']);
                            $return["value"] = false;
                            $return["desc"] = 'Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/';
                            return  $return;
                        }else if (
                            Str::contains(strtolower($request['file-seccion-cuatro-c-url']), "<script>") || 
                            Str::contains(strtolower($request['file-seccion-cuatro-c-url']), "select * from") ||
                            Str::contains(strtolower($request['file-seccion-cuatro-c-url']), "drop down")) {
                            $return["value"] = false;
                            $return["desc"] = 'No se permite esa operatoria en los input de texto';
                            return  $return;
                        }
                    }
                } else if ($request['regionCuatroDetalleTres'] == "texto") {
                    if ($request['mensaje-seccion-cuatro-c'] == null) {
                        // return redirect("/content/create")->withErrors(['El texto esta vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'El texto esta vacio';
                        return  $return;
                    } else if (strlen($request['mensaje-seccion-cuatro-c']) > 255) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto supera el limite permitido (limite 255 caracteres)';
                        return  $return;
                    }else if (
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-c']), "<script>") || 
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-c']), "select * from") ||
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-c']), "drop down")) {
                        $return["value"] = false;
                        $return["desc"] = 'No se permite esa operatoria en los input de texto';
                        return  $return;
                    }
                }


                if ($request['regionCuatroDetalleCuatro'] == "imagen") {

                    if ($request->file('file-seccion-cuatro-d') == null) {
                        // return redirect("/content/create")->withErrors(['Archivo imagen vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'Archivo imagen vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-cuatro-d') != null) {
                        if (($request->file('file-seccion-cuatro-d')->getMimeType() != "image/jpeg") &&
                        ($request->file('file-seccion-cuatro-d')->getMimeType() != "image/png")  &&
                        ($request->file('file-seccion-cuatro-d')->getMimeType() != "image/jpg") 
                        ){                    
                            $return["value"] = false;
                            $return["desc"] = 'Archivo imagen solo en JPEG, PNG o JPG';
                            return  $return;                        
                        }
                    }
                } else if ($request['regionCuatroDetalleCuatro'] == "video") {
                    if ($request->file('file-seccion-cuatro-d-upload-manual') == null && $request['file-seccion-cuatro-d-url'] == null) {
                        $return["value"] = false;
                        $return["desc"] = 'Archivo Video o Link de youtube vacio';
                        return  $return;
                    }
                    if ($request->file('file-seccion-cuatro-d-upload-manual') != null){
                        if($request->file('file-seccion-cuatro-d-upload-manual')->getMimeType() !="video/mp4"){                            
                            $return["value"] = false;
                            $return["desc"] = 'Solo se permite video/mp4 en videos subidos manual';
                            return $return;
                        }
                    }
                    if ($request['file-seccion-cuatro-d-url'] != null) {
                        $contains = Str::contains($request['file-seccion-cuatro-d-url'], ['www.youtube.com/embed/']);
                        if ($contains == false) {
                            // return redirect("/content/create")->withErrors(['Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ']);
                            $return["value"] = false;
                            $return["desc"] = 'Link tiene que ser solo de youtube y bajo el siguiente formato https://www.youtube.com/embed/ ';
                            return $return;
                        }else if (
                            Str::contains(strtolower($request['file-seccion-cuatro-d-url']), "<script>") || 
                            Str::contains(strtolower($request['file-seccion-cuatro-d-url']), "select * from") ||
                            Str::contains(strtolower($request['file-seccion-cuatro-d-url']), "drop down")) {
                            $return["value"] = false;
                            $return["desc"] = 'No se permite esa operatoria en los input de texto';
                            return  $return;
                        }
                    }
                } else if ($request['regionCuatroDetalleCuatro'] == "texto") {
                    if ($request['mensaje-seccion-cuatro-d'] == null) {
                        // return redirect("/content/create")->withErrors(['El texto esta vacio']);
                        $return["value"] = false;
                        $return["desc"] = 'El texto esta vacio';
                        return $return;
                    } else if (strlen($request['mensaje-seccion-cuatro-d']) > 255) {
                        $return["value"] = false;
                        $return["desc"] = 'El texto supera el limite permitido (limite 255 caracteres)';
                        return  $return;
                    }else if (
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-d']), "<script>") || 
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-d']), "select * from") ||
                        Str::contains(strtolower($request['mensaje-seccion-cuatro-d']), "drop down")) {
                        $return["value"] = false;
                        $return["desc"] = 'No se permite esa operatoria en los input de texto';
                        return  $return;
                    }
                }
                break;
        }
        $return["value"] = true;
        $return["desc"] = 'Validaciones con exito';
        return  $return;
    }
}
