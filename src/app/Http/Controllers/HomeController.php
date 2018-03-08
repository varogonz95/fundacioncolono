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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$today = (new \DateTime())->format('Y/m/d');

		$pending_transactions = Expediente::with(['transacciones', 'persona', 'ayudas'])
			->where([
				['fecha_desde', '<=', $today],
				['fecha_hasta', '>=', $today],
				['entrega_inicio', '<=', 11],
				['entrega_final', '>', 11],
			])
			->get()
			->each(function($pt){
				$pt->formatted_fecha_desde = (new \DateTime($pt->fecha_desde))->format('d/m/Y');
				$pt->formatted_fecha_hasta = (new \DateTime($pt->fecha_hasta))->format('d/m/Y');
			});

        return view('home', ['pending_transactions' => $pending_transactions]);
    }
}
