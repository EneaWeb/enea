<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use \App\SeasonDelivery as SeasonDelivery;
use \App\Alert as Alert;
use App\Http\Requests;

class SeasonDeliveryController extends Controller
{

	public function create()
	{
		// try to validate the Input
		$v = SeasonDelivery::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$season_delivery = new SeasonDelivery();
			// populate 
			$season_delivery->season_id = Input::get('season_id');
			$season_delivery->name = Input::get('name');
			$season_delivery->slug = trim(Input::get('slug'));
			$season_delivery->date = Input::get('date');
			$season_delivery->active = '1';
			// setConnection -required- for BRAND DB
			$season_delivery->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$season_delivery->save();

			// success message
			Alert::success(trans('x.Delivery Date saved'));
		
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
		$season_delivery = SeasonDelivery::find($id);
		// delete it
		$season_delivery->delete();
		// success message
		Alert::success(trans('x.Delivery Date deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit()
	{
		// try to validate the Input
		$v = SeasonDelivery::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			// get the delivery from ID
			$season_delivery = SeasonDelivery::find(Input::get('id'));
			// edit the informations
			$season_delivery->name = Input::get('name');
			$season_delivery->slug = trim(Input::get('slug'));
			$season_delivery->date = Input::get('date');
			// setConnection -required- for BRAND DB
			$season_delivery->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$season_delivery->save();

			// success message
			Alert::success(trans('x.Delivery Date updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
}
