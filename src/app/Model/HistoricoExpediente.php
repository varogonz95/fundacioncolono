<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HistoricoExpediente extends Model{

    const UPDATED_AT = 'fecha_modificacion';
    public $timestamps = false;

    public function expediente(){
        return $this->belongsTo('App\Model\HistoricoExpediente', 'expediente_fk');
    }

}
