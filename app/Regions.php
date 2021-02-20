<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Multimedias;
use App\Dispositivos;

class Regions extends Model
{
    public $table = "regiones";

    public function dispositivos()
    {
        return $this->hasMany(Dispositivos::class, 'id_region', 'id');
    }

    public function multimedias()
    {
        return $this->hasMany(Multimedias::class, 'id_region', 'id');
    }

}

