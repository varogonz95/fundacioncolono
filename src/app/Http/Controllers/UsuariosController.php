<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

use DB;

class UsuariosController extends Controller{
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

        $status = true;

        DB::beginTransaction();

        try {
            $usuario = Usuario::find($id);
            $usuario->email    = $request['data']['email'];
            $usuario->username = $request['data']['username'];
            $usuario->password = $request['data']['password'];

            $usuario->save();

            DB::commit();
        }
        catch (Exception $e) {
            $status  = false;
            DB::rollback();
        }

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
