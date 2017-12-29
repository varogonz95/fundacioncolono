<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Inspector;
use App\Models\Persona;
use App\Models\Usuario;

use App\Services\UserRegistratorService;

use DB;
use Filter;

class InspectoresController extends Controller{

	const MAX_RECORDS = 16;

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
			$filtered = Filter::with(Inspector::class, ['persona', 'usuario'])
		  ->where('persona', $orderBy['by'], 'like', "{$request['search']}%")
		  ->orderBy($request['relationship'], $orderBy['by'], $orderBy['order'])
		  ->get();
	  else
		$filtered = Filter::with(Inspector::class, ['persona', 'usuario'])
		  ->where($request['relationship'], $filter['property'], $filter['comparator'], $filter['value'])
		  ->where('persona', $orderBy['by'], 'like', "{$request['search']}%")
		  ->orderBy('persona', $orderBy['by'], $orderBy['order'])
		  ->get();


  		// Paginate , passing the filtered items and the max records per page
  		$pagination = Filter::paginate($filtered, self::MAX_RECORDS);
  		$items = $pagination->items();

	  return response()->json([
		'inspectores' => $items,
		'total'       => $pagination->total(),
		// 'pages'       => ceil( Expediente::count()/self::MAX_RECORDS ),
	  ]);
	}

	public function index(){
		return view('templates.inspector.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		return view('templates.inspector.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		
		$status = true;
		DB::beginTransaction();
		
		try{
			
			//Create Persona
			$persona = Persona::create($request->all());
			
			//Create user account with validation
			$user = UserRegistratorService::create($request->all(), true);
			
			//Instatiate Inspector model
			$inspector = new Inspector();
			
			//Associate persona and usuario
			$inspector->persona()->associate($persona);
			$inspector->usuario()->associate($user);
			
			// Save model
			$inspector->save();

			DB::commit();
		}

		catch(\Exception $e){
			$status = false;
			DB::rollback();
			throw $e;
		}
		
		return redirect()
			->route('inspectores.create')
			->with('status', [
				'type'  => $status? 'success' : 'error',
				'title' => $status? '¡Operación exitosa!' : 'Ocurrió un error.',
				'msg'   => $status? 'Se ha creado el expediente correctamente.': 
								   	'Es posible que los datos ingresados sean incorrectos.\n'.
								   	'Si el problema persiste, por favor contacte a soporte.',
			]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		//
	}

	private function hasEmptyValues($array){

  		foreach ($array as $item) return empty($item);

  		return false;
  	}
}
