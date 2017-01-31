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
        $attributes = \App\Attribute::all();
		return view('pages.catalogue.attributes', compact('attributes'));
	}
	
	public function create(Request $request)
	{
		// try to validate the Input
		$v = Attribute::validate($request->all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$attribute = new Attribute();
			// populate 
            $attribute->id = trim(str_replace(' ','-',strtolower($request->get('id'))));
			$attribute->name = $request->get('name');
			$attribute->description = $request->get('description');
			$attribute->active = 1;
			// setConnection -required- for BRAND DB
			$attribute->setConnection(\App\X::brandInUseSlug());
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
	
	public function edit(Request $request)
	{
		$attributeId = $request->get('attribute_id');
        $attr = \App\Attribute::find($attributeId);
        
        $id = trim(str_replace(' ','-',strtolower($request->get('id'))));
        $name = $request->get('name');
        $description = $request->get('description');
        
        $attr->id = $id;
        $attr->name = $name;
        $attr->description = $description;

        $attr->save();

        Alert::success(trans('x.Attribute updated'));
        return redirect()->back();
	}
	
}
