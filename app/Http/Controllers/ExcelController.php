<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Excel;

class ExcelController extends Controller
{
	public function order_confirmation_download($id)
	{

		$order = \App\Order::find($id);
		$order_details = \App\OrderDetail::where('order_id', $order->id)->get();
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);

		Excel::create(trans('x.Order').' '.$brand->name.' #'.$order->id, function($excel) use ($order, $order_details, $brand) {
	    	$excel->sheet(trans('x.Order'), function($sheet) use ($order, $order_details, $brand) {
		        $sheet->loadView('excel.order_detail', compact('order_details', 'order', 'brand'));
	    	});
       	// Set the title
 			$excel->setTitle(trans('x.Order').' '.$brand->name.' #'.$order->id);
	    	// Chain the setters
	    	$excel->setCreator('EneaWeb System')
       		->setCompany('EneaWeb');
       	$excel->download('xlsx');
		});
		
	}
}
