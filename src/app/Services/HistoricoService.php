<?php

namespace App\Services;

use App\Models\Historico;
use App\Models\Expediente;
use App\Services\ReferentesService;

class HistoricoService {
	
	public static function create($current, $new) {

		/**
		 * TODO a. Associate current Expediente to Historico
		 * TODO b. Create Expediente with updated data
		 * TODO c. Attach previous Ayudas
		 * TODO d. Delete current Expediente
		 * TODO e. Save new expediente
		 * TODO f. Return new Expediente
		*/

		//* a.
		$historico = new Historico;
		$historico->expediente()->associate($current->id);
        $historico->save();
		
		//* b.
		// Create instance
		$expediente = new Expediente;
		// Fill attributes with new data
		$expediente->fill($new);
		// Associate to Persona
		$expediente->persona()->associate($current->persona->cedula);
		// Associate Referente
		$expediente->referente()->associate($new['referente']['id']);
        
        //* e.
        $expediente->save();

		//* c.
		AyudaExpedienteService::attach($expediente->ayudas(), $current->ayudas, true);

		//* d.
        $current->delete();
        
		//* f.
		return $expediente;
	}

}
