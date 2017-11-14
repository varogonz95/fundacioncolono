<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspector extends Model{

    public $timestamps = false;
    public $table = 'inspectores';

    public function persona(){
        return $this->belongsTo('App\Models\Persona', 'persona_fk');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\Usuario', 'usuario_fk');
    }

}
