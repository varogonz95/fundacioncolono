<?php

namespace App\Http\Controllers;

use \App\Models\Ayuda;
use \App\Models\Expediente;

use DB;
use Illuminate\Http\Request;

class AyudaExpedienteController extends Controller{
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
        
        $expediente = Expediente::find($id);
        $status = true;

        DB::beginTransaction();
        
        try{

            // Process attachs
            for ($i=0, $count = count($request['ayudas']['attachs']); $i < $count; $i++)
                 $expediente->ayudas()
                 ->attach(
                     $request['ayudas']['attachs'][$i]['id'],
                     []
                 );
    
            // Process detachs
            for ($i=0, $count = count($request['ayudas']['detachs']); $i < $count; $i++)
                $expediente->ayudas()->detach($request['ayudas']['detachs'][$i]['id']);
    
            // Process updates
            for ($i=0, $count = count($request['ayudas']['updates']); $i < $count; $i++)
                $expediente->ayudas()
                ->updateExistingPivot(
                    $request['ayudas']['updates'][$i]['id'], 
                    [
                        'detalle' => $request['ayudas']['updates'][$i]['pivot']['detalle'],
                        'monto' => $request['ayudas']['updates'][$i]['pivot']['monto']
                    ]
                );

            // All good to commit
            DB::commit();
        }

        catch(\Exception $e){
            // Something went wrong
            $status = false;
        }

        return response()->json([
            'status' => $status,
            'title' => $status? '¡Operación exitosa!' : 'Ocurrió un fallo.',
            'msg' => $status? 'Se realizaron los cambios correctamente' : 'Es posible que los datos ingresados no sean los correctos.',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        return $request->all();
    }
}
