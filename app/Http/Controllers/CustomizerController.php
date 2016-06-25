<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Input;
use App\Http\Requests;
use Session;
use Localization;

class CustomizerController extends Controller
{
	public function cinziaaraia_index()
	{
		/*
		1) TOMAIA UP
			3 MATERIALI - Pitone Stampato, Crosta, Pelle (come esempio su fogli)
			14 COLORI - #4 Pitoni, #5 Croste, #5 Pelli (come esempio su fogli)
		2) TOMAIA DOWN
			1 MATERIALE - Tessuto
			5 COLORI - Light Grey, Sand, Black, White, Military (come esempio su fogli)
		3) TACCO
			2 MATERIALI - Pelle, Crosta (come esempio su fogli)  // verificare
			10 COLORI - 5x Pelli, 5x Croste (come esempio su fogli)  // verificare
		4) SUOLA
			2 COLORI - Gesso, Military (come esempio su fogli)
		5) SCRITTA
		SI/NO
		6) LOGO
			2 COLORI - Black, White
		*/
		
		$product = \App\Product::where('slug', '_custom')->first();
		
		Session::set('customizer-position', 'front');
		$page_title = 'Cinzia Araia Customizer';
		return view('customizer.cinziaaraia', compact('product', 'page_title'));
	}
	
	public function cinziaaraia_rotate()
	{
		Session::get('customizer-position', 'back');
		return true;
	}
}
