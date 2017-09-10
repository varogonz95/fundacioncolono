<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model{

    const CREATED_AT = 'fecha_creacion';

    public $timestamps = false;

    public function persona(){
        return $this->belongsTo('App\Models\Persona', 'persona_fk');
    }

    public function referente(){
        return $this->belongsTo('App\Models\Referente', 'referente_fk');
    }

}
