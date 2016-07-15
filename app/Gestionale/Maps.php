<?php

namespace App\Gestionale;
use Session;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;
use Localization;
use Config;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Circle;
use Ivory\GoogleMap\Overlays\MarkerCluster;
use Ivory\GoogleMap\Services\Geocoding\Geocoder;
use Ivory\GoogleMap\Services\Geocoding\GeocoderProvider;
use Geocoder\HttpAdapter\CurlHttpAdapter;

class Maps
{

	public static function orders_map()
	{
		
		/* 
		* -----------------
		* INSTANCIATE A MAP
		* -----------------
		*/
		
		// create Map
		
		$map = new Map();

		$map->setLibraries(array('places'));
		$map->setApiKey(Config::get('general.google_api_key'));
		$map->setPrefixJavascriptVariable('map_');
		$map->setHtmlContainerId('map_canvas');
		$map->setAsync(false);
		$map->setAutoZoom(false);
		$map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);
		$map->setLanguage(Localization::getCurrentLocale());
		$map->setMapOptions(array(
			'zoom'						=> 2,
			'mapTypeId'					=> 'roadmap', // hybrid, roadmap, satellite, terrain
			'disableDefaultUI'       	=> false,
			'disableDoubleClickZoom' 	=> true,
		));

		$map->setStylesheetOptions(array(
			'width'  => '100%',
			'height' => '340px',
		));
			
		// initilize geolocation
		$geocoder = new Geocoder();
		$geocoder->registerProviders(array(
			new GeocoderProvider(new CurlHttpAdapter())
		));
		
		$orders = \App\Order::all();
		foreach ($orders as $order) {
			$customer = $order->customer;
			$address = $customer->address.' '.$customer->postcode.' '.$customer->city.' '.$customer->country;
			// Geocode a location
			$response = $geocoder->geocode($address);
			if (!empty($response->getResults()))
			{
				// position found..
				// so set position as true and get it!
				$result = $response->getResults()[0];
				$location = $result->getGeometry()->getLocation();
				// Create a marker
				$marker = new Marker();
				// Position the marker
				$marker->setPosition($location);
				// Add the marker to the map
				$map->addMarker($marker);
			}
		}
		
		$base_geocoder = new Geocoder();
		$base_geocoder->registerProviders(array(
			new GeocoderProvider(new CurlHttpAdapter())
		));
		$base_response = $base_geocoder->geocode('Duomo di Milano, Piazza del Duomo, Milano, MI');
		$base_result = $base_response->getResults()[0];
		$base_location = $base_result->getGeometry()->getLocation();
		$map->setCenter($base_location);
		
		return $map;
	}
	
	public static function customer_position_map($address)
	{
		// create Map
		
		$map = new Map();

		$map->setLibraries(array('places'));
		$map->setApiKey(Config::get('general.google_api_key'));
		$map->setPrefixJavascriptVariable('map_');
		$map->setHtmlContainerId('map_canvas');
		$map->setAsync(false);
		$map->setAutoZoom(false);
		$map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);
		$map->setLanguage(Localization::getCurrentLocale());
		$map->setMapOptions(array(
			'zoom'						=> 15,
			'mapTypeId'					=> 'roadmap', // hybrid, roadmap, satellite, terrain
			'disableDefaultUI'       	=> false,
			'disableDoubleClickZoom' 	=> true,
		));

		$map->setStylesheetOptions(array(
			'width'  => '100%',
			'height' => '300px',
		));
				
		// initilize geolocation
		$geocoder = new Geocoder();
		$geocoder->registerProviders(array(
			new GeocoderProvider(new CurlHttpAdapter())
		));
		// Geocode a location
		$response = $geocoder->geocode($address);
		
		if (!empty($response->getResults()))
		{
			// position found..
			// so set position as true and get it!
			$result = $response->getResults()[0];
			$location = $result->getGeometry()->getLocation();
			// Create a marker
			$marker = new Marker();
			// Position the marker
			$marker->setPosition($location);
			// Add the marker to the map
			$map->addMarker($marker);
			// Center the map on the new marker
			$map->setCenter($location);
		}
		
		return $map;
	}
	
	public static function test_position($address)
	{
		// initilize geolocation
		$geocoder = new Geocoder();
		$geocoder->registerProviders(array(
			new GeocoderProvider(new CurlHttpAdapter())
		));
		// Geocode a location
		$response = $geocoder->geocode($address);
		
		if (empty($response->getResults()))
		{
			return false;
		} else {
			return true;
		}
	}
	
}