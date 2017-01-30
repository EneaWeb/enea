<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Color as Color;
use Auth;
use Input;
use \App\Alert as Alert;
use App\Http\Requests;

class ColorController extends Controller
{
	public function index()
	{
		$colors = Color::all();
		return view('pages.catalogue.colors', compact('colors'));
	}
	
	public function create()
	{
		// try to validate the Input
		$v = Color::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$color = new Color();
			// populate 
			$color->name = Input::get('name');
			$color->slug = trim(Input::get('slug'));
			$color->hex = trim(Input::get('hex'));
			$color->active = 1;
			// setConnection -required- for BRAND DB
			$color->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$color->save();

			// success message
			Alert::success(trans('x.Color saved.'));
		
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
		$color = Color::find($id);
		// delete it
		$color->delete();
		// success message
		Alert::success(trans('x.Color deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit()
	{
		// try to validate the Input
		$v = Color::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			// get the delivery from ID
			$color = Color::find(Input::get('id'));
			// edit the informations 
			$color->name = Input::get('name');
			$color->slug = trim(Input::get('slug'));
			$color->hex = trim(Input::get('hex'));
			// setConnection -required- for BRAND DB
			$color->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$color->save();

			// success message
			Alert::success(trans('x.Color updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	
}
