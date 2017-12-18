<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Persona;
use App\Models\Referente;

use App\Services\AyudaExpedienteService;
use App\Services\ReferentesService;
use App\Services\HistoricoService;

use Illuminate\Http\Request;
use Filter;
use DB;

class ExpedientesController extends Controller{

	const MAX_RECORDS = 16;

	public function all(Request $request){

		$orderBy = [
			'order' => $request['order'],
			'by'    => $request['by'],
		];

		$filter = [
			'comparator' => $request['comparator'],
			'property'   => $request['property'],
			'value'      => $request['value'],
		];

		$filtered = [];
		
		if ($this->hasEmptyValues($filter))
		$filtered = Filter::with(Expediente::class, ['persona', 'referente'])
					->where('persona', $orderBy['by'], 'like', "{$request['search']}%")
					->orderBy($request['relationship'], $orderBy['by'], $orderBy['order'])
					->get();

		else
		$filtered = Filter::with(Expediente::class, ['persona', 'referente'])
					->where($request['relationship'], $filter['property'], $filter['comparator'], $filter['value'])
					->where('persona', $orderBy['by'], 'like', "{$request['search']}%")
					->orderBy('persona', $orderBy['by'], $orderBy['order'])
					->get();

		// Iterate over items
		$filtered->each(function($item, $index){
			$item->meses = $item->getMeses(
				$item->fecha_desde['formatted'],
				$item->fecha_hasta['formatted']
			);
			$item->montoTotal = $item->getMontoTotal();
			$item->archivado  = $item->trashed();
		});
		
		// Paginate , passing the filtered items and the max records per page
		$pagination = Filter::paginate($filtered, self::MAX_RECORDS);
		$items = $pagination->items();

		return response()->json([
			'expedientes' => $items,
			'total'       => $pagination->total(),
			// 'pages'       => ceil( Expediente::count()/self::MAX_RECORDS ),
		]);
	}

	public function index(){
		return view(
			'templates.expediente.index', 
			[
				// Pass first Referente id into template
				// to prevent 'hard coding'
				'first_referente' => Referente::first()->id,
				'max_records'     => self::MAX_RECORDS
			]
		);
	}

	public function create(){
		return view('templates.expediente.create_all');
	}

	public function store(Request $request){

		$persona = new Persona;
		// Assign Persona property values
		$persona->cedula        =   $request['cedula'];
		$persona->nombre        =   $request['nombre'];
		$persona->apellidos     =   $request['apellidos'];
		$persona->telefonos     =   $request['telefonos'];
		$persona->ubicacion     =   "{$request['provincia']}/{$request['canton']}/{$request['distrito']}";
		$persona->direccion     =   $request['direccion'];
		$persona->contactos     =   $request['contactos'];

		$expediente = new Expediente;
		// Assign Expediente property values
		$expediente->referente_otro = $request['referente_otro'];
		$expediente->fecha_desde    = $request['fecha_desde'];
		$expediente->fecha_hasta    = $request['fecha_hasta'];
		$expediente->descripcion    = $request['descripcion'];
		$expediente->pago_inicio    = $request['pago_inicio'];
		$expediente->pago_final     = $request['pago_final'];
		$expediente->prioridad      = $request['prioridad'];
		$expediente->estado         = $request['estado'];

		$status = true;
		DB::beginTransaction();

		try{
			$persona->save();

			// Check if Referente is 'Otro'.
			if (filter_var($request['hasReferenteOtro'], FILTER_VALIDATE_BOOLEAN))
				
				// Create and save new Referente
				if (filter_var($request['newReferente'], FILTER_VALIDATE_BOOLEAN))
					ReferentesService::createAssociate($expediente->referente(), $request['referente_otro']);
				
				// If not, then associate Expediente with first Referente (Otro)
				else
					ReferentesService::associate($expediente->referente(), Referente::first());
			
			// If not, associate Expediente with a Referente
			else
				ReferentesService::associate(
					$expediente->referente(),
					is_null($request['referente'])?
						Referente::first() :
						Referente::find($request['referente'])
					);

			// Save Persona and Expediente altogether
			$persona->expediente()->save($expediente);

			AyudaExpedienteService::attach($expediente->ayudas(), ['ids' => $request['ayuda'], 'detalles' => $request['ayuda_detalle'], 'montos' => $request['ayuda_monto']]);

			DB::commit();
			
		}

		catch(\Exception $e){
			$status = false;
			DB::rollback();
		}

		// Redirect and flash data with operation status
		return redirect('expedientes')
			->with('status', [
				'type' => $status? 'success' : 'error',
				'title' => $status? '¡Operación exitosa!' : 'Ocurrió un error.',
				'msg' => $status? 'Se ha creado el expediente correctamente.' : 
								  'Es posible que los datos ingresados sean incorrectos.<br>'.
								  'Si el problema persiste, por favor contacte a soporte.',
			]);
		// return $request->all();
	}

	public function show($id){
		$expediente = Expediente::with(['persona', 'ayudas'])->find($id);
		$expediente->montoTotal = $expediente->getMontoTotal();
		return view('templates.expediente.show2', ['expediente' => $expediente]);
		// return response()->json(Expediente::with(['persona', 'ayudas'])->find($id));
	}

	public function edit($id){
		//
	}

	public function update(Request $request, $id){
		
		$status = true;
		$current = Expediente::find($id);

		DB::beginTransaction();

		try{
			
			if (!filter_var($request['record'], FILTER_VALIDATE_BOOLEAN)) {
				
				$current->descripcion = $request['expediente']['descripcion'];
				$current->prioridad   = $request['expediente']['prioridad'];
				$current->estado      = $request['expediente']['estado'];
	
				//TODO: Still need to process 'Referente' info...
				//TODO ------------------------------------------

				$expediente->save();
	
				// Process attachs
				// AyudaExpedienteService::processAttachments($expediente->ayudas(), $request['attachs']);
		
				// Process detachs
				AyudaExpedienteService::detach($expediente->ayudas(), $request['detachs']);
		
				// Process updates
				AyudaExpedienteService::update($expediente->ayudas(), $request['updates']);
			}
	
			else{
				// Create new 'Expediente' and attach 'Historico'		
				$current = HistoricoService::create($current, [
					'referente_otro' => $request['expediente']['referente_otro'],
					'descripcion'    => $request['expediente']['descripcion'],
					'prioridad'      => $request['expediente']['prioridad'],
					'estado'         => $request['expediente']['estado'],
					'fecha_desde'    => $request['fecha_desde'],
					'fecha_hasta'    => $request['fecha_hasta'],
					'pago_inicio'    => $request['pago_inicio'],
					'pago_final'     => $request['pago_final'],
				]);

				$current->persona;
				$current->referente;
				$current->meses      = $current->getMeses($current->fecha_desde, $current->fecha_hasta);
				$current->montoTotal = $current->getMontoTotal();
				// $current->archivado  = $item->trashed();
				
			}
			
			// Everything went just fine
			DB::commit();
		}
		catch(\Exception $e){
			// Something went wrong :(
			$status = false;
			// Rollback transaction
			DB::rollback();
			throw $e;
		}

		return response()->json([
			'status' => $status,
			'title'  => $status? '¡Operación exitosa!':                      'Ocurrió un fallo.',
			'msg'    => $status? 'Se realizaron los cambios correctamente.': 'Es posible que los datos ingresados no sean los correctos.',
			'data'   => $current,
		]);
	}

	public function restore($id){
		
		$status = true;
		DB::beginTransaction();
		
		try{
			Expediente::withTrashed()
			->find($id)
			->restore();
			DB::commit();
		}
		catch(\Exception $e){
			$status = false;
			DB::rollback();
		}

		return response()->json(['status' => $status]);
	}

	public function destroy($id){
		$status = Expediente::destroy($id) === 1;

		return response()->json([
			'status' => $status,
			'title'  => $status? '¡Operación exitosa!': 'Ocurrió un fallo.',
			'msg'    => $status? 'Archivado correctamente.' : 'Ocurrió un fallo.',
			// Count actual number of records, then divide by MAX_RECORDS
			// this will give the total number of pages, which is also
			// the last page index
			'last' => ceil( Expediente::count()/self::MAX_RECORDS ),
		]);
	}

	private function hasEmptyValues($array){
		
		foreach ($array as $item) return empty($item);

		return false;
	}
}
