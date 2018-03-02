<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    public function expediente(){
        return $this->belongsTo('App\Models\Expediente', 'expediente_fk');
    }
}
