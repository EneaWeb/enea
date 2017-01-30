<?php

namespace App\Http\Controllers;

use Config;
use DB;
use \App\Order as Order;
use \App\User as User;
use \App\ProductVariation as ProductVariation;
use \App\OrderDetail as OrderDetail;
use \App\Customer as Customer;
use \App\Option as Option;
use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
	public function index()
	{

		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {
			$product_ids = OrderDetail::groupBy('product_id')->pluck('product_id');
			$order_details = OrderDetail::all();
		} else {
			$product_ids = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', $type_id);
			})->groupBy('product_id')->pluck('product_id');
			$order_details = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', $type_id);
			})->groupBy('product_id')->get();
		}
		
		return view('reports.index', compact('order_details', 'product_ids'));
	}
	
	public function sold_variations()
	{
		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {
			$variation_ids = OrderDetail::groupBy('product_variation_id')->orderBy('product_id')->pluck('product_variation_id');
			$order_details = OrderDetail::all();
		} else {
			$variation_ids = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->groupBy('product_variation_id')
			->orderBy('product_id')
			->pluck('product_variation_id');
			$order_details = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->get();
		}

		return view('reports.variations', compact('order_details', 'variation_ids'));
	}

	public function stats()
	{
		// prepare dropdown with supported Locales
		$configLocales = Config::get('localization.supported-locales');
		$supportedLocales = array();
		foreach ($configLocales as $key => $locale) {
			$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
		}

		return view('reports.stats', compact('supportedLocales'));
	}

	public function time_interval()
	{
		$dates = array();
		$dates_js = array();
		$grouped_by_Ymd = Order::select('created_at')
						->get()
						->groupBy(function($date) {
		  				return Carbon::parse($date->created_at)->format('Y-m-d');
					});
		foreach ($grouped_by_Ymd as $k => $v) {
			$dates[] = $k.' 00:01';
			$dates_js[] = Carbon::parse($k)->format('j-n-Y');
		}

		return view('reports.time_interval', compact('dates', 'dates_js'));
	}
	
	public function sold_delivery()
	{
		$season_delivery_ids = Order::groupBy('season_delivery_id')->pluck('season_delivery_id');
		return view('reports.delivery', compact('season_delivery_ids'));
	}
	
	public function select_delivery()
	{
		$season_delivery_id = Input::get('season_delivery_id');
		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {

			$variation_ids = OrderDetail::whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->groupBy('product_variation_id')->pluck('product_variation_id');
			
			$order_details = OrderDetail::whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->get();

		} else {
			$variation_ids = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->groupBy('product_variation_id')->pluck('product_variation_id');
			
			$order_details = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->get();
		}
		
		return view('reports._delivery_table', compact('order_details', 'variation_ids', 'season_delivery_id'));
	}

	public function select_date()
	{
		$date = Input::get('date');
		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {

			$variation_ids = OrderDetail::whereHas('order', function($q) use ($date) {
				$q->where('created_at', '>=', $date);
			})->groupBy('product_variation_id')->pluck('product_variation_id');
			
			$order_details = OrderDetail::whereHas('order', function($q) use ($date) {
				$q->where('created_at', '>=', $date);
			})->get();

		} else {
			$variation_ids = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->whereHas('order', function($q) use ($date) {
				$q->where('created_at', '>=', $date);
			})->groupBy('product_variation_id')->pluck('product_variation_id');
			
			$order_details = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->whereHas('order', function($q) use ($date) {
				$q->where('created_at', '>=', $date);
			})->get();
		}
		
		return view('reports._time_interval_table', compact('order_details', 'variation_ids', 'date'));
	}
	
	public function zero_sold()
	{
		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {
			$all_variations = ProductVariation::lists('id');
			$sold_variations = OrderDetail::groupBy('product_variation_id')->orderBy('product_id')->pluck('product_variation_id');
			$variation_ids = $all_variations->diff($sold_variations);
			$order_details = OrderDetail::all();
		} else {
			$all_variations = ProductVariation::whereHas('product', function($q) use ($type_id) {
				$q->where('type_id', $type_id);
			})->pluck('id');
			$sold_variations = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->groupBy('product_variation_id')->orderBy('product_id')->pluck('product_variation_id');
			$variation_ids = $all_variations->diff($sold_variations);
			$order_details = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->get();
		}
		return view('reports.zero', compact('order_details', 'variation_ids'));
	}
	
	
	
}
