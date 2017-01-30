<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use \App\Variation as Variation;
use \App\Alert as Alert;
use App\Http\Requests;

class VariationController extends Controller
{
	public function index()
	{
		$active_season = \App\Option::where('name', 'active_season')->first()->value;
		$variations = Variation::where('season_id', $active_season)->get();
		return view('pages.catalogue.variations', compact('variations'));
	}
	
	public function create()
	{
		// try to validate the Input
		$v = Variation::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$variation = new Variation();
			// populate
			$variation->name = Input::get('name');
			$variation->slug = trim(Input::get('slug'));
			$variation->description = Input::get('description');
			$variation->season_id = Input::get('season_id');
			$variation->active = 1;
			// setConnection -required- for BRAND DB
			$variation->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$variation->save();

			// success message
			Alert::success(trans('x.Variation saved.'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	public function delete()
	{
		
	}
	
}
