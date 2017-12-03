<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expediente extends Model{

    use SoftDeletes;

    const CREATED_AT = 'fecha_creacion';
    const DELETED_AT = 'fecha_eliminacion';
    
    protected $dates = ['fecha_eliminacion'];
    protected $fillable = ['descripcion', 'estado', 'prioridad', 'referente_otro'];

    public $timestamps = false;

    public function persona(){
        return $this->belongsTo('App\Models\Persona', 'persona_fk');
    }

    public function referente(){
        return $this->belongsTo('App\Models\Referente', 'referente_fk');
    }

    public function ayudas(){
        return $this->belongsToMany('App\Models\Ayuda', 'ayuda_expedientes', 'expediente_fk', 'ayuda_fk')->withPivot(['detalle','monto']);
    }

    public function getFechaCreacionAttribute($value){
        return (new \DateTime($value))->format('d-m-Y');
    }

    public function getMontoTotal(){
        $monto = 0;

        foreach ($this->ayudas as $a) { $monto += $a->pivot->monto; }

        return $monto;
    }

}
