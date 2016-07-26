<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Auth;
use App;
use Input;
use Localization;
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
	
	public function linesheet($id)
	{
		// DOMPDF
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);
		$products = \App\Product::where('active', 1)->where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get();
		
		if ($id == 'clean')
			$seasonlist = 'clean';
		else 
			$seasonlist = \App\SeasonList::find($id);
		
		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadView('pdf.line_sheet', compact('brand', 'products', 'seasonlist'));
		$pdf->setPaper('A4');
		
		// return view('pdf.line_sheet', compact('brand', 'products', 'seasonlist');
		//return $pdf->stream();
		if ($seasonlist == 'clean')
			return $pdf->download($brand->name.' Line Sheet '.\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name.' clean.pdf');
		else
			return $pdf->download($brand->name.' Line Sheet '.\App\Season::find(\App\Option::where('name', 'active_season')->first()->value)->name.' '.$seasonlist->name.'.pdf');
	}
	
	public function linesheet_test($id)
	{
		// DOMPDF
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);
		$products = \App\Product::where('active', 1)->where('season_id', \App\Option::where('name', 'active_season')->first()->value)->get();
		
		if ($id == 'clean')
			$seasonlist = 'clean';
		else 
			$seasonlist = \App\SeasonList::find($id);
		
		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadView('pdf.line_sheet', compact('brand', 'products', 'seasonlist'));
		$pdf->setPaper('A4');
		
		// return view('pdf.line_sheet', compact('brand', 'products', 'seasonlist');
		//return $pdf->stream();
		return $pdf->stream();
	}
	
	public function proforma($id)
	{
		// DOMPDF
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);
		$order = \App\Order::find($id);
		$user_locale = Localization::getCurrentLocale();
		$customer_language = $order->customer->language;
		Localization::setLocale($customer_language);
		
		if (Input::has('number'))
			$number = Input::get('number');
		else
			$number = '[number]';
		
		if (Input::has('description'))
			$description = Input::get('description');
		else
			$description = 'Esempio descrizione pagamento 30%';
		
		if (Input::has('percentage'))
			$percentage = Input::get('percentage');
		else
			$percentage = '30';
		
		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadView('pdf.proforma', compact('brand', 'order', 'number', 'description','percentage'));
		$pdf->setPaper('A4');
		
		Localization::setLocale($user_locale);
		return $pdf->stream();
		//return $pdf->download(trans('messages.Proforma').' '.$brand->name.' '.$number.'.pdf');
	}

	public function invoice($id)
	{
		// DOMPDF
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);
		$order = \App\Order::find($id);
		$user_locale = Localization::getCurrentLocale();
		$customer_language = $order->customer->language;
		Localization::setLocale($customer_language);
		
		if (Input::has('number'))
			$number = Input::get('number');
		else
			$number = '[number]';
		
		if (Input::has('description'))
			$description = Input::get('description');
		else
			$description = 'Esempio descrizione pagamento 30%';
		
		if (Input::has('percentage'))
			$percentage = Input::get('percentage');
		else
			$percentage = '30';
		
		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadView('pdf.invoice', compact('brand', 'order', 'number', 'description','percentage'));
		$pdf->setPaper('A4');
		
		Localization::setLocale($user_locale);
		return $pdf->stream();
		//return $pdf->download(trans('messages.Invoice').' '.$brand->name.' '.$number.'.pdf');
	}
	
	public function waybill($id)
	{
		// DOMPDF
		$brand = \App\Brand::find(Auth::user()->options->brand_in_use->id);
		$order = \App\Order::find($id);
		$user_locale = Localization::getCurrentLocale();
		$customer_language = $order->customer->language;
		Localization::setLocale($customer_language);
		
		if (Input::has('number'))
			$number = Input::get('number');
		else
			$number = '[number]';
		
		if (Input::has('date'))
			$date = Input::get('date');
		else
			$date = '[data]';
		
		if (Input::has('n_colli'))
			$n_colli = Input::get('n_colli');
		else
			$n_colli = '[n_colli]';
		
		if (Input::has('weight'))
			$weight = Input::get('weight');
		else
			$weight = '[weight]';
		
		if (Input::has('shipper'))
			$shipper = Input::get('shipper');
		else
			$shipper = '[shipper]';
		
		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadView('pdf.waybill', compact('brand', 'order', 'number', 'date', 'weight', 'shipper', 'n_colli'));
		$pdf->setPaper('A4');
		
		Localization::setLocale($user_locale);
		return $pdf->stream();
		//return $pdf->download(trans('messages.Invoice').' '.$brand->name.' '.$number.'.pdf');
	}

}
