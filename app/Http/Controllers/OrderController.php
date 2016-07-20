<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order as Order;
use \App\OrderDetails as OrderDetails;
use App\Http\Requests;
use Input;
use App;
use Auth;
use Config;
use Session;
use Localization;
use \App\Alert as Alert;
use App\Gestionale\Maps as Maps;
use \App\Customer as Customer;
use \App\Product as Product;
use Ivory\GoogleMap\Helper\MapHelper;
use Ivory\GoogleMap\Places\Autocomplete;
use Ivory\GoogleMap\Places\AutocompleteComponentRestriction;
use Ivory\GoogleMap\Places\AutocompleteType;
use Ivory\GoogleMap\Helper\Places\AutocompleteHelper;
use App\Gestionale\Stats as Stats;

class OrderController extends Controller
{
	public function create()
	{
		// CLEAN previous orders
		if (Session::has('order'))
			Session::forget('order');
		
		// retrieve all customers
		$customers = Customer::all();
		$autocomplete = new Autocomplete();
		$autocomplete->setPrefixJavascriptVariable('place_autocomplete_');
		$autocomplete->setInputId('place_input');
		$autocomplete->setInputAttributes(['class' => 'form-control', 'name'=>'address']);
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
		
		// prepare dropdown with supported Locales
		$configLocales = Config::get('localization.supported-locales');
		$supportedLocales = array();
		foreach ($configLocales as $key => $locale) {
			$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
		}
		
		return view('pages.orders.start', compact('autocomplete', 'autocompleteHelper', 'supportedLocales'));
	}
	
	public function edit($order_id)
	{
		
		$order = \App\Order::find($order_id);
		// if user is not the owner of the order, of is not someone who manage orders
		if ( (!Auth::user()->can('manage orders')) && ($order->user_id != Auth::user()->id) ) {
			Alert::error(trans("messages.You don't have the permission to edit this order"));
			return redirect()->back();
		}
		
		// retrieve all customers
		$customers = Customer::all();
		$autocomplete = new Autocomplete();
		$autocomplete->setPrefixJavascriptVariable('place_autocomplete_');
		$autocomplete->setInputId('place_input');
		$autocomplete->setInputAttributes(['class' => 'form-control', 'name'=>'address']);
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
		
		// prepare dropdown with supported Locales
		$configLocales = Config::get('localization.supported-locales');
		$supportedLocales = array();
		foreach ($configLocales as $key => $locale) {
			$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
		}
		
		$order_image = unserialize(\App\OrderImage::where('order_id', $order_id)->first()['image']);
		Session::put('order', $order_image);
		Session::put('order.edited', $order_id);
		
		return view('pages.orders.start', compact('autocomplete', 'autocompleteHelper', 'supportedLocales'));
	}
	
	public function step2()
	{
		
		// required customer id to go on
		if (!Input::has('id'))
			return redirect()->back();
	
		$autocomplete2 = new Autocomplete();
		$autocomplete2->setPrefixJavascriptVariable('place_autocomplete_');
		$autocomplete2->setInputId('place_input');
		$autocomplete2->setInputAttributes(['class' => 'form-control', 'name'=>'address']);
		//$autocomplete->setValue('aaa');
		$autocomplete2->setTypes(array(AutocompleteType::GEOCODE));
		//$autocomplete->setComponentRestrictions(array(AutocompleteComponentRestriction::COUNTRY => 'fr'));
		$autocomplete2->setBound(45, 9, 45, 9, true, true);
		$autocomplete2->setAsync(false);
		$autocomplete2->setLanguage(Localization::getCurrentLocale());
		if (!App::environment('local')) 
				$autocomplete2->setApiKey(Config::get('general.google_api_key'));
		// render
		$autocompleteHelper = new AutocompleteHelper();
		
		$customer_id = Input::get('id');
		$customer = \App\Customer::find($customer_id);
		
		$noback = true;
		return view('pages.orders.step2', compact( 'customer', 
		                                          'autocomplete2', 
		                                          'autocompleteHelper', 
		                                          'noback'
		                                          ));
		
	}
	
	public function step3()
	{
		
		$products_array = array();
		$qty = 0;
		$subtotal = 0;
		$items_color_grouped = array();
		
		// get active season value
		$active_season = \App\Option::where('name', 'active_season')->first()->value;
		// query all products for active season
		$products = Product::where('season_id', $active_season)->where('active', 1)->orderBy('name', 'desc')->paginate(200);
		
		if (Session::has('order.items')){
			$items = Session::get('order.items');
			$season_list_id = Session::get('order.season_list_id');

			foreach ($items as $k => $v) {
				$item = \App\Item::find($k);
				$product_id = $item->product->id;
				$products_array[$product_id][] = $item->color_id;
				$products_array[$product_id] = array_map("unserialize", array_unique(array_map("serialize", $products_array[$product_id])));
				// get quantity
				$qty += $v;
				// get prices
				$price = \App\ItemPrice::where('item_id', $k)->where('season_list_id', $season_list_id)->first()['price'];
				$subtotal += $price * $v;
			}
		
			// numero di product+color
			$items_color_grouped = 0;
			foreach ($products_array as $a) {
			    $items_color_grouped+= count($a);
			}
		}
		
		
		if (Session::has('order')) {
			// EXHISTING DATA (back button or edited order) ###########	
			if (Input::has('season_list_id'))
				Session::put('order.season_list_id', Input::get('season_list_id'));
			
			if (Input::has('payment_id'))
				Session::put('order.payment_id', Input::get('payment_id'));
				
			if (Input::has('season_delivery_id'))
				Session::put('order.season_delivery_id', Input::get('season_delivery_id'));
			
			if (Input::has('customer_delivery_id'))
				Session::put('order.customer_delivery_id', Input::get('customer_delivery_id'));
		}

		else {
			// NEW ORDER ###########
			
			// CHECK IF SOMETHING IS MISSING //
			$message = '';
			if (!Input::has('season_list_id'))
				$message .= 'Selezione del listino obbligatoria<br>';
			if (!Input::has('payment_id'))
				$message .= 'Metodo di pagamento obbligatorio<br>';
			if (!Input::has('season_delivery_id'))
				$message .= 'Data di consegna obbligatoria<br>';
			if (!Input::has('customer_delivery_id'))
				$message .= "Indirizzo di consegna obbligatorio<br>";
			if ((!Input::has('season_list_id')) || (!Input::has('payment_id')) || (!Input::has('season_delivery_id')) || (!Input::has('customer_delivery_id'))) {
				// throw errors
				Alert::error($message);
				return redirect()->back();
			}
			// Save NEW ORDER inside SESSION
			Session::put('order', Input::all());
		}
		
		// redirect to step 3 => products selection
		return view('pages.orders.step3', compact('products', 'products_array', 'qty', 'items_color_grouped', 'subtotal'));
	}
	
	public function save_line()
	{
		$input = Input::all();
		unset($input['_token']);
		
		// from customizer
		if (Input::has('custom')) {
			unset($input['custom']);
			Session::put('order.custom', Input::get('custom'));
		}
		
		$sum = 0;
		$items = array();
		if (Session::has('order.items')) {
			// per ogni input [id_item => quantita]
			foreach ($input as $key => $val) {
				// se l'item id è già presente in session ..
				if (array_key_exists($key, Session::get('order.items'))) {
					// aggiorno la quantità se non è vuota
					if ($val != '' && $val != 0)
						Session::set('order.items.'.$key, ltrim($val, '0'));
					// la cancello se è vuota
					else 
						Session::forget('order.items.'.$key);
				// se l'item id non è presente in session ..
				} else {
					if ($val != '' && $val != 0)
						$items[$key] = ltrim($val, '0');
				}
				if ($val != '' && $val != 0)
					$items[$key] = ltrim($val, '0');
				// aggiorno la var full_items
				$full_items = Session::get('order.items') + $items;
			}
		} else {
			
			foreach ($input as $key => $val) {
				if ($val != '' && $val != 0)
					$items[$key] = ltrim($val, '0');
			}
			// get items
			if (Session::has('order.items')) {
				$full_items = Session::get('order.items') + $items;
			} else {
				$full_items = $items;
			}
			
		}
		
		// update order.items
		Session::put('order.items', $full_items);
		
		// custom == redirect to products
		if(Input::has('custom'))
			return redirect('/order/new/step3');
		else
			return redirect()->back();
	}
	
	public function step4()
	{
		// must have order items
		if (!Session::has('order.items'))
			return redirect()->back();
		
		// retrieve all
		$items = Session::get('order.items');
		$fullOrder = Session::get('order');
		$customer_delivery_id = Session::get('order.customer_delivery_id');
		$payment_id = Session::get('order.payment_id');
		$season_delivery_id = Session::get('order.season_delivery_id');
		$season_list_id = Session::get('order.season_list_id');
		$customer_id = Session::get('order.customer_id');
		
		$qty = 0;
		$subtotal = 0;
		$total = 0;
		
		$products_array = array();
		$temp_variations = array();
		// calcolo: PEZZI TOTALI (qty) E PREZZO SUBTOTALE (subtotal)
		foreach ($items as $item_id => $quantity) {
			$item = \App\Item::find($item_id);
			// get total pieces
			$qty += $quantity;
			// get prices
			$price = \App\ItemPrice::where('item_id', $item_id)->where('season_list_id', $season_list_id)->first()['price'];
			$subtotal += $price * $quantity;

			// products_arr = PRODUCT_ID=>[ PRODUCT_VARIATION_ID .. PRODUCT_VARIATION_ID .. ]			
			if (!in_array(\App\Item::find($item_id)->product_variation_id, $temp_variations))
				$products_array[\App\Item::find($item_id)->product_id][] = \App\Item::find($item_id)->product_variation_id;
			
			// array temporaneo 
			$temp_variations[] = \App\Item::find($item_id)->product_variation_id;
		}
				
		// calcolo: TOTAL sulla base delle variazioni di prezzo
		// payment variation => discount
		if (\App\Payment::find($payment_id)->action == '-') {
			$total = $subtotal * ((100-\App\Payment::find($payment_id)->amount) / 100);
		// payment variation => increase
		} else if (\App\Payment::find($payment_id)->action == '+') {
			$total = $subtotal * ((100+\App\Payment::find($payment_id)->amount) / 100);
		} else {
			$total = $subtotal;
		}
		
		Session::put('order.subtotal',$subtotal);
		Session::put('order.total', $total);
		Session::put('order.qty', $qty);
		Session::put('order.products_array', $products_array);
					
		return view('pages.orders.step4', compact(
		         'fullOrder',
               'subtotal', 
               'qty', 
               'total'
         	));
	}
	
	public function confirm()
	{
		
		$products_count = 0;
		$edited = FALSE;
		
		foreach (Session::get('order.products_array') as $key => $product) {
		    $products_count += count($product);
		}
		
		// EDITED EXHISTING ORDER ##############
		if (Session::has('order.edited')) {
			
			// store it in a variable
			$edited = TRUE;
			// use exhisting order line
			$order = \App\Order::find(Session::get('order.edited'));
			// delete all order details lines associated to the specified order_id
			foreach (\App\OrderDetail::where('order_id', Session::get('order.edited'))->get() as $order_detail) {
				$order_detail->setConnection(Auth::user()->options->brand_in_use->slug);
				$order_detail->delete();
			}
			// delete order image associated to the specified order_id
			foreach (\App\OrderImage::where('order_id', Session::get('order.edited'))->get() as $order_image) {
				$order_image->setConnection(Auth::user()->options->brand_in_use->slug);
				$order_image->delete();
			}
			
		} else {
		// NEW ORDER ##############
			$order = new \App\Order;
			$order->user_id = Auth::user()->id;
		}
		
		$order->customer_id = Session::get('order.customer_id');
		$order->payment_id = Session::get('order.payment_id');
		$order->payment_amount = \App\Payment::find(Session::get('order.payment_id'))->variation.
											\App\Payment::find(Session::get('order.payment_id'))->amount;
		$order->season_id = \App\Option::where('name', 'active_season')->first()->value;
		$order->season_list_id = Session::get('order.season_list_id');
		$order->customer_delivery_id = Session::get('order.customer_delivery_id');
		$order->products_qty = $products_count;
		$order->items_qty = Session::get('order.qty');
		$order->note = Input::get('note');
		$order->season_delivery_id = Session::get('order.season_delivery_id');
		$order->products_array = serialize(Session::get('order.products_array'));
		
		$count = 0;
		foreach (Session::get('order.items') as $key => $value) {
			$count += $value;
		}
		$order->subtotal = Session::get('order.subtotal');
		$order->total = Session::get('order.total');
		$order->setConnection(Auth::user()->options->brand_in_use->slug);
		$order->save();
		
		$colors_temp = array();
		
		foreach (Session::get('order.items') as $key => $val) {
			$colors_temp[] = \App\Item::find($key)->color_id; // array con colori
			
			$order_detail = new \App\OrderDetail;
			$order_detail->order_id = $order->id;
			$order_detail->product_id = \App\Item::find($key)->product_id;
			$order_detail->product_variation_id = \App\Item::find($key)->product_variation_id;
			$order_detail->item_id = $key;
			$order_detail->qty = $val;
			$order_detail->price = \App\ItemPrice::where('item_id', $key)->where('season_list_id', Session::get('order.season_list_id'))->first()['price'];
			$order_detail->total_price = \App\ItemPrice::where('item_id', $key)->where('season_list_id', Session::get('order.season_list_id'))->first()['price'] * $val;
			$order_detail->setConnection(Auth::user()->options->brand_in_use->slug);
			$order_detail->save();
		}
		
		Session::put('order.order_id', $order->id);
		// salvo la variabile di sessione
		$order_image = new \App\OrderImage;
		$order_image->order_id = $order->id;
		$order_image->image = serialize(Session::get('order'));
		$order_image->setConnection(Auth::user()->options->brand_in_use->slug);
		$order_image->save();
		
		// pulisco la variabile di sessione
		Session::forget('order');
		
		/*
		======= DONT SEND MAIL JUST AFTER SAVING ORDER ========
		if (!App::environment('local'))
			$email_confirmation = \App\EneaMail::order_confirmation($order->id, $edited);
		*/
		
		Alert::success('Ordine salvato correttamente');
		return redirect('/');
	}
	
	public function details($id)
	{
		$order = \App\Order::find($id);
		if ($order->customer_delivery_id == 0)
			$customer_delivery = $order->customer;
		else
			$customer_delivery = \App\CustomerDelivery::find($order->customer_delivery_id);
		$order_details = \App\OrderDetail::where('order_id', $order->id)->get();
		return view('pages.orders.details', compact(
		            'order', 
		            'order_details', 
		            'customer_delivery'
		      ));
	}
	
	public function delete($id)
	{
		$order = \App\Order::find($id);

		// delete all order details
		foreach (\App\OrderDetail::where('order_id', $order->id)->get() as $order_detail) {
			$order_detail->setConnection(Auth::user()->options->brand_in_use->slug);
			$order_detail->delete();
		}
			
		// delete order
		$order->setConnection(Auth::user()->options->brand_in_use->slug);
		$order->delete();
		
		Alert::success('Ordine eliminato correttamente');
		return redirect()->back();

	}
	
	public function send_mail($id)
	{
		if (!App::environment('local'))
			$mail = \App\EneaMail::order_confirmation($id, FALSE);
		
		Alert::success('Mail inviata');
		return redirect()->back();
	}
	
}