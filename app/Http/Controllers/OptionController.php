<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Option as Option;
use \App\Alert as Alert;
use Auth;
use App\Http\Requests;
use Session;

class OptionController extends Controller
{
	public function set_active_season(Request $request)
	{
		// season id to activate
		$season_id = $request->get('season_id');
		// get right option
		$option = Option::where('name', 'active_season')->first();
		// set the season id to activate
		$option->value = $season_id;
		// setConnection -required- for BRAND DB
		$option->setConnection(Auth::user()->options->brand_in_use->slug);
		// update row
		$option->save();
		// return a success message
		Alert::success(trans('x.Active Season updated'));
		// return back
		return redirect()->back();
	}
}
