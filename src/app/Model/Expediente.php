<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model{

    const CREATED_AT = 'fecha_creacion';

    public $timestamps = false;

    // public function setUpdatedAt($value){
    //     // Do nothing to override creation of 'updated_at' column
    //     // since we dont need it
    // }

    public function ayuda(){
        return $this->belongsTo('App\Model\TipoAyuda','tipo_ayuda_fk');
    }

    public function persona(){
        return $this->belongsTo('App\Model\Persona','persona_fk');
    }

    // public function getPrioridadAttribute($value){
    //     return "$value";
    // }

}
