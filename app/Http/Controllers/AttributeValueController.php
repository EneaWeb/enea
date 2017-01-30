<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\AttributeValue as AttributeValue;
use Input;
use Auth;
use \App\Alert as Alert;
use App\Http\Requests;

class AttributeValueController extends Controller
{
	public function create()
	{
		// try to validate the Input
		$v = AttributeValue::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$attribute_value = new AttributeValue();
			// populate 
			$attribute_value->attribute_id = Input::get('attribute_id');
			$attribute_value->name = Input::get('name');
			$attribute_value->slug = trim(Input::get('slug'));
			$attribute_value->active = 1;
			// setConnection -required- for BRAND DB
			$attribute_value->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$attribute_value->save();

			// success message
			Alert::success(trans('x.Attribute Value saved'));
		
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
		// get ID from request and fine attr value
		$attribute_value = AttributeValue::find($id);
		// delete it
		$attribute_value->delete();
		// show success message
		Alert::success(trans('x.Attribute Value deleted'));
		// redirect back
		return redirect()->back();
	}
}
