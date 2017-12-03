<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model{

    public $primaryKey = 'cedula';
    public $timestamps = false;
    public $incrementing = false;

    public $filterable = ['cedula', 'nombre', 'apellidos', 'ubicacion'];

    public function expediente(){
        return $this->hasOne('App\Models\Expediente','persona_fk');
    }

    public function historico()
    {
        return $this->hasManyThrough('App\Models\HistoricoExpediente', 'App\Models\Expediente', 'persona_fk', 'expediente_fk', 'cedula', 'id');
    }

}
