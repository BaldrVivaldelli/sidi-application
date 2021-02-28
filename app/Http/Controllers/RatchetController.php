<?php

namespace App\Http\Controllers;

use App\Message;
use DB;
use Storage;
use Exception;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Carbon\Carbon;
use Log;

class RatchetController extends Controller implements MessageComponentInterface
{

    private $clients;
    private $channels;
    private $users;
    private $loop;

    /**
     * Store all the connected clients in php SplObjectStorage
     *
     * RatchetController constructor.
     */
    public function __construct(\React\EventLoop\LoopInterface $loop)
    {
        $this->loop = $loop;
        $this->clients = new SplObjectStorage;
        $this->channels = [];
        $this->users = [];
        DB::table('clientes')->delete();
    }
    /**
     * Store the connected client in SplObjectStorage
     * Notify all clients about total connection
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        echo "Nuevo dispositivo conectado  " . $conn->resourceId . " \n";
        // $isBlocked = DB::table('clientes')->where('clientId', $conn->resourceId )->get()->id_estado;      
        echo "mi ip es la siguiente " . $conn->remoteAddress . " \n";
        Log::info("Nuevo dispositivo conectado  " . $conn->resourceId);
        $this->clients->attach($conn);
    }

    public function sendMessageToAll($msg)
    {
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }

    public function sendMessageTo($idusers, $msg)
    {

        foreach ($idusers as $idu) {
            $idu = (int) $idu;
            if (array_key_exists($idu, $this->users)) {
                dd('mande la info');
                $this->users[$idu]->send($msg);
            }
        }
    }
    /**
     * Remove disconnected client from SplObjectStorage
     * Notify all clients about total connection
     *
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $from)
    {

        // $resource_id = $from->resourceId;
        //dd("se cerro una conexcion");
        // echo "Sacando un dispositivo conectado  " .$resource_id  . " \n";
        // $idCliente = DB::table('clientes')->where('clientId',  $resource_id)->first();
        // DB::table('clientes')->where('clientId',  $resource_id)->delete();

        // $this->clients->detach($from);      
    }
    /**
     * Receive message from connected client
     * Broadcast message to other clients
     *
     * @param ConnectionInterface $from
     * @param string $data
     */
    public function onMessage(ConnectionInterface $from, $data)
    {

        // $cliente = DB::table('clientId')->where('clientId', $from->resourceId)->first();
        // dd($cliente);
        //si esta bloqueado
        $data = json_decode($data);
        $type = $data->type;

        // if ($cliente == null) {
            $this->processMessage($from, $data);
        // } else if ($cliente->id_estado == 3 &&  $type != "changeStateDisplay") {
        //     Log::info("usuario bloqueado");
        //     $from->send(
        //         json_encode([
        //             "type" => 'userBlocked',
        //         ])
        //     );
        // } else {
        //     $this->processMessage($from, $data);
        // }
    }

    public function processMessage($from, $data)
    {        
        //esto se usa para los dispositivos
        $resource_id = $from->resourceId;
        $ip = $from->remoteAddress;
        echo 'llego informacion \r\n';
        $type = $data->type;
        echo 'el type es el siguiente ' . $type . '\r\n';
        switch ($type) {
                //aca se va a enviar la ultima foto actualizada del contenido
            case "snapshot":
                $this->channels[$from->resourceId] = $from;
                $nombreContenido = $data->content;

                // echo 'llego una solicitud de la siguiente foto de contenido ' . $data->content;
                Log::info('llego una solicitud de la siguiente foto de contenido ' . $data->content);

                $contenido = DB::table('contenidos')->where('nombre', $nombreContenido)->first();

                //aca se va a registrar el cliente en la DB
                //$isConected = DB::table('clientes')->where('ip', $ip)->count();
                //aca se va a registrar el cliente en la DB
                $nombreDispositivo =$data->nombreDispositivo;             
                echo($data->nombreDispositivo);
                $isConected = DB::table('clientes')->where('nombreDispositivo', $nombreDispositivo)->count();
                if ($isConected == 0 && $nombreDispositivo == "undefined") { 
                    $countDisplay = DB::table('clientes')->count()+1;   
                    $hashDefaultName = hash('ripemd160',"nombre-sin-asignar-". $countDisplay);                 
                    $nombreDispositivo = "nombre-sin-asignar-".$hashDefaultName;    
                    //aca existe la verdadera connecion
                    $this->users[$from->resourceId] = $from;
                    DB::table('clientes')->insert([
                        'clientId' =>  $resource_id,
                        'nombreDispositivo'=> $nombreDispositivo,
                        'id_contenido' =>   $contenido->id,
                        'id_estado' => $contenido->id_estado,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                }else{          
                    if($isConected == 0){
                        //aca existe un nombre asignado ya al dispositivo, solo se actualiza el id de coneccion
                        $this->users[$from->resourceId] = $from;
                        DB::table('clientes')->insert([
                            'clientId' =>  $resource_id,
                            'nombreDispositivo' => $nombreDispositivo,
                            'id_contenido' =>   $contenido->id,
                            'id_estado' => $contenido->id_estado,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                    }else{
                        //aca existe un nombre asignado ya al dispositivo, solo se actualiza el id de coneccion
                        $this->users[$from->resourceId] = $from;
                        DB::table('clientes')->where('nombreDispositivo', $nombreDispositivo)->update([
                            'clientId' =>  $resource_id,
                            'nombreDispositivo' => $nombreDispositivo,
                            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                            ]);
                    }          
                }


                $formato_template = $contenido->formato_template;
                switch ($formato_template) {
                    case "1":
                        $region_size = "region_uno";
                        $numeroCuadro = "uno";
                        $archivo = DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                        $archivoData = $archivo->nombre;
                        if ($archivo->tipo == "texto") {
                            $archivoData = "--CONTIENE DATO TEXTO--" . $archivo->nombre;
                        }
                        $messageUno = json_encode([
                            "type" => $type,
                            "numeroDeCuadro" => $numeroCuadro,
                            "region_size" => $region_size,
                            "nombreContenido" => $nombreContenido,
                            "nombreDispositivo"=> $nombreDispositivo,
                            "archivo_nombre" => $archivoData,
                            "numero_session" => $resource_id
                        ]);
                        Log::info('se envia archivo uno template uno' . $messageUno);
                        $from->send($messageUno);
                        break;
                    case "3":
                        $region_size = "region_tres";
                        $numeroCuadro = "uno";
                        $archivo = DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                        $archivoData = $archivo->nombre;
                        if ($archivo->tipo == "texto") {
                            $archivoData = "--CONTIENE DATO TEXTO--" . $archivo->nombre;
                        }
                        $messageUno = json_encode([
                            "type" => $type,
                            "numeroDeCuadro" => $numeroCuadro,
                            "region_size" => $region_size,
                            "nombreContenido" => $nombreContenido,
                            "nombreDispositivo"=> $nombreDispositivo,
                            "archivo_nombre" => $archivoData,
                        ]);
                        $from->send($messageUno);
                        Log::info('se envia archivo  uno template 3' . $messageUno);

                        $numeroCuadro = "dos";
                        $archivo = DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                        $archivoData = $archivo->nombre;
                        if ($archivo->tipo == "texto") {
                            $archivoData = "--CONTIENE DATO TEXTO--" . $archivo->nombre;
                        }
                        $messageDos = json_encode([
                            "type" => $type,
                            "numeroDeCuadro" => $numeroCuadro,
                            "region_size" => $region_size,
                            "nombreContenido" => $nombreContenido,
                            "nombreDispositivo"=> $nombreDispositivo,
                            "archivo_nombre" => $archivoData,
                        ]);
                        Log::info('se envia archivo  dos template 3' . $messageDos);
                        $from->send($messageDos);
                        $numeroCuadro = "tres";
                        $archivo = DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                        $archivoData = $archivo->nombre;
                        if ($archivo->tipo == "texto") {
                            $archivoData = "--CONTIENE DATO TEXTO--" . $archivo->nombre;
                        }
                        $messageTres =  json_encode([
                            "type" => $type,
                            "numeroDeCuadro" => $numeroCuadro,
                            "region_size" => $region_size,
                            "nombreContenido" => $nombreContenido,
                            "nombreDispositivo"=> $nombreDispositivo,
                            "archivo_nombre" => $archivoData,
                        ]);
                        Log::info('se envia archivo  tres template 3' . $messageTres);
                        $from->send($messageTres);
                        break;
                    case "4":
                        $numeroCuadro = "uno";
                        $archivo = DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                        $region_size = "region_cuatro";
                        // $numeroCuadro = "cuatro";
                        $archivoData = $archivo->nombre;
                        if ($archivo->tipo == "texto") {
                            $archivoData = "--CONTIENE DATO TEXTO--" . $archivo->nombre;
                        }
                        $mesageUno = json_encode([
                            "type" => $type,
                            "numeroDeCuadro" => $numeroCuadro,
                            "region_size" => $region_size,
                            "nombreContenido" => $nombreContenido,
                            "nombreDispositivo"=> $nombreDispositivo,
                            "archivo_nombre" => $archivoData,
                        ]);
                        Log::info('se envia archivo  uno template 4' . $mesageUno);
                        $from->send($mesageUno);
                        $numeroCuadro = "dos";
                        $archivo = DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                        $archivoData = $archivo->nombre;
                        if ($archivo->tipo == "texto") {
                            $archivoData = "--CONTIENE DATO TEXTO--" . $archivo->nombre;
                        }
                        $messageDos = json_encode([
                            "type" => $type,
                            "numeroDeCuadro" => $numeroCuadro,
                            "nombreContenido" => $nombreContenido,
                            "nombreDispositivo"=> $nombreDispositivo,
                            "region_size" => $region_size,
                            "archivo_nombre" => $archivoData,
                        ]);
                        Log::info('se envia archivo  dos template 4' . $messageDos);
                        $from->send($messageDos);
                        $archivo = DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                        $archivoData = $archivo->nombre;
                        if ($archivo->tipo == "texto") {
                            $archivoData = "--CONTIENE DATO TEXTO--" . $archivo->nombre;
                        }
                        $numeroCuadro = "tres";
                        $messageTres  = json_encode([
                            "type" => $type,
                            "numeroDeCuadro" => $numeroCuadro,
                            "nombreContenido" => $nombreContenido,
                            "nombreDispositivo"=> $nombreDispositivo,
                            "region_size" => $region_size,
                            "archivo_nombre" => $archivoData,
                        ]);
                        Log::info('se envia archivo tres template 4' . $messageTres);
                        $from->send($messageTres);
                        $archivo = DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
                        $archivoData = $archivo->nombre;
                        if ($archivo->tipo == "texto") {
                            $archivoData = "--CONTIENE DATO TEXTO--" . $archivo->nombre;
                        }
                        $numeroCuadro = "cuatro";
                        $messageCuatro = json_encode([
                            "type" => $type,
                            "numeroDeCuadro" => $numeroCuadro,
                            "nombreContenido" => $nombreContenido,
                            "nombreDispositivo"=> $nombreDispositivo,
                            "region_size" => $region_size,
                            "archivo_nombre" => $archivoData,
                        ]);
                        Log::info('se envia archivo tres template 4' . $messageCuatro);
                        $from->send($messageCuatro);
                        break;
                }
                //break del snapshot                
                break;
            case "incremental":

                $contentName =  $data->region_id;
                $contenido =  DB::table('contenidos')->where('nombre', $contentName)->first();
                $destinos =  DB::table('clientes')->where('id_contenido', $contenido->id)->get();
                $formato_template = $contenido->formato_template;
                foreach ($destinos as $key => $destino) {                    
                    # code...
                    $idResource = $destino->clientId;
                    $sendData = $this->users[$idResource];                    
                    if ($contenido->id_estado == 3) {
                        $message = json_encode([
                            "type" => "userBlocked",
                        ]);
                        $sendData->send($message);
                    } else {
                        switch ($formato_template) {
                            case "1":
                                $region_size = "region_uno";
                                $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                                $archivoData = $archivoUno->nombre;
                                if ($archivoUno->tipo == "texto") {
                                    $archivoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                                }
                                $messageUno = json_encode([
                                    "type" => $type,
                                    "region_size" => $region_size,
                                    // "numeroDeCuadro" => $contenido->formato_template,
                                    "numeroDeCuadro" => "uno",
                                    "nombreContenido" => $contenido->nombre,
                                    "archivo_nombre" => $archivoData
                                ]);
                                Log::info('se envia actualizacion de archivo archivo uno  template 1' . $messageUno);
                                if($destino->id_estado == 4){
                                    $sendData->send($messageUno);
                                }
                                // foreach ($this->users as $client) {                                
                                //     $client->send($messageUno);
                                // }
                                break;
                            case "3":

                                $region_size = "region_tres";
                                $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                                $archivoUnoData = $archivoUno->nombre;
                                $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                                $archivoDosData = $archivoDos->nombre;
                                $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                                $archivoTresData = $archivoTres->nombre;
                                if ($archivoUno->tipo == "texto") {
                                    $archivoUnoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                                }
                                if ($archivoDos->tipo == "texto") {
                                    $archivoDosData = "--CONTIENE DATO TEXTO--" . $archivoDos->nombre;
                                }
                                if ($archivoTres->tipo == "texto") {
                                    $archivoTresData = "--CONTIENE DATO TEXTO--" . $archivoTres->nombre;
                                }
                                $messageUno = json_encode([
                                    "type" => $type,
                                    "region_size" => $region_size,
                                    "numeroDeCuadro" => "uno",
                                    "nombreContenido" => $contenido->nombre,
                                    "archivo_nombre" => $archivoUnoData
                                ]);
                                Log::info('se envia actualizacion de archivo archivo uno  template 3' . $messageUno);
                                $messageDos = json_encode([
                                    "type" => $type,
                                    "region_size" => $region_size,
                                    "numeroDeCuadro" => "dos",

                                    "nombreContenido" => $contenido->nombre,
                                    "archivo_nombre" => $archivoDosData
                                ]);
                                Log::info('se envia actualizacion de archivo archivo dos  template 3' . $messageDos);
                                $messageTres = json_encode([
                                    "type" => $type,

                                    "region_size" => $region_size,
                                    "numeroDeCuadro" => "tres",
                                    "nombreContenido" => $contenido->nombre,
                                    "archivo_nombre" => $archivoTresData
                                ]);
                                Log::info('se envia actualizacion de archivo archivo dos  template 3' . $messageTres);

                                if($destino->id_estado == 4){
                                    $sendData->send($messageUno);                                
                                    $sendData->send($messageDos);
                                    $sendData->send($messageTres);
                                }
                                    
                                break;
                            case "4":
                                $region_size = "region_cuatro";
                                $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                                $archivoUnoData = $archivoUno->nombre;
                                $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                                $archivoDosData = $archivoDos->nombre;
                                $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                                $archivoTresData = $archivoTres->nombre;
                                $archivoCuatro =  DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
                                $archivoCuatroData = $archivoCuatro->nombre;

                                if ($archivoUno->tipo == "texto") {
                                    $archivoUnoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                                }
                                if ($archivoDos->tipo == "texto") {
                                    $archivoDosData = "--CONTIENE DATO TEXTO--" . $archivoDos->nombre;
                                }
                                if ($archivoTres->tipo == "texto") {
                                    $archivoTresData = "--CONTIENE DATO TEXTO--" . $archivoTres->nombre;
                                }
                                if ($archivoCuatro->tipo == "texto") {
                                    $archivoCuatroData = "--CONTIENE DATO TEXTO--" . $archivoCuatro->nombre;
                                }

                                $messageUno = json_encode([
                                    "type" => $type,
                                    // "numeroDeCuadro" => $contenido->formato_template,
                                    "region_size" => $region_size,
                                    "numeroDeCuadro" => "uno",
                                    "nombreContenido" => $contenido->nombre,
                                    "archivo_nombre" => $archivoUnoData
                                ]);
                                $messageDos = json_encode([
                                    "type" => $type,
                                    // "numeroDeCuadro" => $contenido->formato_template,
                                    "region_size" => $region_size,
                                    "numeroDeCuadro" => "dos",
                                    "nombreContenido" => $contenido->nombre,
                                    "archivo_nombre" => $archivoDosData
                                ]);
                                $messageTres = json_encode([
                                    "type" => $type,
                                    // "numeroDeCuadro" => $contenido->formato_template,
                                    "region_size" => $region_size,
                                    "numeroDeCuadro" => "tres",
                                    "nombreContenido" => $contenido->nombre,
                                    "archivo_nombre" => $archivoTresData
                                ]);
                                $messageCuatro = json_encode([
                                    "type" => $type,
                                    // "numeroDeCuadro" => $contenido->formato_template,
                                    "region_size" => $region_size,
                                    "numeroDeCuadro" => "cuatro",
                                    "nombreContenido" => $contenido->nombre,
                                    "archivo_nombre" => $archivoCuatroData
                                ]);
                                if($destino->id_estado == 4){                                    
                                    Log::info('se envia actualizacion de archivo archivo uno  template 4' . $messageUno);
                                    $sendData->send($messageUno);
                                    Log::info('se envia actualizacion de archivo archivo dos  template 4' . $messageDos);
                                    $sendData->send($messageDos);
                                    Log::info('se envia actualizacion de archivo archivo tres  template 4' . $messageTres);
                                    $sendData->send($messageTres);
                                    Log::info('se envia actualizacion de archivo archivo cuatro  template 4' . $messageCuatro);
                                    $sendData->send($messageCuatro);
                                }
                                break;
                        }
                    }
                }
                break;
            case "updateDisplay":

                $contenido =  DB::table('contenidos')->where('nombre',  $data->nuevoContenido)->first();
                $formato_template = $contenido->formato_template;
                $destino =  DB::table('clientes')->where('nombreDispositivo', $data->cliente)->first();                
                DB::table('clientes')->where('nombreDispositivo', $data->cliente)->update(['id_contenido' =>  $contenido->id]);

                $idResource = $destino->clientId;


                $sendData = $this->users[$idResource];

                

                switch ($formato_template) {
                    case "1":

                        $region_size = "region_uno";
                        $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                        $archivoUnoData = $archivoUno->nombre;
                        if ($archivoUno->tipo == "texto") {
                            $archivoUnoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                        }
                        $messageUno = json_encode([
                            "type" => $type,
                            // "numeroDeCuadro" => $contenido->formato_template,
                            "region_size" => $region_size,
                            "numeroDeCuadro" => "uno",
                            "nombreContenido" => $contenido->nombre,
                            "archivo_nombre" => $archivoUnoData
                        ]);
                        Log::info('se envia actualizacion de dispositivo para template 1' . $messageUno);

                        //en caso de que este inhabilitado no va a enviar nada
                        if($destino->id_estado == 4){
                            $sendData->send($messageUno);
                        }
                        break;
                    case "3":
                        $region_size = "region_tres";
                        // $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                        // $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                        // $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();


                        $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                        $archivoUnoData = $archivoUno->nombre;
                        $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                        $archivoDosData = $archivoDos->nombre;
                        $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                        $archivoTresData = $archivoTres->nombre;

                        if ($archivoUno->tipo == "texto") {
                            $archivoUnoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                        }
                        if ($archivoDos->tipo == "texto") {
                            $archivoDosData = "--CONTIENE DATO TEXTO--" . $archivoDos->nombre;
                        }
                        if ($archivoTres->tipo == "texto") {
                            $archivoTresData = "--CONTIENE DATO TEXTO--" . $archivoTres->nombre;
                        }



                        $messageUno = json_encode([
                            "type" => $type,
                            // "numeroDeCuadro" => $contenido->formato_template,
                            "region_size" => $region_size,
                            "numeroDeCuadro" => "uno",
                            "nombreContenido" => $contenido->nombre,
                            "archivo_nombre" => $archivoUnoData
                        ]);
                        $messageDos = json_encode([
                            "type" => $type,
                            // "numeroDeCuadro" => $contenido->formato_template,
                            "region_size" => $region_size,
                            "numeroDeCuadro" => "dos",
                            "nombreContenido" => $contenido->nombre,
                            "archivo_nombre" => $archivoDosData
                        ]);
                        $messageTres = json_encode([
                            "type" => $type,
                            // "numeroDeCuadro" => $contenido->formato_template,
                            "region_size" => $region_size,
                            "numeroDeCuadro" => "tres",
                            "nombreContenido" => $contenido->nombre,
                            "archivo_nombre" => $archivoTresData
                        ]);

                        //en caso de que este inhabilitado no va a enviar nada
                        if($destino->id_estado == 4){
                            Log::info('se envia actualizacion de dispositivo para template 3' . $messageUno);
                            $sendData->send($messageUno);
                            Log::info('se envia actualizacion de dispositivo para template 3' . $messageDos);
                            $sendData->send($messageDos);
                            Log::info('se envia actualizacion de dispositivo para template 3' . $messageTres);
                            $sendData->send($messageTres);
                        }
                        break;
                    case "4":
                        // $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                        // $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                        // $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                        // $archivoCuatro =  DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
                        $region_size = "region_cuatro";
                        $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                        $archivoUnoData = $archivoUno->nombre;
                        $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                        $archivoDosData = $archivoDos->nombre;
                        $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                        $archivoTresData = $archivoTres->nombre;
                        $archivoCuatro =  DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
                        $archivoCuatroData = $archivoCuatro->nombre;

                        if ($archivoUno->tipo == "texto") {
                            $archivoUnoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                        }
                        if ($archivoDos->tipo == "texto") {
                            $archivoDosData = "--CONTIENE DATO TEXTO--" . $archivoDos->nombre;
                        }
                        if ($archivoTres->tipo == "texto") {
                            $archivoTresData = "--CONTIENE DATO TEXTO--" . $archivoTres->nombre;
                        }
                        if ($archivoCuatro->tipo == "texto") {
                            $archivoCuatroData = "--CONTIENE DATO TEXTO--" . $archivoCuatro->nombre;
                        }

                        $messageUno = json_encode([
                            "type" => $type,
                            "region_size" => $region_size,
                            "numeroDeCuadro" => "uno",
                            // "numeroDeCuadro" => $contenido->formato_template,
                            "nombreContenido" => $contenido->nombre,
                            "archivo_nombre" => $archivoUnoData
                        ]);
                        $messageDos = json_encode([
                            "type" => $type,
                            // "numeroDeCuadro" => $contenido->formato_template,
                            "region_size" => $region_size,
                            "numeroDeCuadro" => "dos",
                            "nombreContenido" => $contenido->nombre,
                            "archivo_nombre" => $archivoDosData
                        ]);
                        $messageTres = json_encode([
                            "type" => $type,
                            // "numeroDeCuadro" => $contenido->formato_template,
                            "region_size" => $region_size,
                            "numeroDeCuadro" => "tres",
                            "nombreContenido" => $contenido->nombre,
                            "archivo_nombre" => $archivoTresData
                        ]);
                        $messageCuatro = json_encode([
                            "type" => $type,
                            // "numeroDeCuadro" => $contenido->formato_template,
                            "region_size" => $region_size,
                            "numeroDeCuadro" => "cuatro",
                            "nombreContenido" => $contenido->nombre,
                            "archivo_nombre" => $archivoCuatroData
                        ]);
                        if($destino->id_estado == 4){
                            Log::info('se envia actualizacion de dispositivo para template 4' . $messageUno);
                            $sendData->send($messageUno);
                            Log::info('se envia actualizacion de dispositivo para template 4' . $messageDos);
                            $sendData->send($messageDos);
                            Log::info('se envia actualizacion de dispositivo para template 4' . $messageTres);
                            $sendData->send($messageTres);
                            Log::info('se envia actualizacion de dispositivo para template 4' . $messageCuatro);
                            $sendData->send($messageCuatro);
                        }
                        break;
                }


                break;
                // $this->users[0]->send($message);
                //$this->clients[0]->send($message);
                // $userTarget = $this->users[$id];                
                // $this->sendMessageTo($userTarget,$message );
                //  );                                           

            case "changeStateDisplay":

                $estado = DB::table('estados')->where('estado', $data->nuevoContenido)->first();
                DB::table('clientes')->where('nombreDispositivo', $data->cliente)->update(['id_estado' =>  $estado->id]);
                // 4 = bloqueado
                $cliente = DB::table('clientes')->where('nombreDispositivo', $data->cliente)->first();
                if ($data->nuevoContenido == 'inhabilitado') {

                    // dd($cliente);
                    // foreach ($this->users as $user) {                    
                    //$this->users[$id]->sendMessageToAll(                
                    Log::info('se inhabilita de dispositivo');
                    $message = json_encode([
                        "type" => "userBlocked",
                    ]);
                    $destino =  DB::table('clientes')->where('nombreDispositivo', $data->cliente)->first();
                    DB::table('clientes')->where('nombreDispositivo', $data->cliente)->update(['id_estado' =>  3]);

                    $idResource = $destino->clientId;
                    $sendData = $this->users[$idResource];
                    $sendData->send($message);
                } else {

                    Log::info('se habilita de dispositivo');
                    //4 habilitado
                    $contenido =  DB::table('contenidos')->where('id',  $cliente->id_contenido)->first();

                    $formato_template = $contenido->formato_template;
                    $destino = $cliente;
                    $idResource = $destino->clientId;
                    $sendData = $this->users[$idResource];

                    switch ($formato_template) {
                        case "1":
                            $region_size = "region_uno";
                            $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                            $archivoUnoData = $archivoUno->nombre;
                            if ($archivoUno->tipo == "texto") {
                                $archivoUnoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                            }
                            $messageUno = json_encode([
                                "type" => 'updateDisplay',
                                "region_size" => $region_size,
                                "numeroDeCuadro" => "uno",
                                "nombreContenido" => $contenido->nombre,
                                "archivo_nombre" => $archivoUnoData
                            ]);
                            $sendData->send($messageUno);
                            break;
                        case "3":

                            // $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                            // $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                            // $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();

                            $region_size = "region_tres";

                            $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                            $archivoUnoData = $archivoUno->nombre;
                            $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                            $archivoDosData = $archivoDos->nombre;
                            $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                            $archivoTresData = $archivoTres->nombre;

                            if ($archivoUno->tipo == "texto") {
                                $archivoUnoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                            }
                            if ($archivoDos->tipo == "texto") {
                                $archivoDosData = "--CONTIENE DATO TEXTO--" . $archivoDos->nombre;
                            }
                            if ($archivoTres->tipo == "texto") {
                                $archivoTresData = "--CONTIENE DATO TEXTO--" . $archivoTres->nombre;
                            }



                            $messageUno = json_encode([
                                "type" => 'updateDisplay',
                                "region_size" => $region_size,
                                "numeroDeCuadro" => "uno",
                                "nombreContenido" => $contenido->nombre,
                                "archivo_nombre" => $archivoUnoData
                            ]);
                            $messageDos = json_encode([
                                "type" => 'updateDisplay',
                                "region_size" => $region_size,
                                "numeroDeCuadro" => "dos",
                                "nombreContenido" => $contenido->nombre,
                                "archivo_nombre" => $archivoDosData
                            ]);
                            $messageTres = json_encode([
                                "type" => 'updateDisplay',
                                "region_size" => $region_size,
                                "numeroDeCuadro" => "tres",
                                "nombreContenido" => $contenido->nombre,
                                "archivo_nombre" => $archivoTresData
                            ]);
                            $sendData->send($messageUno);
                            $sendData->send($messageDos);
                            $sendData->send($messageTres);

                            break;
                        case "4":
                            // $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                            // $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                            // $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                            // $archivoCuatro =  DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
                            $region_size = "region_cuatro";

                            $archivoUno =  DB::table('archivos')->where('id', $contenido->id_archivo_uno)->first();
                            $archivoUnoData = $archivoUno->nombre;
                            $archivoDos =  DB::table('archivos')->where('id', $contenido->id_archivo_dos)->first();
                            $archivoDosData = $archivoDos->nombre;
                            $archivoTres =  DB::table('archivos')->where('id', $contenido->id_archivo_tres)->first();
                            $archivoTresData = $archivoTres->nombre;
                            $archivoCuatro =  DB::table('archivos')->where('id', $contenido->id_archivo_cuatro)->first();
                            $archivoCuatroData = $archivoCuatro->nombre;

                            if ($archivoUno->tipo == "texto") {
                                $archivoUnoData = "--CONTIENE DATO TEXTO--" . $archivoUno->nombre;
                            }
                            if ($archivoDos->tipo == "texto") {
                                $archivoDosData = "--CONTIENE DATO TEXTO--" . $archivoDos->nombre;
                            }
                            if ($archivoTres->tipo == "texto") {
                                $archivoTresData = "--CONTIENE DATO TEXTO--" . $archivoTres->nombre;
                            }
                            if ($archivoCuatro->tipo == "texto") {
                                $archivoCuatroData = "--CONTIENE DATO TEXTO--" . $archivoCuatro->nombre;
                            }

                            $messageUno = json_encode([
                                "type" => 'updateDisplay',
                                "region_size" => $region_size,
                                "numeroDeCuadro" => "uno",
                                "nombreContenido" => $contenido->nombre,
                                "archivo_nombre" => $archivoUnoData
                            ]);
                            $messageDos = json_encode([
                                "type" => 'updateDisplay',
                                "region_size" => $region_size,
                                "numeroDeCuadro" => "dos",
                                "nombreContenido" => $contenido->nombre,
                                "archivo_nombre" => $archivoDosData
                            ]);
                            $messageTres = json_encode([
                                "type" => 'updateDisplay',
                                "region_size" => $region_size,
                                "numeroDeCuadro" => "tres",
                                "nombreContenido" => $contenido->nombre,
                                "archivo_nombre" => $archivoTresData
                            ]);
                            $messageCuatro = json_encode([
                                "type" => 'updateDisplay',
                                "region_size" => $region_size,
                                "numeroDeCuadro" => "cuatro",
                                "nombreContenido" => $contenido->nombre,
                                "archivo_nombre" => $archivoCuatroData
                            ]);
                            $sendData->send($messageUno);
                            $sendData->send($messageDos);
                            $sendData->send($messageTres);
                            $sendData->send($messageCuatro);
                            break;
                    }
                }
                break;
            case "deleteDisplay":
                //$this->users[$id]->sendMessageToAll(                            


                $message = json_encode([
                    "type" => 'deleteDisplay'
                ]);
                $destino =  DB::table('clientes')->where('nombreDispositivo', $data->cliente)->first();
                DB::table('clientes')->where('nombreDispositivo', $data->cliente)->delete();
                // DB::table('clientes')->where('clientId', $data->cliente)->update(['id_contenido' =>  $data->nuevoContenido]);                
                
                $idResource = $destino->clientId;
                $sendData = $this->users[$idResource];
                $sendData->send($message);
                break;
            case "deleteContent":
                Log::info('se borra contenido');
                $contentData = DB::table('contenidos')->where('nombre', $data->nuevoContenido)->first();

                $message = json_encode([
                    "type" => 'deleteDisplay'
                ]);
                $destinos = DB::table('clientes')->where('id_contenido', $contentData->id)->get();                                

                foreach ($destinos as $key => $destino) {

                    $idResource = $destino->clientId;
                    $sendData = $this->users[$idResource];
                    $sendData->send($message);
                }
                //agregar if para los demas casos
                // $archivoUno = DB::table('archivos')->where('id', $contentData->id_archivo_uno)->first();

                DB::table('clientes')->where('id_contenido', $contentData->id)->delete();

                // DB::table('contenidos')->where('nombre', $data->nuevoContenido)->delete();

                //borro los archivos en la nube
                // Storage::disk('s3')->delete($archivoUno->ubicacion);
                //borro los archivos asociados
                if ($contentData->id_archivo_uno != null) {
                    DB::table('archivos')->where('id', $contentData->id_archivo_uno)->delete();
                    $archivoUno = DB::table('archivos')->where('id', "=", $contentData->id_archivo_uno)->first();
                    //borro los archivos en la nube
                    Storage::disk('s3')->delete($archivoUno->ubicacion);
                }
                if ($contentData->id_archivo_dos != null) {
                    DB::table('archivos')->where('id', $contentData->id_archivo_dos)->delete();
                    $archivoDos = DB::table('archivos')->where('id', "=", $contentData->id_archivo_dos)->first();
                    Storage::disk('s3')->delete($archivoDos);
                }
                if ($contentData->id_archivo_tres != null) {
                    DB::table('archivos')->where('id', "=", $contentData->id_archivo_tres)->delete();
                    $archivoTres = DB::table('archivos')->where('id', $contentData->id_archivo_tres)->first();
                    Storage::disk('s3')->delete($archivoTres);
                }
                if ($contentData->id_archivo_cuatro != null) {
                    DB::table('archivos')->where('id', "=", $contentData->id_archivo_cuatro)->delete();
                    $archivoCuatro = DB::table('archivos')->where('id', $contentData->id_archivo_cuatro)->first();
                    Storage::disk('s3')->delete($archivoCuatro);
                }
                
                DB::table('contenidos')->where('nombre', "=", $data->nuevoContenido)->delete();

                break;
            case "logout":                                
                DB::table('clientes')->where('clientId', $from->resourceId)->delete();
                $this->clients->attach($from);
                break;
            case "notifyChangeDisplayName":
                $cliente = DB::table('clientes')->where('nombreDispositivo', $data->displayNewName)->first();                
                $destino = $cliente;
                $idResource = $destino->clientId;
                $sendData = $this->users[$idResource];

                $message = json_encode([
                    "type" => 'notifyChangeDisplayName',
                    "value"=> $destino->nombreDispositivo
                ]);                
                $sendData->send($message);
                break;                
        }
    }

    /**
     * Throw error and close connection
     *
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
    }
}
