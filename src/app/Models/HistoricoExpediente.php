<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoExpediente extends Model{
    
    const CREATED_AT = 'fecha_modificacion';

    public $timestamps = false;

    public function expediente(){
        return $this->belongsTo('App\Models\Expediente', 'expediente_fk');
    }

    public function expedientes(){
        return $this->hasMany('App\Models\Expediente', 'expediente_fk');
    }

}
