<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model{

    public $primaryKey = 'cedula';
    public $timestamps = false;
    public $incrementing = false;

    public function expedientes(){
        return $this->hasMany('App\Model\Expediente','persona_fk');
    }



}
