<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use \App\Payment as Payment;
use \App\Alert as Alert;
use App\Http\Requests;

class PaymentController extends Controller
{

	public function index()
	{
		$payments = Payment::all();
		return view('pages.settings.payments', compact('payments'));
	}

    public function modalEdit(Request $request)
    {
        $payment_id = $request->get('payment_id');
        $payment = \App\Payment::find($payment_id);
        
        return view('modals.settings.edit_payment', compact('payment'));
    }
	
	public function create()
	{
		// try to validate the Input
		$v = Payment::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$payment = new Payment();
			// populate 
			$payment->name = Input::get('name');
			$payment->slug = trim(Input::get('slug'));
			$payment->action = Input::get('action');
			$payment->amount = str_replace(',','.',Input::get('amount'));
			$payment->active = 1;
			// setConnection -required- for BRAND DB
			$payment->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$payment->save();

			// success message
			Alert::success(trans('x.Payment Option saved'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	public function delete($id)
	{
		// get the delivery from ID
		$payment = Payment::find($id);
		// delete it
		$payment->delete();
		// success message
		Alert::success(trans('x.Payment Option deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit()
	{
		// try to validate the Input
		$v = Payment::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			// get the delivery from ID
			$payment = Payment::find(Input::get('id'));
			// edit the informations 
			$payment->name = Input::get('name');
			$payment->slug = trim(Input::get('slug'));
			$payment->action = Input::get('action');
			$payment->amount = str_replace(',','.',Input::get('amount'));
			// setConnection -required- for BRAND DB
			$payment->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$payment->save();

			// success message
			Alert::success(trans('x.Payment Option updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
}
