<?php

namespace App\Services;

use App\Models\Referente;

class ReferentesService{
	
	public static function createAssociate($relationship, $descripcion) {
		$referente = new Referente(['descripcion' => $descripcion]);
        $referente->save();
		
        // Associate that new Referente to this Expediente
        $relationship->associate($referente);
	}

	public static function createOrAssociate($relationship, $id, $description, $hasOtro, $hasNew) {
		// Check if Referente is 'Otro'.
		if ($hasOtro)
			// Create and save new Referente
			if ($hasNew)
				self::createAssociate($relationship, $description);
			// If not, then associate Expediente with first Referente (Otro)
			else
                $relationship->associate(Referente::first());

		// If not, associate Expediente with a Referente
        else
            $relationship->associate(Referente::find($id));
	}

}
