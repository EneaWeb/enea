<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order as Order;
use App\Http\Requests;
use Input;
use DB;

class ApiController extends Controller
{
	public function orders()
	{
		$days = Input::get('days', 7);
		$range = \Carbon\Carbon::now()->subDays($days);
		$stats = Order::where('created_at', '>=', $range)
		    ->groupBy('date')
		    ->orderBy('date', 'DESC')
		    ->get([
		        DB::raw('Date(created_at) as date'),
		        DB::raw('COUNT(*) as value')
		    ])
		    ->toJSON();
		// return json stats
		return $stats;
	}
}