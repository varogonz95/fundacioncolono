<?php

namespace App\Http\Controllers;

use App\Model\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller{

    const MAX = 16;

    public function index(Request $request){

        // Filter results and paginate them
        $results = Persona::orderBy($request->property, $request->by)->paginate(self::MAX);
        // Get array items from pagination
        $items = $results->items();

        // Get all records from person
        foreach ($items as $persona) {
            $persona->expedientes;

            // Get TipoAyuda model relationship
            foreach ($persona->expedientes as $expediente) {
                $expediente->ayuda;
            }
        }

        return response()->json([
            'personas' => $items,
            // Additional data for pagination links
            'total' => $results->total(),
            'last' => $results->lastPage()
        ]);
    }

    public function store(Request $request){

        $person = new Persona;

        $person->cedula    =   $request->persona['cedula'];
        $person->nombre    =   $request->persona['nombre'];
        $person->apellidos =   $request->persona['apellidos'];
        $person->ocupacion =   $request->persona['ocupacion'];
        $person->tels      =   $request->persona['tels'];
        $person->ubicacion =   "{$request->persona['provincia']}/{$request->persona['canton']}/{$request->persona['distrito']}";
        $person->direccion =   $request->persona['direccion'];
        $person->contactos =   $request->persona['contactos'];

        return response()->json(['personsuccess' => $person->save()]);
    }

    public function update(Request $request, $id){
        return response()->json([
            'result'=>DB::table('personas')
            ->where('cedula', $request->cedula)
            ->update([
                'nombre'=>$request->nombre,
                'apellidos'=>$request->apellidos,
                'ocupacion'=>$request->ocupacion,
                'tels'=>$request->tels
            ])
        ]);
    }

    public function destroy($id){
        $result=Persona::destroy($id);
        $last=Persona::paginate(self::MAX)->lastPage();

        return response()->json(['result'=>$result,'last'=>$last]);
    }
}
