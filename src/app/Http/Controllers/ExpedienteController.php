<?php

namespace App\Http\Controllers;

use App\Model\Expediente;
use App\Model\Persona;
use App\Model\TipoAyuda;

use Illuminate\Http\Request;

class ExpedienteController extends Controller{

    const MAX = 16;

    public function index(){
        $results = Expediente::paginate(self::MAX);
        $items = $results->items();

        // Get owner
        foreach ($items as $expediente) {
            $expediente->persona;
            $expediente->ayuda;
        }

        return response()->json([
            'expedientes' => $items,
            'total' => $results->total(),
            'last' => $results->lastPage()
        ]);
    }

    public function store(Request $request){

        $expediente = new Expediente;
        $ayuda = TipoAyuda::find($request->expediente['ayuda']);
        $persona = Persona::find($request->persona['cedula']);

        $expediente->prioridad         =   $request->expediente['prioridad'];
        $expediente->monto             =   $request->expediente['monto'];
        $expediente->descripcion       =   $request->expediente['descripcion'];
        $expediente->estado            =   0;
        $expediente->recomendaciones   =   $request->expediente['recomendaciones'];

        $expediente->ayuda()->associate($ayuda);

        return response()->json($persona->expedientes()->save($expediente));
    }

    public function append(Request $request, $id){}

    public function update(Request $request, $id){}

    public function destroy($id){

        return response()->json(['deleted' => Expediente::destroy($id)]);
    }
}
