<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
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

class CustomerDeliveryController extends Controller
{

	public function create()
	{
	
		// try to validate the Input
		$v = CustomerDelivery::validate(Input::all());
		
		// if everything ok...
		if ( $v->passes() ) {
			
			// create a new instance
			$customer_delivery = new CustomerDelivery();
			
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
				$customer_delivery->address = Input::get('address');
				// can geocoding the address .. so take values from response
			} else {
				// populate infos
				$customer_delivery->address = $geocoded[0]['streetName'].' , '. $geocoded[0]['streetNumber'];
				$customer_delivery->city = $geocoded[0]['city'];
				$customer_delivery->postcode = $geocoded[0]['zipcode'];
				$customer_delivery->province = $geocoded[0]['countyCode'];
				$customer_delivery->country = $geocoded[0]['countryCode'];
			}

			// populate more
			$customer_delivery->customer_id = Input::get('customer_id');
			
			// setConnection
			$customer_delivery->setConnection('mysql');
			// save the line(s)
			$customer_delivery->save();

			// success message
			Alert::success(trans('messages.New Address saved'));
		
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
		$customer_delivery = CustomerDelivery::find($id);
		// delete it
		$customer_delivery->delete();
		// success message
		Alert::success(trans('messages.Customer deleted'));
		// redirect back
		return redirect()->back();
	}
	
}
