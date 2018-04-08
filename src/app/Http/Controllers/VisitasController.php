<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Expediente;

use Illuminate\Http\Request;
use DB;

class VisitasController extends Controller
{
    const MAX_RECORDS = 16;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        //
        $pagination = Expediente::with( ['persona', 'visita'])
        ->where('id','expediente_fk')
        ->withTrashed()
        ->paginate(self::MAX_RECORDS);
          
        $items = $pagination->items();

        return response()->json([
          'expedientes' => $items,
          'total' => $pagination->total()
        ]);
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
        $status = true;
        DB::beginTransaction();
        
        try{
            $visita = new Visita;
            $visita->inspector_fk = $request['inspector_fk'];
            $visita->expediente_fk = $request['expediente_fk'];
            $visita->save();
        
            DB::commit();
        
        }catch(\Exception $e){
            $status = false;
            DB::rollback();
            throw $e;
        }

        // Redirect and flash data with operation status
        return redirect('expedientes')
            ->with('status', [
                'type'  => $status? 'success' : 'error',
                'title' => $status? '¡Operación exitosa!' : 'Ocurrió un error.',
                'msg'   => $status? 'Se ha creado el expediente correctamente.' : 
                                    'Es posible que los datos ingresados sean incorrectos.\n'.
                                    'Si el problema persiste, por favor contacte a soporte.',
            ]);
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
