<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

        $persona = Persona::find($id);

        $persona->nombre    = $request['nombre'];
        $persona->apellidos = $request['apellidos'];
        $persona->telefonos = $request['telefonos'];
        $persona->ubicacion = "{$request['provincia']['cod']}/{$request['canton']['cod']}/{$request['distrito']['cod']}";
        $persona->direccion = $request['direccion'];
        $persona->contactos = $request['contactos'];

        // $request->flash('status', [
        //         'type' => $status? 'success' : 'danger',
        //         'title' => $status? 'Éxito' : 'Error',
        //         'msg' => $status? 'Msj de éxito' : 'Msj de error',
        //     ]);

        $status = $persona->save();

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
    public function destroy($id)
    {
        //
    }
}
