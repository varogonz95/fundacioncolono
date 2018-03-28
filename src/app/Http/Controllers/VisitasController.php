<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\Request;

class VisitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
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
        $status = Visita::destroy($id) === 1;

        return response()->json([
            'status' => $status,
            'title'  => $status ? '¡Operación exitosa!' : 'Ocurrió un fallo.',
            'type'   => $status ? 'success' : 'error',
            'msg'    => $status ? 'Se archivó el expediente correctamente.': 'Si el problema persiste, por favor contacte con soporte.',
            // Count actual number of records, then divide by MAX_RECORDS
            // this will give the total number of pages, which is also
            // the last page index
        ]);
    }
}
