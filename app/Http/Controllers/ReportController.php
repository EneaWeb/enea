<?php

namespace App\Http\Controllers;

use Config;
use DB;
use \App\Order as Order;
use \App\User as User;
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
		$variation_ids = OrderDetail::groupBy('product_variation_id')->lists('product_variation_id');
		$order_details = OrderDetail::all();
		return view('reports.index', compact('order_details', 'product_ids', 'variation_ids'));
	}
}
