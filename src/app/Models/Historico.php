<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model{
    
    const CREATED_AT = 'fecha_modificacion';

    public $table = 'historico_expedientes';

    public $timestamps = false;

    public function expedientes(){
        return $this->belongsTo('App\Models\Expediente', 'expediente_fk')->withTrashed();
    }

}
