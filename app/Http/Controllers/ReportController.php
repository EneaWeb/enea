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

class ReportController extends Controller
{
	public function index()
	{
		$product_ids = OrderDetail::groupBy('product_id')->lists('product_id');
		$order_details = OrderDetail::all();
		return view('reports.index', compact('order_details', 'product_ids'));
	}
	
	public function sold_variations()
	{
		$variation_ids = OrderDetail::groupBy('product_variation_id')->orderBy('product_id')->lists('product_variation_id');
		$order_details = OrderDetail::all();
		return view('reports.variations', compact('order_details', 'variation_ids'));
	}
	
	public function zero_sold()
	{
		$all_variations = ProductVariation::lists('id');
		$sold_variations = OrderDetail::groupBy('product_variation_id')->orderBy('product_id')->lists('product_variation_id');
		$variation_ids = $all_variations->diff($sold_variations);
		$order_details = OrderDetail::all();
		return view('reports.zero', compact('order_details', 'variation_ids'));
	}
	
	
	
}
