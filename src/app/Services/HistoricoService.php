<?php

namespace App\Services;

use App\Models\Historico;
use App\Models\Expediente;

class HistoricoService{
	
	public static function create($current, $new){

		/**
		 TODO a. Associate current Expediente to Historico
		 TODO b. Create Expediente with updated data
		 TODO c. Attach previous Ayudas
		 TODO d. Delete current Expediente
		 TODO e. Save new expediente
		 TODO f. Return new Expediente
		*/

		//* a.
		$historico = new Historico;
		$historico->expedientes()->associate($current->id);
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
		$expediente->save();

		//* f.
		return $expediente;
	}

	public function find($id)
	{
		$historico = HistoricoExpediente::whereHas('expedientes.persona', function($query) use($id){
			$query->where('cedula', $id);
		})
		->get()
		->each(function($item, $index){
			$item->expedientes;
		});

		return ['actual' => Persona::with(['expediente'])->find($id), 'historico' => $historico];
	}

}
