<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use Config;
use App;
use \App\Customer as Customer;
use \App\CustomerDelivery as CustomerDelivery;
use \App\Alert as Alert;
use App\Http\Requests;
use App\Gestionale\Maps as Maps;
use Ivory\GoogleMap\Helper\MapHelper;
use Ivory\GoogleMap\Places\Autocomplete;
use Ivory\GoogleMap\Places\AutocompleteComponentRestriction;
use Ivory\GoogleMap\Places\AutocompleteType;
use Ivory\GoogleMap\Helper\Places\AutocompleteHelper;
use Ivory\GoogleMap\Services\Geocoding\GeocoderProvider as GeocoderProvider;
use Geocoder\HttpAdapter\CurlHttpAdapter as CurlHttpAdapter;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;
use Localization;

class CustomerController extends Controller
{

	public function index()
	{
		
		// retrieve all customers
		$customers = Customer::all();
		
		$autocomplete = new Autocomplete();
		$autocomplete->setPrefixJavascriptVariable('place_autocomplete_');
		$autocomplete->setInputId('place_input');
		$autocomplete->setInputAttributes(['class' => 'my-class', 'name' => 'address', 'class' => 'form-control']);
		$autocomplete->setTypes(array(AutocompleteType::GEOCODE));
		//$autocomplete->setComponentRestrictions(array(AutocompleteComponentRestriction::COUNTRY => 'fr'));
		$autocomplete->setBound(45, 9, 45, 9, true, true);
		$autocomplete->setAsync(false);
		$autocomplete->setLanguage(Localization::getCurrentLocale());
		if (!App::environment('local')) 
				$autocomplete->setApiKey(Config::get('general.google_api_key'));
		// render
		$autocompleteHelper = new AutocompleteHelper();

		// prepare dropdown with supported Locales
		$configLocales = Config::get('localization.supported-locales');
		$supportedLocales = array();
		foreach ($configLocales as $key => $locale) {
			$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
		}
		
		return view('pages.customers.index', compact('customers', 'autocomplete', 'autocompleteHelper', 'supportedLocales'));
	}

	public function show($id)
	{
		// get customer profile
		$customer = Customer::find($id);
		$address = $customer->address.' - '.$customer->postcode.' '.$customer->city.' ('.$customer->province.') - '.$customer->country;
		
		// autocomplete
		$autocomplete = new Autocomplete();
		$autocomplete->setPrefixJavascriptVariable('place_main_autocomplete_');
		$autocomplete->setInputId('main_autocomplete');
		$autocomplete->setInputAttributes(['name' => 'address', 'class' => 'form-control']);
		$autocomplete->setTypes(array(AutocompleteType::GEOCODE));
		$autocomplete->setValue($address);
		$autocomplete->setBound(45, 9, 45, 9, true, true);
		$autocomplete->setAsync(false);
		$autocomplete->setLanguage(Localization::getCurrentLocale());
		if (!App::environment('local')) 
			$autocomplete->setApiKey(Config::get('general.google_api_key'));
		
		// autocomplete
		$autocomplete2 = new Autocomplete();
		$autocomplete2->setPrefixJavascriptVariable('place_delivery_autocomplete_');
		$autocomplete2->setInputId('delivery_autocomplete');
		$autocomplete2->setInputAttributes(['name' => 'address', 'class' => 'form-control']);
		$autocomplete2->setTypes(array(AutocompleteType::GEOCODE));
		$autocomplete2->setBound(45, 9, 45, 9, true, true);
		$autocomplete2->setAsync(false);
		$autocomplete2->setLanguage(Localization::getCurrentLocale());
		if (!App::environment('local')) 
			$autocomplete2->setApiKey(Config::get('general.google_api_key'));
		
		// rendering helper
		$autocompleteHelper = new AutocompleteHelper();
		
		// maps render helper
		$mapHelper = new MapHelper;
		$map = Maps::customer_position_map($address);
		
		// prepare dropdown with supported Locales
		$configLocales = Config::get('localization.supported-locales');
		$supportedLocales = array();
		foreach ($configLocales as $key => $locale) {
			$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
		}

		return view('pages.customers.show', compact('customer', 
		                                            'map', 
		                                            'mapHelper', 
		                                            'autocomplete', 
		                                            'autocomplete2', 
		                                            'autocompleteHelper',
		                                            'supportedLocales'));
	}
	
	public function create()
	{
	
		// try to validate the Input
		$v = Customer::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$customer = new Customer();
			
			// prepare geocoding
			$curl     = new \Geocoder\HttpAdapter\SocketHttpAdapter();
			$geocoder = new \Geocoder\Provider\GoogleMapsProvider($curl);
			// get address from input
			$address = Input::get('address');
			// get geocoding result ..
			$geocoded = $geocoder->getGeocodedData($address);
			// can't geocoding the address
			if ($geocoded == '')
			{
				$customer->address = Input::get('address');
				// can geocoding the address .. so take values from response
			} else {
				// populate infos
				$customer->address = $geocoded[0]['streetName'].' , '. $geocoded[0]['streetNumber'];
				$customer->city = $geocoded[0]['city'];
				$customer->postcode = $geocoded[0]['zipcode'];
				$customer->province = $geocoded[0]['countyCode'];
				$customer->country = $geocoded[0]['countryCode'];
			}

			// populate more
			$customer->companyname = Input::get('companyname');
			$customer->sign = Input::get('sign');
			$customer->name = Input::get('name');
			$customer->vat = Input::get('vat');
			$customer->telephone = Input::get('telephone');
			$customer->mobile = Input::get('mobile');
			$customer->email = Input::get('email');
			$customer->language = Input::get('language');
			
			// setConnection
			$customer->setConnection('mysql');
			// save the line(s)
			$customer->save();

			// success message
			Alert::success(trans('messages.New Customer saved'));
		
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
		$customer = Customer::find($id);
		// delete it
		$customer->delete();
		// success message
		Alert::success(trans('messages.Customer deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function delete_delivery($id)
	{
		// get the delivery from ID
		$customer_delivery = CustomerDelivery::find($id);
		// delete it
		$customer_delivery->delete();
		// success message
		Alert::success(trans('messages.Option deleted'));
		// redirect back
		return redirect()->back();
	}
	
	public function edit()
	{
		// try to validate the Input
		$v = Customer::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
				
			// get the customer from ID
			$customer = Customer::find(Input::get('id'));
			// edit the informations
			$customer->name = Input::get('name');
			$customer->sign = Input::get('sign');
			$customer->vat = Input::get('vat');
			
			// prepare geocoding
			$curl     = new \Geocoder\HttpAdapter\SocketHttpAdapter();
			$geocoder = new \Geocoder\Provider\GoogleMapsProvider($curl);
			// get address from input
			$address = Input::get('address');
			// get geocoding result ..
			$geocoded = $geocoder->getGeocodedData($address);
			
			// can't geocoding the address
			if ($geocoded == '')
			{
				$customer->address = Input::get('address');
				// can geocoding the address .. so take values from response
			} else {
				// populate infos
				$customer->address = $geocoded[0]['streetName'].' , '. $geocoded[0]['streetNumber'];
				$customer->city = $geocoded[0]['city'];
				$customer->postcode = $geocoded[0]['zipcode'];
				$customer->province = $geocoded[0]['countyCode'];
				$customer->country = $geocoded[0]['countryCode'];
			}
			
			$customer->telephone = Input::get('telephone');
			$customer->mobile = Input::get('mobile');
			$customer->email = Input::get('email');
			$customer->language = Input::get('language');
			// setConnection -required- for BRAND DB
			$customer->setConnection('mysql');
			// save the line(s)
			$customer->save();

			// success message
			Alert::success(trans('messages.Customer updated'));
		
		// if not ok...
		} else {
			
			// prepare error message composed by validation messages
			$messages = ''; foreach($v->messages()->messages() as $error) { $messages .= $error[0].'<br>'; } Alert::error($messages);
		}
		
		// redirect back
		return redirect()->back();
	}
	
}
