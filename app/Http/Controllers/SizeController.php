<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Size as Size;
use Auth;
use Input;
use \App\Alert as Alert;
use App\Http\Requests;

class SizeController extends Controller
{
	public function index()
	{
		$sizes = Size::all();
		return view('pages.catalogue.sizes', compact('sizes'));
	}
	
	public function create()
	{
		// try to validate the Input
		$v = Size::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$size = new Size();
			// populate 
			$size->name = Input::get('name');
			$size->slug = trim(Input::get('slug'));
			$size->active = 1;
			// setConnection -required- for BRAND DB
			$size->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$size->save();

			// success message
			Alert::success(trans('x.Size saved.'));
		
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
		$size = Size::find($id);
		// delete it
		$size->delete();
		// success message
		Alert::success(trans('x.Size deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit()
	{
		// try to validate the Input
		$v = Size::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			// get the delivery from ID
			$size = Size::find(Input::get('id'));
			// edit the informations 
			$size->name = Input::get('name');
			$size->slug = trim(Input::get('slug'));
			// setConnection -required- for BRAND DB
			$size->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$size->save();

			// success message
			Alert::success(trans('x.Size updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	
}
