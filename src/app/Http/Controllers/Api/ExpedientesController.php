<?php

namespace App\Http\Controllers\Api;

use App\Models\Expediente;
use App\Models\Visita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ExpedientesController extends Controller{
    
    public function index(Request $request){

        DB::beginTransaction();

        try {

            $arrayExpediente = Visita::with(['expediente'])->get()->pluck('expediente.id')->all();

            $expedientes = Expediente::with( ['persona'] )
            ->whereNotIn('id', $arrayExpediente)
            ->where('estado', 3)
            ->orderBy( 'persona_fk' , 'asc' )
            ->get();
            
            DB::commit();

        }
        catch (Exception $e) {
            DB::rollback();
        }

       return response()->json([
          'expedientes' => $expedientes,
        ]);
        
    }

}