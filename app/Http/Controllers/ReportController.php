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

class ReportController extends Controller
{
	public function index()
	{

		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {
			$product_ids = OrderDetail::groupBy('product_id')->lists('product_id');
			$order_details = OrderDetail::all();
		} else {
			$product_ids = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->groupBy('product_id')->lists('product_id');
			$order_details = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->groupBy('product_id')->get();
		}
		
		return view('reports.index', compact('order_details', 'product_ids'));
	}
	
	public function sold_variations()
	{
		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {
			$variation_ids = OrderDetail::groupBy('product_variation_id')->orderBy('product_id')->lists('product_variation_id');
			$order_details = OrderDetail::all();
		} else {
			$variation_ids = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->groupBy('product_variation_id')
			->orderBy('product_id')
			->lists('product_variation_id');
			$order_details = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->get();
		}

		return view('reports.variations', compact('order_details', 'variation_ids'));
	}
	
	public function sold_delivery()
	{
		$season_delivery_ids = Order::groupBy('season_delivery_id')->lists('season_delivery_id');
		return view('reports.delivery', compact('season_delivery_ids'));
	}
	
	public function select_delivery()
	{
		$season_delivery_id = Input::get('season_delivery_id');
		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {

			$variation_ids = OrderDetail::whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->groupBy('product_variation_id')->lists('product_variation_id');
			
			$order_details = OrderDetail::whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->get();

		} else {
			$variation_ids = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->groupBy('product_variation_id')->lists('product_variation_id');
			
			$order_details = OrderDetail::whereHas('product', function($q) use ($type_id) {
			    $q->where('type_id', '=', $type_id);
			})->whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->get();
		}
		
		return view('reports._delivery_table', compact('order_details', 'variation_ids', 'season_delivery_id'));
	}
	
	public function zero_sold()
	{
		$all_variations = ProductVariation::lists('id');
		$type_id = Auth::user()->options->active_type;

		if ($type_id == 1) {
			$sold_variations = OrderDetail::groupBy('product_variation_id')->orderBy('product_id')->lists('product_variation_id');
			$variation_ids = $all_variations->diff($sold_variations);
			$order_details = OrderDetail::all();
		} else {
			$sold_variations = OrderDetail::whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->groupBy('product_variation_id')->orderBy('product_id')->lists('product_variation_id');
			$variation_ids = $all_variations->diff($sold_variations);
			$order_details = OrderDetail::whereHas('order', function($q) use ($season_delivery_id) {
				$q->where('season_delivery_id', $season_delivery_id);
			})->get();
		}
		return view('reports.zero', compact('order_details', 'variation_ids'));
	}
	
	
	
}
