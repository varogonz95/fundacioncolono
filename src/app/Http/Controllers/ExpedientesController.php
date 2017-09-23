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

    private function newReferente(Referente $r){
        $r->save();
    }

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
        $persona->ubicacion     =   "{$request['provincia']}/{$request['canton']}/{$request['distrito']}";
        $persona->direccion     =   $request['direccion'];
        $persona->contactos     =   $request['contactos'];

        // If new Persona insert is successful,
        // then...
        if ($persona->save()) {

            // Assign Expediente property values
            $expediente->descripcion = $request['descripcion'];
            $expediente->prioridad   = $request['prioridad'];
            $expediente->estado      = $request['estado'];

            // Check if Referente is 'Otro'.
            // filter hasReferente input value to boolean
            if (filter_var($request['hasReferenteOtro'], FILTER_VALIDATE_BOOLEAN)) {

                // Create and save new Referente if its new
                // filter hasReferente input value to boolean                
                if (filter_var($request['newReferente'], FILTER_VALIDATE_BOOLEAN)) {
                    $referente = new Referente;
                    $referente->descripcion = $request['referente_otro'];
                    $referente->save();
                    // Associate that new Referente to this Expediente
                    $expediente->referente()->associate($referente);
                }
                // If not, then associate Expediente with first Referente (Otro)
                else {
                    $expediente->referente_otro = $request['referente_otro'];
                    $expediente->referente()->associate(Referente::first());
                }

            }
            // If not, associate Expediente with a Referente
            else {
                $expediente->referente()->associate(Referente::find($request['referente']));
            }

            $status = $persona->expediente()->save($expediente);
        }

        for ($i=0, $count = count($request['ayuda']); $i < $count; $i++) {
            $expediente->ayudas()->attach($request['ayuda'][$i], [
                'detalle' => $request['ayuda_detalle'][$i],
                'monto' => $request['ayuda_monto'][$i]
            ]);
        }

        $request->session()->flash('status', [
                'type' => $status? 'success' : 'danger',
                'title' => $status? 'Éxito' : 'Error',
                'msg' => $status? 'Msj de éxito' : 'Msj de error',
            ]);

        return redirect('expedientes');
        // return $request->all();
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
