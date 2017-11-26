<?php

namespace App\Services;

use App\Models\Referente;

class ReferentesService{
	
	public static function createAssociate($relationship, $descripcion){
		$referente = new Referente(['descripcion' => $descripcion]);
        $referente->save();
		
		// Associate that new Referente to this Expediente
        self::associate($relationship, $referente);
	}

	public static function associate($relationship, $referente){
		$relationship->associate($referente);
	}

}
