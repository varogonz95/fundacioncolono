<?php

namespace App\Http\Controllers;

use \App\Models\Expediente;
use \App\Services\AyudaExpedienteService;

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
        
        $status = true;
        $expediente = Expediente::find($id);

        DB::beginTransaction();
        
        try{

            // Process attachs
            // AyudaExpedienteService::processAttachments($expediente->ayudas(), $request['attachs']);
    
            // Process detachs
            AyudaExpedienteService::processDetachments($expediente->ayudas(), $request['detachs']);
    
            // Process updates
            AyudaExpedienteService::processUpdates($expediente->ayudas(), $request['updates']);

            // All good to commit :)
            DB::commit();
        }

        catch(\Exception $e){
            // Something went wrong :(
            $status = false;

            // Rollback transaction
            DB::rollback();
        }

        return response()->json([
            'status' => $status,
            'title'  => $status? '¡Operación exitosa!': 'Ocurrió un fallo.',
            'msg'    => $status? 'Se realizaron los cambios correctamente.' : 'Es posible que los datos ingresados no sean los correctos.',
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
