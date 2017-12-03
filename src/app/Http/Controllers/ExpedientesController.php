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

	public function test(Request $request){
		// return Expediente::count();
	}

	public function all(Request $request){

		$orderBy = [
			'order' => $request['order'],
			'by' => $request['by'],
		];

		$filter = [
			'comparator' => $request['comparator'],
			'property'   => $request['property'],
			'value'      => $request['value'],
		];

		$filtered = [];
		
		if ($this->hasEmptyValues($filter))
		$filtered = Filter::with(Expediente::class, ['persona', 'referente', 'ayudas'])
					->where('persona', $orderBy['by'], 'like', "{$request['search']}%")
					->orderBy($request['relationship'], $orderBy['by'], $orderBy['order'])
					->get();

		else
		$filtered = Filter::with(Expediente::class, ['persona', 'referente', 'ayudas'])
					->where($request['relationship'], $filter['property'], $filter['comparator'], $filter['value'])
					->where('persona', $orderBy['by'], 'like', "{$request['search']}%")
					->orderBy('persona', $orderBy['by'], $orderBy['order'])
					->get();

		// Iterate over items
		$filtered->each(function($item, $index){
			$item->montoTotal = $item->getMontoTotal();
			$item->archivado = $item->trashed();
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
		$expediente->descripcion = $request['descripcion'];
		$expediente->prioridad   = $request['prioridad'];
		$expediente->estado      = $request['estado'];

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
				'type' => $status? 'success' : 'danger',
				'title' => $status? '¡Operación exitosa!' : 'Ocurrió un error.',
				'msg' => $status? 'Msj de éxito' : 'Msj de error',
			]);
		// return $request->all();
	}

	public function show($id){
		return response()->json(Expediente::find($id));
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
				HistoricoService::create($current, [
					'referente_otro' => $request['expediente']['referente_otro'],
					'descripcion'    => $request['expediente']['descripcion'],
					'prioridad'      => $request['expediente']['prioridad'],
					'estado'         => $request['expediente']['estado'],
				]);
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
			'title'  => $status? '¡Operación exitosa!': 'Ocurrió un fallo.',
			'msg'    => $status? 'Se realizaron los cambios correctamente.' : 'Es posible que los datos ingresados no sean los correctos.',
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
