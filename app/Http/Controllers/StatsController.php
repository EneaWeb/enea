<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order as Order;
use App\Http\Requests;
use Auth;
use Input;
use DB;
use \App\Alert as Alert;

class StatsController extends Controller
{

	public function customize()
	{
		return view('stats.customize_stats');
	}

	public function add_chart()
	{
		Alert::success('Impostazioni aggiornate');
		return redirect()->back();
	}

	public function orders()
	{
		//$days = Input::get('days', 7);
		$range = \Carbon\Carbon::now()->subDays(999);
		
		if ( (Auth::user()->can('manage orders')) || (Auth::user()->hasRole('accountant'))) {
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
	
	public function orders_type()
	{

 	$stats = DB::connection(Auth::user()->options->brand_in_use->slug)->table('order_details')
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->select(DB::raw('SUM(order_details.total_price) as value'), 'products.type_id as label')->groupBy('products.type_id')->get();
   
   $better_stats = array();
   foreach ($stats as $stat) {
   	$type_slug = trans('messages.'.\App\Type::find($stat->label)->slug);
   	$stat->label = $type_slug;
   }
		// return json stats
		return json_encode($stats);
	}
	
}