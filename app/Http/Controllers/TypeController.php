<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use DB;
use \App\Type as Type;
use \App\Alert as Alert;
use App\Http\Requests;

 // adult / kid / man / woman / male_kid / female_kid / unisex /

class TypeController extends Controller
{
	
	public function index()
	{
		$types = Type::all();
		return view('pages.admin.types');
	}
	
	
	public function update()
	{
		$reset_all = DB::connection(Auth::user()->options->brand_in_use->slug)->table('types')->update(array('active' => 0));
		foreach (Input::all() as $key => $value) {
			$type = Type::where('name', $key)->first();
			$type->active = $value;
			// setConnection -required- for BRAND DB
			$type->setConnection(Auth::user()->options->brand_in_use->slug);
			// save the line(s)
			$type->save();
		}
		
		// success message
		Alert::success(trans('x.Types updated'));
		
		// redirect back
		return redirect()->back();
	}
}
