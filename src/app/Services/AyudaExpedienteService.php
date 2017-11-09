<?php

namespace App\Services;

class AyudaExpedienteService{
	
	public static function processAttachments($ayudas, $attachs){
		for ($i=0, $count = count($attachs[0]); $i < $count; $i++)
            $ayudas->attach(
                $attachs['ids'][$i],
				[
					'detalle' => $attachs['detalles'][$i],
					'monto'   => $attachs['montos'][$i]
				]
			);
	}
	
	public static function processDetachments($ayudas, $detachs){
		for ($i=0, $count = count($detachs); $i < $count; $i++)
			$ayudas->detach($detachs[$i]['id']);
	}
			
			
	public static function processUpdates($ayudas, $updates){
		for ($i=0, $count = count($updates); $i < $count; $i++)
			$ayudas->updateExistingPivot(
				$updates[$i]['id'],
				[
					'detalle' => $updates[$i]['pivot']['detalle'],
					'monto'   => $updates[$i]['pivot']['monto']
				]
			);
	}

}
