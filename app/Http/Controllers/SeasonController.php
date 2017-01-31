<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use \App\Season as Season;
use \App\Alert as Alert;
use App\Http\Requests;

class SeasonController extends Controller
{
	public function index()
	{
		// get active season
        $active_season = \App\X::activeSeason();
        $seasons = \App\Season::orderBy('id', 'desc')->get();
		// return view with season object
		return view('pages.catalogue.seasons', compact('active_season', 'seasons'));
		
	}
	
	public function change()
	{
		if (Input::has('season_id'))
			$season_id = Input::get('season_id');
		
		return redirect('/catalogue/season/'.$season_id);
	}
	
	public function getSeason($id)
	{
		$season = Season::find($id);
		return view('pages.catalogue.seasons', compact('season'));
	}
	
	public function create()
	{
		// try to validate the Input
		$v = Season::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$season = new Season();
			// populate 
			$season->name = Input::get('name');
			$season->slug = trim(Input::get('slug'));
			$season->active = 1;
			// setConnection -required- for BRAND DB
			$season->setConnection(\App\X::brandInUseSlug());
			// save the line(s)
			$season->save();

			// success message
			Alert::success(trans('x.Season saved'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
}
