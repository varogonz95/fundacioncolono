<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        // Obtener la fecha de hoy
        $today = new \DateTime();
        // Obtener el día
        $today_day = $today->format('d');
        // Obtener la fecha en el formato Año/Mes/Día
		$today_string = $today->format('Y/m/d');

		$pending_transactions = Expediente::with([
                // Precargar la Persona
                'persona', 
                // Precargar las Ayudas que NO están en transacciones.
                // Es decir, las ayudas que están pendientes de entrega.
                'ayudas' => function($ayudas) {
                    $ayudas->doesntHave('transactions');
                }
            ])
            // Consultar los expedientes donde:
            // 1. La fecha actual está entre fecha_desde y fecha_hasta
            // 2. El día actual está entre entrega_inicio y entrega_final
			->where([
				['fecha_desde', '<=', $today_string],
				['fecha_hasta', '>=', $today_string],
				['entrega_inicio', '<=', $today_day],
				['entrega_final', '>=', $today_day],
            ])
            // Ordenar por fecha_desde
            ->orderBy('fecha_desde')
            // Obtener array de resultados (implementa interfaz Collections de Laravel)
            ->get()
            
            // Filtrar los expedientes donde la lista de ayudas no esté vacía
            // Es decir, no mostrar expedientes con una lista de ayudas vacía
            ->filter(function($value){
                return $value->ayudas->isNotEmpty();
            })
            // Iterar sobre la lista de resultados
			->each(function($expediente){
                // Formatear las fechas en formato de la región
				$expediente->formatted_fecha_desde = (new \DateTime($expediente->fecha_desde))->format('d/m/Y');
                $expediente->formatted_fecha_hasta = (new \DateTime($expediente->fecha_hasta))->format('d/m/Y');
			});

        return view('home', ['pending_transactions' => $pending_transactions]);
        // return response()->json($pending_transactions);
    }
}
