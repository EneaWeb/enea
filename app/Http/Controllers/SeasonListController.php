<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use \App\SeasonList as SeasonList;
use \App\Alert as Alert;
use App\Http\Requests;

class SeasonListController extends Controller
{

	public function create()
	{
		// try to validate the Input
		$v = SeasonList::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$season_list = new SeasonList();
			// populate 
			$season_list->season_id = Input::get('season_id');
			$season_list->name = Input::get('name');
			$season_list->slug = trim(Input::get('slug'));
			// setConnection -required- for BRAND DB
			$season_list->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$season_list->save();

			// success message
			Alert::success(trans('messages.Price List saved'));
		
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
		$season_list = SeasonList::find($id);
		// delete it
		$season_list->delete();
		// success message
		Alert::success(trans('messages.Price List deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit()
	{
		// try to validate the Input
		$v = SeasonList::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			// get the delivery from ID
			$season_list = SeasonList::find(Input::get('id'));
			// edit the informations
			$season_list->name = Input::get('name');
			$season_list->slug = trim(Input::get('slug'));
			// setConnection -required- for BRAND DB
			$season_list->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$season_list->save();

			// success message
			Alert::success(trans('messages.Price List updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
}
