<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use \App\Attribute as Attribute;
use \App\Alert as Alert;
use App\Http\Requests;

class AttributeController extends Controller
{
	public function index()
	{
		return view('pages.catalogue.attributes');
	}
	
	public function create()
	{
		// try to validate the Input
		$v = Attribute::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$attribute = new Attribute();
			// populate 
			$attribute->name = Input::get('name');
			$attribute->slug = trim(Input::get('slug'));
			$attribute->description = Input::get('description');
			$attribute->active = 1;
			// setConnection -required- for BRAND DB
			$attribute->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$attribute->save();

			// success message
			Alert::success(trans('x.Attribute saved.'));
		
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
