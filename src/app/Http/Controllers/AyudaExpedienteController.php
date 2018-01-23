<?php

namespace App\Http\Controllers;

use \App\Models\Expediente;
use \App\Services\AyudaExpedienteService;
use \App\Services\HistoricoService;

use DB;
use Illuminate\Http\Request;

class AyudaExpedienteController extends Controller {


	public function update(Request $request, $id){
		
		$status = true;
		$expediente = Expediente::with(['ayudas', 'persona', 'referente'])->find($id);

		DB::beginTransaction();
		
		try{

			//* Process attachs
			AyudaExpedienteService::attach($expediente->ayudas(), [
				'ids'      => collect($request['attachs'])->pluck('id'),
				'montos'   => collect($request['attachs'])->pluck('pivot.monto'),
				'detalles' => collect($request['attachs'])->pluck('pivot.detalle'),
			]);
	
			//* Process detachs
			AyudaExpedienteService::detach($expediente->ayudas(), $request['detachs']);
	
			//* Process updates
			AyudaExpedienteService::update($expediente->ayudas(), $request['updates']);

			//* Reload Ayudas
			$expediente->load('ayudas');

			//* Create new record into Historico if record is true
			if (filter_var($request['record'], FILTER_VALIDATE_BOOLEAN))
				$expediente = HistoricoService::create($expediente, $expediente->toArray(), ['ayudas', 'persona', 'referente']);

			// All good to commit :)
			DB::commit();
		}

		catch(\Exception $e){
			// Something went wrong :(
			$status = false;
			// Rollback transaction
			DB::rollback();
		}
		
		$expediente->meses      = $expediente->getMeses($expediente->fecha_desde['raw'], $expediente->fecha_hasta['raw']);
		$expediente->montoTotal = $expediente->getMontoTotal();

		return response()->json([
			'expediente' => $expediente,
			'status'     => $status,
			'title'      => $status ? '¡Operación exitosa!' : 'Ocurrió un fallo.',
			'type'       => $status ? 'success' : 'error',
			'msg'        => $status ? 'Se realizaron los cambios correctamente.' : 'Es posible que los datos ingresados no sean los correctos.',
		]);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id){
		return $request->all();
	}
}
