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
					->options(function($builder) use ($request){
						if (filter_var($request['onlyTrashed'], FILTER_VALIDATE_BOOLEAN))
							return $builder->withTrashed();
						return $builder;
					})
					->where('persona', $search['property'], 'like', "{$search['value']}%")
					// TODO: Check if records are not in Historico
					// ->notIn()
					->orderBy($orderBy['relationship'], $orderBy['by'], $orderBy['order'])
					->get();

		else
		$filtered = Filter::with(Expediente::class, ['persona', 'referente', 'ayudas'])
					->options(function($builder) use ($request){
						if (filter_var($request['onlyTrashed'], FILTER_VALIDATE_BOOLEAN))
							return $builder->withTrashed();
						return $builder;
					})
					->where($filter['relationship'], $filter['property'], $filter['comparator'], $filter['value'])
					// TODO: Check if records are not in Historico
					// ->notIn()
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
		
		$status = true;
		DB::beginTransaction();
		
		try{

			// Instantiate Expediente and fill with request data
			$expediente = new Expediente;
			$expediente->fill($request->all());

			// Create Persona from request
			//	---> Parse 'ubicacion' attribute
			$persona = Persona::create($request->all());

			// Manage Referente relationship with Expediente
			ReferentesService::createOrAssociate(
				$expediente->referente(),
				$request['referente'],
				$request['referente_otro'],
				filter_var($request['hasReferenteOtro'], FILTER_VALIDATE_BOOLEAN),
				filter_var($request['newReferente'], FILTER_VALIDATE_BOOLEAN)
			);

			// Save Expediente and associate to Persona
			$persona->expediente()->save($expediente);

			// Attach Ayudas to Expediente
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
			throw $e;
		}

		// Redirect and flash data with operation status
		return redirect('expedientes')
			->with('status', [
				'type'  => $status? 'success' : 'error',
				'title' => $status? '¡Operación exitosa!' : 'Ocurrió un error.',
				'msg'   => $status? 'Se ha creado el expediente correctamente.' : 
								    'Es posible que los datos ingresados sean incorrectos.\n'.
								  	'Si el problema persiste, por favor contacte a soporte.',
			]);
	}

	public function update(Request $request, $id){
		
		$status = true;
		$current = Expediente::find($id);

		DB::beginTransaction();

		try{

			if (!filter_var($request['record'], FILTER_VALIDATE_BOOLEAN)) {
				
				$current->fill($request['expediente']);
				
				/**
				* TODO: Process attachs
				* TODO: AyudaExpedienteService::attach($expediente->ayudas(), $request['attachs']);
				*/
				
				// Process detachs
				AyudaExpedienteService::detach($current->ayudas(), $request['detachs']);
		
				// Process updates
				AyudaExpedienteService::update($current->ayudas(), $request['updates']);
			}
			
			else
				// Create new 'Expediente' and attach 'Historico'		
				$current = HistoricoService::create($current, $request['expediente']);
			
				ReferentesService::createOrAssociate(
					$current->referente(),
					$request['expediente']['referente']['id'],
					filter_var($request['expediente']['newReferente'], FILTER_VALIDATE_BOOLEAN) ?
					$request['expediente']['referente_otro'] : null,
					filter_var($request['expediente']['hasReferenteOtro'], FILTER_VALIDATE_BOOLEAN),
					filter_var($request['expediente']['newReferente'], FILTER_VALIDATE_BOOLEAN)
				);
				
			$current->referente_otro = filter_var($request['expediente']['referente_otro'], FILTER_VALIDATE_BOOLEAN) ? $request['expediente']['referente_otro'] : null;
			$current->save();

			$current->referente;
			$current->persona;
			$current->ayudas;
			$current->meses      = $current->getMeses($current->fecha_desde['raw'], $current->fecha_hasta['raw']);
			$current->montoTotal = $current->getMontoTotal();

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
			'title'  => $status ? '¡Operación exitosa!' : 'Ocurrió un fallo.',
			'type'   => $status ? 'success' : 'error',
			'msg'    => $status ? 'Se realizaron los cambios correctamente.': 'Es posible que los datos ingresados no sean los correctos.',
			'expediente'   => $current,
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

		return response()->json([
			'status' => $status,
			'title'  => $status ? '¡Operación exitosa!' : 'Ocurrió un fallo.',
			'type'   => $status ? 'success' : 'error',
			'msg'    => $status ? 'Se realizaron los cambios correctamente.': 'Es posible que los datos ingresados no sean los correctos.',
		]);
	}

	public function destroy($id){
		$status = Expediente::destroy($id) === 1;

		return response()->json([
			'status' => $status,
			'title'  => $status ? '¡Operación exitosa!' : 'Ocurrió un fallo.',
			'type'   => $status ? 'success' : 'error',
			'msg'    => $status ? 'Se realizaron los cambios correctamente.': 'Si el problema persiste, por favor contacte con soporte.',
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
