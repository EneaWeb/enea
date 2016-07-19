<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order as Order;
use App\Http\Requests;
use Auth;
use Input;
use DB;

class ApiController extends Controller
{
	public function orders()
	{
		$days = Input::get('days', 7);
		$range = \Carbon\Carbon::now()->subDays(30);
		
		if (Auth::user()->can('manage orders')) {
			$stats = Order::where('created_at', '>=', $range)
			   ->groupBy('date')
			   ->orderBy('date', 'DESC')
			   ->get([
			      DB::raw('Date(created_at) as date'),
			      DB::raw('SUM(items_qty) as qty'),
			      DB::raw('SUM(total) as total'),
			   ])->toJSON();
		} else {
			$stats = Order::where('created_at', '>=', $range)
				->where('user_id', Auth::user()->id)
			   ->groupBy('date')
			   ->orderBy('date', 'DESC')
			   ->get([
			      DB::raw('Date(created_at) as date'),
			      DB::raw('SUM(items_qty) as qty'),
			      DB::raw('SUM(total) as total'),
			   ])->toJSON();
		}

		// return json stats
		return $stats;
	}
}