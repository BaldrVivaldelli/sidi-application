<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use DB;
use Storage;

/**
* @OA\Info(title="API PUBLICA", version="1.0")
*
* @OA\Server(url="http://swagger.local")
*/
class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('public_site');
    }

 /**
    * @OA\Get(
    *     path="/api/getAllData",
    *     summary="Mostrar lista de contenido",
    *     @OA\Response(
    *         response=200,
    *         description="Mostrar todos el contenido."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function getAllData()
    {
        $aux = DB::table('contenidos')->get();
        $contenidos = array();
        foreach ($aux as $data) {
            if($data->id_estado == 4){
                array_push($contenidos, $data->nombre);
            }
        }
        return [
            'contenidos' => $contenidos
        ];
    }



    public function getDisableImage(){ 
        $data = 'imagen de usuario bloqueado';

        return [
            'contenidos' => $data
        ];
    }
    

     /**
    * @OA\Get(
    *     path="/api/getById/id",
    *     summary="obtiene el contenido",
    *     @OA\Response(
    *         response=200,
    *         description="Devuelve el contenido."
    *     ),
    *     @OA\Response(
    *         response="default",
    *         description="Ha ocurrido un error."
    *     )
    * )
    */
    public function getById($hashname){

        $fileObject   = DB::table('archivos')->where('nombre', $hashname)->first();
        
        
        $content = Storage::disk('s3')->get($fileObject->ubicacion);        
        return response($content, 200)->header('Content-Type', $fileObject->tipo);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
