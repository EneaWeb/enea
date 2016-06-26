<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Auth;
use App;
use App\Http\Requests;

class PDFController extends Controller
{
	
	public function order_confirmation_download($id)
	{
		// DOMPDF
		
		$order = \App\Order::find($id);
		if ($order->customer_delivery_id == 0)
			$customer_delivery = $order->customer;
		else
			$customer_delivery = \App\CustomerDelivery::find($order->customer_delivery_id);
		$order_details = \App\OrderDetail::where('order_id', $order->id)->get();
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);

		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadView('pdf.order_confirmation', compact('order', 'customer_delivery', 'order_details', 'brand'));
		$pdf->setPaper('A4');
		$pdf->setOrientation('landscape');
		
		return $pdf->download(trans('messages.Order').' '.$brand->name.' #'.$order->id.'.pdf');	
	}
	
	public function order_confirmation_view($id)
	{
		// DOMPDF
		
		$order = \App\Order::find($id);
		if ($order->customer_delivery_id == 0)
			$customer_delivery = $order->customer;
		else
			$customer_delivery = \App\CustomerDelivery::find($order->customer_delivery_id);
		$order_details = \App\OrderDetail::where('order_id', $order->id)->get();
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);

		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadView('pdf.order_confirmation', compact('order', 'customer_delivery', 'order_details', 'brand'));
		$pdf->setPaper('A4');
		$pdf->setOrientation('landscape');
		
		return $pdf->stream();
	}
	
	public function linesheet()
	{
		// DOMPDF
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);
		$products = \App\Product::where('active', 1)->where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get();
		
		
		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadView('pdf.line_sheet', compact('brand', 'products'));
		$pdf->setPaper('A4');
		
		return $pdf->stream();
	}

}
