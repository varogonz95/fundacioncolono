<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Persona;
use App\Models\Referente;

use Illuminate\Http\Request;

class ExpedientesController extends Controller{

    const EN_VALORACION = 0;
    const APROBADO = 1;
    const NO_APROBADO = 2;

    public function all(Request $request){

        $by = $request['by'] === 'cedula'? 'persona_fk' : $request['by'];

        $request->session()->put('sort', [ 'by' => $by, 'order' => $request['order'] ]);

        $expedientes = Expediente::orderBy($by, $request['order'])->paginate(16);

        foreach ($expedientes as $e) {
            $e->persona;
            $e->referente;
            $e->ayudas;
        }

        return response()->json([
            'expedientes' => $expedientes->items(),
            'total' => $expedientes->total(),
            'last' => $expedientes->lastPage(),
        ]);
    }

    public function index(){
        return view('expedientes');
    }

    public function create(){
        return view('templates.create');
    }

    public function store(Request $request){

        $expediente = new Expediente;
        $persona = new Persona;

        $persona->cedula        =   $request['cedula'];
        $persona->nombre        =   $request['nombre'];
        $persona->apellidos     =   $request['apellidos'];
        $persona->telefonos     =   $request['telefonos'];
        $persona->ubicacion     =   "7/2/1";
        $persona->direccion     =   $request['direccion'];
        $persona->contactos     =   $request['contactos'];

        if ($persona->save()) {
            $expediente->descripcion = $request['descripcion'];
            $expediente->prioridad   = $request['prioridad'];
            $expediente->estado      = $request['estado'];

            // Associate Expediente with a Referente
            $expediente->referente()->associate(Referente::find($request['referente']));

            // Check if Referente is 'Otro' (first id).
            // If so, then asign $request['referente_otro'] to expediente->referente_otro
            // $expediente->referente_otro = ($request['referente_otro'])? : ;

            $status = $persona->expediente()->save($expediente);
        }

        $request->session()->flash('status', [
                'type' => $status? 'success' : 'danger',
                'title' => $status? 'Éxito' : 'Error',
                'msg' => $status? 'Msj de éxito' : 'Msj de error',
            ]);

        return redirect('expedientes');
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
    public function edit($id)
    {
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

        $expediente = Expediente::find($id);

        $expediente->descripcion = $request['descripcion'];
        $expediente->prioridad   = $request['prioridad'];
        $expediente->estado      = $request['estado'];

        $status = $expediente->save();

        return response()->json([
            'status' => $status,
            'title' => $status? 'Ok' : 'Error',
            'msg' => $status? 'Everything ok' : 'Baby don\'t worry about nothing, \'cause every little thing is gonna be alright',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        // delete Persona, so it can delete in cascade to Expediente
        $status = Persona::destroy(Expediente::find($id)->persona_fk) > 0;

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
