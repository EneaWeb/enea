<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use Input;
use URL;
use Localization;
use App\Http\Requests;
use App\Order as Order;
use App\Gestionale\Maps as Maps;
use \App\Customer as Customer;
use Ivory\GoogleMap\Helper\MapHelper;
use Ivory\GoogleMap\Places\Autocomplete;
use Ivory\GoogleMap\Places\AutocompleteComponentRestriction;
use Ivory\GoogleMap\Places\AutocompleteType;
use Ivory\GoogleMap\Helper\Places\AutocompleteHelper;
use App\Gestionale\Stats as Stats;

class DashboardController extends Controller
{
	
	public function index()
	{

		$user = Auth::user();
		if (Auth::user()->can('manage orders'))
			$orders = Order::all();
		else
			$orders = Order::where('user_id', Auth::user()->id)->get();
		/*
		if ($user->can('manage brands')) {
			$mapHelper = new MapHelper;
			$map = Maps::orders_map();
			return view('dashboard.admin', compact('map', 'mapHelper', 'orders'));
		} else {
		*/

			// retrieve all customers
			/*
			$customers = Customer::all();
			$autocomplete = new Autocomplete();
			$autocomplete->setPrefixJavascriptVariable('place_autocomplete_');
			$autocomplete->setInputId('place_input');
			$autocomplete->setInputAttributes(['class' => 'my-class', 'name' => 'address', 'class' => 'form-control']);
			//$autocomplete->setValue('aaa');
			$autocomplete->setTypes(array(AutocompleteType::GEOCODE));
			//$autocomplete->setComponentRestrictions(array(AutocompleteComponentRestriction::COUNTRY => 'fr'));
			$autocomplete->setBound(45, 9, 45, 9, true, true);
			$autocomplete->setAsync(false);
			$autocomplete->setLanguage(Localization::getCurrentLocale());
			// render
			$autocompleteHelper = new AutocompleteHelper();
			*/
			
			return view('dashboard.agent', compact('orders'));
		// }
		
	}
	
	public function set_locale($locale_key)
	{
		// cambio localization
		Localization::setLocale($locale_key);
		// preparo l'alert
		\App\Alert::success(trans('messages.Language changed'));
		
		// recupero l'indirizzo precedente alla richiesta
		$prev_url = parse_url(Localization::getNonLocalizedURL(URL::previous()));
		// ritorno l'indirizzo precedente, col prefisso di località cambiato
		return redirect($locale_key.$prev_url['path']);
	}
}
