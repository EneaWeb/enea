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
		
		$map = new Map();

		$map->setPrefixJavascriptVariable('map_');
		$map->setHtmlContainerId('map_canvas');

		$map->setAsync(true);
		$map->setAutoZoom(false);

		$map->setCenter(47, 20, true);
		$map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);
		
		$map->setLanguage(Localization::getCurrentLocale());

		$map->setMapOptions(array(
			'zoom'						=> 4,
			'mapTypeId'					=> 'hybrid', // hybrid, roadmap, satellite, terrain
			'disableDefaultUI'       	=> true,
			'disableDoubleClickZoom' 	=> true,
		));

		$map->setStylesheetOptions(array(
			'width'  => '100%',
			'height' => '100%',
		));

		/* 
		* -----------------
		* INSTANCIATE MARKERS
		* -----------------
		*/
		
		$markerCluster = $map->getMarkerCluster();
		$map->setMarkerCluster($markerCluster);

		$type = $markerCluster->getType();
		$markers = $markerCluster->getMarkers();
		$options = $markerCluster->getOptions();
		
		$markerCluster->setType(MarkerCluster::_DEFAULT);
		$markerCluster->setType('default');
		
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

		
		return $map;
	}
	
}