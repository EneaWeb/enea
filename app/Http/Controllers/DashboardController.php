<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use Input;
use URL;
use Config;
use App;
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
use DB;

class DashboardController extends Controller
{
	
	public function index()
	{

		$pageTitle = 'Dashboard';

		$confirmedOrders = \App\X::thisSeasonOrders()->count();
		$confirmedPieces = \App\X::thisSeasonOrders()->sum('items_qty');
		$incomes = number_format(\App\X::thisSeasonOrders()->sum('total'), 2, '.', ',');
		$orderedItems = \App\OrderDetail::whereHas('order', function($q){
			$q->where('season_id', \App\X::activeSeason());
		})->sum('qty');

		$mostReqItem = \App\OrderDetail::whereHas('order', function($q){
			$q->where('season_id', \App\X::activeSeason());
		})->groupBy('product_variation_id')
		->selectRaw('*, sum(qty) as totQty')
		->first();

        if ($mostReqItem !== NULL)
		    $mostReqItem = [ 'name'=>$mostReqItem->product_variation->fullName(), 'qty' => $mostReqItem->totQty ];
        else
            $mostReqItem = ['name'=>'none', 'qty'=>'0'];

		$mostReqSize = DB::connection(Auth::user()->options->brand_in_use->slug)->select("
			SELECT i.size_id, sum(d.qty) as totQty
			FROM items i
			LEFT JOIN order_details d
				ON i.id = d.item_id
				INNER JOIN orders o
					ON o.id = d.order_id
					AND o.season_id = ".\App\X::activeSeason()."
			GROUP BY i.size_id
			ORDER BY totQty desc
			LIMIT 1
		");

        if (!empty($mostReqSize))
            $mostReqSize = [ 'name'=> \App\Size::find($mostReqSize[0]->size_id)->name, 'qty' => $mostReqSize[0]->totQty ];
        else
            $mostReqSize = ['name'=>'none', 'qty'=>'0'];

		//$mainOrder = 

		$user = Auth::user();
		if ( (Auth::user()->can('manage orders')) || (Auth::user()->hasRole('accountant')))
			$orders = Order::where('season_id', \App\X::activeSeason())->orderBy('id', 'desc')->get();
		else
			$orders = Order::where('user_id', Auth::user()->id)->where('season_id', \App\X::activeSeason())->orderBy('id', 'desc')->get();

			// retrieve all customers
			$customers = Customer::all();
			// autocomplete
			/*
			$autocomplete = new Autocomplete();
			$autocomplete->setPrefixJavascriptVariable('place_autocomplete_');
			$autocomplete->setInputId('place_input');
			$autocomplete->setInputAttributes(['name' => 'address', 'class' => 'form-control']);
			//$autocomplete->setValue('aaa');
			$autocomplete->setTypes(array(AutocompleteType::GEOCODE));
			//$autocomplete->setComponentRestrictions(array(AutocompleteComponentRestriction::COUNTRY => 'fr'));
			$autocomplete->setBound(45, 9, 45, 9, true, true);
			$autocomplete->setAsync(false);
			$autocomplete->setLanguage(Localization::getCurrentLocale());
			if (!App::environment('local')) 
				$autocomplete->setApiKey(Config::get('general.google_api_key'));
			// render
			$autocompleteHelper = new AutocompleteHelper();
			*/
			
			/*
			if (Auth::user()->can('manage orders')) {
				$mapHelper = new MapHelper;
				$map = Maps::orders_map($orders);
			}
			*/
			
			// prepare dropdown with supported Locales
			$configLocales = Config::get('localization.supported-locales');
			$supportedLocales = array();
			foreach ($configLocales as $key => $locale) {
				$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
			}
			
			if (Auth::user()->can('manage orders'))
				return view('dashboard.admin', compact('orders', 
																	'supportedLocales', 
																	'map', 
																	'mapHelper', 
																	'pageTitle', 
																	'confirmedOrders',
																	'confirmedPieces',
																	'mostReqItem',
																	'mostReqSize',
																	'incomes'));
			if (Auth::user()->hasRole('accountant'))
			   return view('dashboard.accountant', compact('orders', 'orders', 'supportedLocales', 'pagetitle'));
			
			return view('dashboard.agent', compact('orders', 'supportedLocales', 'pageTitle'));
		// }
		
	}
	
	public function set_locale($locale_key)
	{
		// cambio localization
		Localization::setLocale($locale_key);
		// preparo l'alert
		\App\Alert::success(trans('x.Language changed'));
		
		// recupero l'indirizzo precedente alla richiesta
		$prev_url = parse_url(Localization::getNonLocalizedURL(URL::previous()));
		// ritorno l'indirizzo precedente, col prefisso di località cambiato
		return redirect($locale_key.$prev_url['path']);
	}
}
