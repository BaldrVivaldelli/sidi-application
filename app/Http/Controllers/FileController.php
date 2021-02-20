<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Storage;

class FileController extends Controller
{
    

    function getFileById($hashname){
                
        $idName   = DB::table('archivos')->where('nombre', $hashname)->first();
        $idFile   = DB::table('multimedias')->where('id_archivo', $idName->id)->first();
        $idRegion = DB::table('regiones')->where('id', $idFile->id_region)->first();
    
        $mimetype = $idName->formato;
        if ("image/jpeg" == $mimetype) {
            $ext = ".jpeg";
        }
        if ("video/x-matroska" == $mimetype) {
            $ext =".mkv";
        }
        if ("video/mp4" == $mimetype) {
            $ext = ".mp4";
        }
        if("image/webp" == $mimetype){
            $ext = ".webp";
        }
        if ("image/gif" == $mimetype) {
            $ext = ".gif";
        }
        if (strpos($idName->nombre, $ext) == true) {
            $filepath = $idRegion->nombre . "//" .  $idRegion->region_size . "//" .  $idFile->cuadro . "//" . $idName->nombre;                         
        }else{
            $filepath = $idRegion->nombre . "//" .  $idRegion->region_size . "//" .  $idFile->cuadro . "//" . $idName->nombre . $ext;                        
        }
        
        $content =  Storage::disk('public')->get($filepath);
                
        return response($content, 200)->header('Content-Type', $mimetype);
        
    }
}

