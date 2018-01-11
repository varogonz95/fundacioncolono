<?php

namespace App\Services;

use App\Models\Historico;
use App\Models\Expediente;

class HistoricoService{
	
	public static function create($current, $new){

		/**
		 * TODO a. Associate current Expediente to Historico
		 * TODO b. Create Expediente with updated data
		 * TODO c. Attach previous Ayudas >>Pending<<
		 * TODO d. Delete current Expediente
		 * //// e. Save new expediente
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
		$expediente->referente()->associate($current->referente->id);

		//* c.
		// Attach Ayudas
		//! Parse attachments list to array of indexes and fillable attributes
		// AyudaExpedienteService::attach($expediente->ayudas(), );

		//* d.
		$current->delete();

		//* e.
		//// $expediente->save();

		//* f.
		return $expediente;
	}

}
