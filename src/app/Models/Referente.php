<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referente extends Model{

    public $timestamps = false;

    public function expediente(){
        // return $this->belongsToMany('App\Models\Expediente');
    }
}
