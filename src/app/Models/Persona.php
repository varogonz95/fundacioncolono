<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model{

    public $primaryKey = 'cedula';
    public $timestamps = false;
    public $incrementing = false;

    public function expediente(){
        return $this->hasOne('App\Models\Expediente','persona_fk');
    }

}
