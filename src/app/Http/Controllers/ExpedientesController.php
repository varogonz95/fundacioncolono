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

		$search   = [
			'value'    => $request['term'],
			'property' => $request['termProperty'],
		];

		$orderBy = [
			'by'           => $request['by'],
			'order'        => $request['order'],
			'relationship' => $request['orderRel']
		];

		$filter = [
			'relationship' => $request['filterRel'],
			'comparator'   => $request['comparator'],
			'property'     => $request['property'],
			'value'        => $request['value'],
		];

		$filtered = [];
		
		if ($this->hasEmptyValues($filter))
		$filtered = Filter::with(Expediente::class, ['persona', 'referente', 'ayudas'])
					->where('persona', $search['property'], 'like', "{$search['value']}%")
					->orderBy($orderBy['relationship'], $orderBy['by'], $orderBy['order'])
					->get();

		else
		$filtered = Filter::with(Expediente::class, ['persona', 'referente', 'ayudas'])
					->where($filter['relationship'], $filter['property'], $filter['comparator'], $filter['value'])
					->where('persona', $search['property'], 'like', "{$search['value']}%")
					->orderBy($request['orderRel'], $orderBy['by'], $orderBy['order'])
					->get();

		// Iterate over items
		$filtered->each(function($item, $index){
			$item->meses = $item->getMeses(
				$item->fecha_desde['raw'],
				$item->fecha_hasta['raw']
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

			ReferentesService::createOrAssociate(
				$expediente->referente(),
				$request['referente'],
				$request['referente_otro'],
				filter_var($request['hasReferenteOtro'], FILTER_VALIDATE_BOOLEAN),
				filter_var($request['newReferente'], FILTER_VALIDATE_BOOLEAN)
			);

			// Save Persona and Expediente altogether
			$persona->expediente()->save($expediente);

			AyudaExpedienteService::attach(
				$expediente->ayudas(), 
				['ids'     => $request['ayuda'], 
				'detalles' => $request['ayuda_detalle'], 
				'montos'   => $request['ayuda_monto']]
			);

			DB::commit();
			
		}

		catch(\Exception $e){
			$status = false;
			DB::rollback();
		}

		// Redirect and flash data with operation status
		return redirect('expedientes')
			->with('status', [
				'type'  => $status? 'success' : 'error',
				'title' => $status? '¡Operación exitosa!' : 'Ocurrió un error.',
				'msg'   => $status? 'Se ha creado el expediente correctamente.' : 
								    'Es posible que los datos ingresados sean incorrectos.<br>'.
								  	'Si el problema persiste, por favor contacte a soporte.',
			]);
		// return $request->all();
	}

	public function update(Request $request, $id){
		
		$status = true;
		$current = Expediente::find($id);

		DB::beginTransaction();

		try{
			
			if (!filter_var($request['record'], FILTER_VALIDATE_BOOLEAN)) {
				
				$current->referente_otro = $request['expediente']['referente_otro'];
				$current->descripcion = $request['expediente']['descripcion'];
				$current->fecha_desde = $request['expediente']['fecha_desde'];
				$current->fecha_hasta = $request['expediente']['fecha_hasta'];
				$current->pago_inicio = $request['expediente']['pago_inicio'];
				$current->pago_final  = $request['expediente']['pago_final'];
				$current->prioridad   = $request['expediente']['prioridad'];
				$current->estado      = $request['expediente']['estado'];

				$current->save();
				
				// Process attachs
				// AyudaExpedienteService::attach($expediente->ayudas(), $request['attachs']);
				
				// Process detachs
				AyudaExpedienteService::detach($current->ayudas(), $request['detachs']);
		
				// Process updates
				AyudaExpedienteService::update($current->ayudas(), $request['updates']);
			}
			
			else{
				// Create new 'Expediente' and attach 'Historico'		
				$current = HistoricoService::create($current, [
					'referente_otro' => $request['expediente']['referente_otro'],
					'descripcion'    => $request['expediente']['descripcion'],
					'fecha_desde'    => $request['expediente']['fecha_desde'],
					'fecha_hasta'    => $request['expediente']['fecha_hasta'],
					'pago_inicio'    => $request['expediente']['pago_inicio'],
					'pago_final'     => $request['expediente']['pago_final'],
					'prioridad'      => $request['expediente']['prioridad'],
					'estado'         => $request['expediente']['estado'],
				]);
				
			}
			
			//TODO: Still need to process 'Referente' info...
			ReferentesService::createOrAssociate(
				$current->referente(),
				$request['expediente']['referente']['id'],
				// If has referente_otro
				filter_var($request['expediente']['hasReferenteOtro'], FILTER_VALIDATE_BOOLEAN) ?
				// $request['expediente']['hasReferenteOtro'] ? 
					$request['expediente']['referente_otro'] : null, 
				filter_var($request['expediente']['hasReferenteOtro'], FILTER_VALIDATE_BOOLEAN),
				filter_var($request['expediente']['newReferente'], FILTER_VALIDATE_BOOLEAN)
			);

			$current->referente;
			$current->persona;
			$current->ayudas;
			$current->meses      = $current->getMeses($current->fecha_desde['raw'], $current->fecha_hasta['raw']);
			$current->montoTotal = $current->getMontoTotal();
			// $current->archivado  = $item->trashed();

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

	public function test($id)
	{
		return Expediente::with(['ayudas'])
					->whereHas('ayudas', function($query) use ($id){
						$query->where('ayudas.descripcion', 'like', 'asadsadf%');
					})
					->get();
	}
}
