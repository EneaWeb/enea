<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\ProdModel as ProdModel;
use Auth;
use Input;
use \App\Alert as Alert;
use App\Http\Requests;

class ProdModelController extends Controller
{
	public function index()
	{
		$models = ProdModel::all();
		return view('pages.catalogue.models', compact('models'));
	}
	
	public function create()
	{
		// try to validate the Input
		$v = ProdModel::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$prodmodel = new ProdModel();
			// populate 
			$prodmodel->name = Input::get('name');
			$prodmodel->slug = trim(Input::get('slug'));
			$prodmodel->type_id = Input::get('type_id');
			$prodmodel->active = 1;
			// setConnection -required- for BRAND DB
			$prodmodel->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$prodmodel->save();

			// success message
			Alert::success(trans('x.Model saved.'));
		
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
		$payment = ProdModel::find($id);
		// delete it
		$payment->delete();
		// success message
		Alert::success(trans('x.Model deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit()
	{
		// try to validate the Input
		$v = ProdModel::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			// get the delivery from ID
			$prodmodel = ProdModel::find(Input::get('model_id'));
			// edit the informations 
			$prodmodel->name = Input::get('name');
			$prodmodel->slug = trim(Input::get('slug'));
			$prodmodel->type_id = Input::get('type_id');
			$prodmodel->active = Input::get('active');
			// setConnection -required- for BRAND DB
			$prodmodel->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$prodmodel->save();

			// success message
			Alert::success(trans('x.Model updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
	
}
