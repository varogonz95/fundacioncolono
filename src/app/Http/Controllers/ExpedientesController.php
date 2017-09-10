<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Persona;
use App\Models\Referente;

use Illuminate\Http\Request;
use Session;

class ExpedientesController extends Controller{

    const EN_VALORACION = 0;
    const APROBADO = 1;
    const NO_APROBADO = 2;

    public function all(Request $req){
        $expedientes = Expediente::orderBy(($req['by'] === 'cedula')? 'persona_fk' : $req['by'], $req['order'])->paginate(16);

        foreach ($expedientes as $e) {
            $e->persona;
            $e->referente;
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
        $persona->telefonos     =   $request['tels'];
        $persona->ubicacion     =   "7/2/1";
        $persona->direccion     =   $request['direccion'];
        $persona->contactos     =   $request['contactos'];
        $persona->es_inspector  =   false;

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

        Session::flash('status', [
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
