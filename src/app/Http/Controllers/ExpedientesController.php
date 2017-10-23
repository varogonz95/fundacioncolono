<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Persona;
use App\Models\Referente;

use Illuminate\Http\Request;
use Filter;
use DB;

class ExpedientesController extends Controller
{

    const EN_VALORACION = 0;
    const APROBADO = 1;
    const NO_APROBADO = 2;

    private $items;
    private $total;
    private $lastPage;

    public function __construct()
    {
        $this->items = [];
        $this->total = 0;
        $this->lastPage = 0;
    }

    public function test(Request $request){

        $pagination = Filter::badassFunction(
            Expediente::class,
            ['persona', 'referente', 'ayudas'],           // -> Better performance, since it uses eager loading
            [
                'relationship' => $request['relationship'], 
                'property' => $request['property'],
                'comparator' => $request['comparator'], 
                'value' => $request['value']
            ]
        )
        ->paginate(16);

        $expedientes = $pagination->items();
        $total = $pagination->total();

        foreach ($expedientes as $e) {
            $e->montoTotal = $e->getMontoTotal();
        }

        return response()->json([
            'expedientes' => $expedientes,
            'total' => $total,
        ]);
    }

    public function all(Request $request){

        $expedientes = Expediente::with(['persona', 'referente', 'ayudas']);

        $by = $request['by'] === 'cedula'? 'persona_fk' : $request['by'];

        $request->session()->put('sort', [ 'by' => $by, 'order' => $request['order'] ]);

        if($request->has('search')){
            $expedientes = $expedientes->where($by, 'like', "{$request['search']}%")->orderBy($by, $request['order'])->paginate(16);
        }
        else {
            $expedientes = $expedientes->orderBy($by, $request['order'])->paginate(16);
        }

        foreach ($expedientes as $e) {
            $e->montoTotal = $e->getMontoTotal();
        }

        return response()->json([
            'expedientes' => $expedientes->items(),
            'total' => $expedientes->total(),
        ]);
    }

    public function index()
    {
        return view(
            'templates.expediente.index', 
            // Pass first Referente id into template
            // to prevent 'hard coding'
            ['first_referente' => Referente::first()->id]
        );
    }

    public function create()
    {
        return view('templates.expediente.create_all');
    }

    public function store(Request $request){

        // DB::transaction(function () {});

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
        $expediente->descripcion = $request['descripcion'];
        $expediente->prioridad   = $request['prioridad'];
        $expediente->estado      = $request['estado'];

        // If new Persona insert is successful,
        // then...

        $persona->save();

        // Check if Referente is 'Otro'.
        if (filter_var($request['hasReferenteOtro'], FILTER_VALIDATE_BOOLEAN)) {
            
            // Create and save new Referente
            if (filter_var($request['newReferente'], FILTER_VALIDATE_BOOLEAN)) {
                $referente = new Referente(['descripcion' => $request['referente_otro']]);
                
                // Associate that new Referente to this Expediente
                $expediente->referente()->save($referente);
            }
            
            // If not, then associate Expediente with first Referente (Otro)
            else {
                $expediente->referente_otro = $request['referente_otro'];
                $expediente->referente()->associate(Referente::first());
            }
        }
        
        // If not, associate Expediente with a Referente
        else {
            $expediente->referente()->associate(
                is_null($request['referente'])?
                    Referente::first()->id :
                    Referente::find($request['referente'])
                );
        }

        // Save Persona and Expediente altogether
        $status = $persona->expediente()->save($expediente);

        // Loop through input ayuda and attach them to Expediente
        for ($i=0, $count = count($request['ayuda']); $i < $count; $i++) {
            $expediente->ayudas()->attach($request['ayuda'][$i], [
                'detalle' => $request['ayuda_detalle'][$i],
                'monto' => $request['ayuda_monto'][$i]
            ]);
        }

        // Flash whole operation status
        $request->session()->flash('status', [
                'type' => $status? 'success' : 'danger',
                'title' => $status? 'Éxito' : 'Error',
                'msg' => $status? 'Msj de éxito' : 'Msj de error',
            ]);

        return redirect('expedientes');
        // return $request->all();
    }

    public function show($id)
    {
        return response()->json(Expediente::find($id));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id){

        // $expediente = Expediente::find($id);

        // $expediente->descripcion = $request['descripcion'];
        // $expediente->prioridad   = $request['prioridad'];
        // $expediente->estado      = $request['estado'];

        // $status = $expediente->save();
        $status = true;

        return response()->json([
            'status' => $status,
            'title' => $status? 'Ok' : 'Error',
            'msg' => $status? 'Everything ok' : 'Baby don\'t worry about nothing, \'cause every little thing is gonna be alright',
        ]);
    }

    public function destroy($id)
    {

        // delete Persona, so it can delete in cascade to Expediente
        $status = Persona::destroy($id) > 0;

        return response()->json([
            'status' => $status,
            'title' => $status? 'Ok' : 'Error',
            'msg' => $status? 'Everything ok' : 'Baby don\'t worry about nothing, \'cause every little thing is gonna be alright',
            // **************** OPTIMIZE THIS **********************
            // ---- COMPUTE, THEN STORE IN SESSION
            'last' => Expediente::orderBy(session('sort')['by'], session('sort')['order'])->paginate(16)->lastPage(),
        ]);
    }
}
