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

    public function ayudas(){
        return $this->belongsToMany('App\Models\Ayuda', 'ayuda_expedientes')->withPivot(['detalle','monto']);
    }

    public function getMontoTotal()
    {
        $monto = 0;

        foreach ($this->ayudas as $a) { $monto += $a->pivot->monto; }

        return $monto;
    }

}
