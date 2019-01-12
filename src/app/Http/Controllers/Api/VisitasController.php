<?php

namespace App\Http\Controllers\Api;

use App\Models\Visita;
use App\Models\Expediente;
use App\Models\Inspector;
use App\Models\Historico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VisitasController extends Controller{
    
        public function index(Request $request){

        DB::beginTransaction();  
        
        try{
             $search   = [
            'value'    => $request['term'],
            'property' => $request['termProperty'],
            ];

            $orderBy = [
                'by'           => $request['by'],
                'order'        => $request['order'],
                'relationship' => $request['orderRel']
            ];

            $filter = [
                'relationship' => $request['filterRel'],
                'comparator'   => $request['comparator'],
                'property'     => $request['property'],
                'value'        => $request['comparator'] === 'like' ? "{$request['value']}%" : $request['value'],
            ];

            $filtered = null;

            if ($this->hasEmptyValues($filter))
            $filtered = Filter::with(Expediente::class, ['persona', 'referente', 'ayudas'])
                        ->options(function($builder) use ($request){ return filter_var($request['onlyTrashed'], FILTER_VALIDATE_BOOLEAN) ? $builder->withTrashed() : null; })
                        ->where('persona', $search['property'], 'like', "{$search['value']}%")
                        ->notIn(\App\Models\Historico::class, 'expediente_fk')
                        ->orderBy($orderBy['relationship'], $orderBy['by'], $orderBy['order'])
                        ->get();

            else
            $filtered = Filter::with(Expediente::class, ['persona', 'referente', 'ayudas'])
                        ->options(function($builder) use ($request){ return filter_var($request['onlyTrashed'], FILTER_VALIDATE_BOOLEAN) ? $builder->withTrashed() : null; })
                        ->where($filter['relationship'], $filter['property'], $filter['comparator'], $filter['value'])
                        ->notIn(\App\Models\Historico::class, 'expediente_fk')
                        ->where('persona', $search['property'], 'like', "{$search['value']}%")
                        ->orderBy($request['orderRel'], $orderBy['by'], $orderBy['order'])
                        ->get();

            // Iterate over items
            $filtered->each(function($item, $index){
                $item->meses      = $item->getMeses();
                $item->montoTotal = $item->getMontoTotal();
                $item->archivado  = $item->trashed();
            });
            
            // Paginate , passing the filtered items and the max records per page
            //$pagination = Filter::paginate($filtered, self::MAX_RECORDS);
            $items = $pagination->items();

            DB::commit();

        }catch (Exception $e) {
            
            DB::rollback();
        }

        return response()->json([
            'expedientes' => $items,
            'total'       => $pagination->total(),
        ]);
    }

}
