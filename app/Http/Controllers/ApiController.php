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
	
	public function orders_seasonlist_n()
	{
		$days = Input::get('days', 7);
		$range = \Carbon\Carbon::now()->subDays(30);

		$stats = Order::groupBy('season_list_id')
			->leftJoin('season_lists', 'orders.season_list_id', '=', 'season_lists.id')
		   ->orderBy('season_list_id', 'DESC')
		   ->get([
		      DB::raw('COUNT(*) as value'),
		      DB::raw('season_lists.name as label'),
		   ])->toJSON();
		// return json stats
		return $stats;
	}
	
	public function orders_seasonlist_tot()
	{
		$days = Input::get('days', 7);
		$range = \Carbon\Carbon::now()->subDays(30);

		$stats = Order::groupBy('season_list_id')
			->leftJoin('season_lists', 'orders.season_list_id', '=', 'season_lists.id')
		   ->orderBy('season_list_id', 'DESC')
		   ->get([
		      DB::raw('SUM(total) as value'),
		      DB::raw('season_lists.name as label'),
		   ])->toJSON();
		// return json stats
		return $stats;
	}
	
}