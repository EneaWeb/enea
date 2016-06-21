<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order as Order;
use \App\OrderDetails as OrderDetails;
use App\Http\Requests;
use Input;
use Auth;
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
		
		
		$user = Auth::user();
		$orders = Order::all();

		if ($user->can('manage brands')) {
			$mapHelper = new MapHelper;
			$map = Maps::orders_map();
			return view('dashboard.admin', compact('map', 'mapHelper', 'orders'));
			
		} else {
			
			// retrieve all customers
			$customers = Customer::all();
			
			$autocomplete = new Autocomplete();

			$autocomplete->setPrefixJavascriptVariable('place_autocomplete_');
			$autocomplete->setInputId('place_input');

			$autocomplete->setInputAttributes(array('class' => 'my-class'));
			$autocomplete->setInputAttribute('name', 'address');
			$autocomplete->setInputAttribute('class', 'form-control');

			//$autocomplete->setValue('aaa');

			$autocomplete->setTypes(array(AutocompleteType::GEOCODE));
			//$autocomplete->setComponentRestrictions(array(AutocompleteComponentRestriction::COUNTRY => 'fr'));
			$autocomplete->setBound(45, 9, 45, 9, true, true);

			$autocomplete->setAsync(false);
			$autocomplete->setLanguage(Localization::getCurrentLocale());
			
			// render
			$autocompleteHelper = new AutocompleteHelper();
			
			
			return view('pages.orders.start', compact('autocomplete', 'autocompleteHelper'));
		}
	}
	
	public function step2()
	{
		// required customer id to go on
		if (!Input::has('id'))
			return redirect()->back();
		
			
			$autocomplete = new Autocomplete();

			$autocomplete->setPrefixJavascriptVariable('place_autocomplete_');
			$autocomplete->setInputId('place_input');

			$autocomplete->setInputAttributes(array('class' => 'my-class'));
			$autocomplete->setInputAttribute('name', 'address');
			$autocomplete->setInputAttribute('class', 'form-control');

			//$autocomplete->setValue('aaa');

			$autocomplete->setTypes(array(AutocompleteType::GEOCODE));
			//$autocomplete->setComponentRestrictions(array(AutocompleteComponentRestriction::COUNTRY => 'fr'));
			$autocomplete->setBound(45, 9, 45, 9, true, true);

			$autocomplete->setAsync(false);
			$autocomplete->setLanguage(Localization::getCurrentLocale());
			
			// render
			$autocompleteHelper = new AutocompleteHelper();
		
		$customer_id = Input::get('id');
		$customer = \App\Customer::find($customer_id);
		
		return view('pages.orders.step2', compact('customer','autocomplete', 'autocompleteHelper'));
		
	}
	
	public function step3()
	{
		
		// get active season value
		$active_season = \App\Option::where('name', 'active_season')->first()->value;
		// query all products for active season
		$products = Product::where('season_id', $active_season)->where('active', 1)->orderBy('name')->paginate(28);
		
		// se questo passaggio è stato fatto, 
		// apro direttamente la view
		if (Session::has('order'))
			return view('pages.orders.step3', compact('products'));
		
		// check if everything was selected
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
		
		// store data in a session variable 'order'
		Session::put('order', Input::all());
		
		return view('pages.orders.step3', compact('products'));
	}
	
	public function save_line()
	{
		$input = Input::all();
		unset($input['_token']);
		$sum = 0;
		$items = array();
		if (Session::has('order.items')) {
			// per ogni input [id_item => quantita]
			foreach ($input as $key => $val) {
				// se l'item id è già presente in session ..
				if (array_key_exists($key, Session::get('order.items'))) {
					// aggiorno la quantità se non è vuota
					if ($val != '' && $val != 0)
						Session::set('order.items.'.$key, $val);
					// la cancello se è vuota
					else 
						Session::forget('order.items.'.$key);
				// se l'item id non è presente in session ..
				} else {
					if ($val != '' && $val != 0)
						$items[$key] = $val;
				}
				if ($val != '' && $val != 0)
					$items[$key] = $val;
				// aggiorno la var full_items
				$full_items = Session::get('order.items') + $items;
			}
		} else {
			
			foreach ($input as $key => $val) {
				if ($val != '' && $val != 0)
					$items[$key] = $val;
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
		
		$products_array = array();
		$qty = 0;
		$subtotal = 0;
		$variation = 0;
		$total = 0;
		
		foreach ($items as $k => $v) {
			$item = \App\Item::find($k);
			$product_id = $item->product->id;			
			$products_array[] = ['product_id' => $product_id , 'color_id' => $item->color_id];
			// get quantity
			$qty += $v;
			// get prices
			$price = \App\ItemPrice::where('item_id', $k)->where('season_list_id', $season_list_id)->first()->price;
			$subtotal += $price * $v;
		}
		
		// payment variation => discount
		if (\App\Payment::find($payment_id)->action == 'discount') {
			$total = $subtotal * ((100-\App\Payment::find($payment_id)->amount) / 100);
		// payment variation => increase
		} else if (\App\Payment::find($payment_id)->action == 'increase') {
			$total = $subtotal * ((100+\App\Payment::find($payment_id)->amount) / 100);
		} else {
			$total = $subtotal;
		}
		
		Session::put('order.subtotal',$subtotal);
		Session::put('order.total', $total);
		
		return view('pages.orders.step4', compact(
               'fullOrder', 
               'products_array', 
               'subtotal', 
               'qty', 
               'total'
         	));
	}
	
	public function confirm()
	{
		
		$order = new \App\Order;
		$order->user_id = Auth::user()->id;
		$order->customer_id = Session::get('order.customer_id');
		$order->season_id = \App\Option::where('name', 'active_season')->first()->value;
		$order->season_list_id = Session::get('order.season_list_id');
		$order->note = Input::get('note');
		$order->season_delivery_id = Session::get('order.season_delivery_id');
		$order->active = 1;
		
		$count = 0;
		foreach (Session::get('order.items') as $key => $value) {
			$count += $value;
		}
		$order->qty = $count;
		$order->discount = \App\Payment::find(Session::get('order.payment_id'))->amount;
		$order->subtotal = Session::get('order.subtotal');
		$order->total = Session::get('order.total');
		$order->setConnection(Auth::user()->options->brand_in_use->slug);
		$order->save();
		
		foreach (Session::get('order.items') as $key => $val) {
			$order_detail = new \App\OrderDetail;
			$order_detail->order_id = $order->id;
			$order_detail->item_id = $key;
			$order_detail->qty = $val;
			$order_detail->price = \App\ItemPrice::where('item_id', $key)->where('season_list_id', Session::get('order.season_list_id'))->first()->price;
			$order_detail->total_price = \App\ItemPrice::where('item_id', $key)->where('season_list_id', Session::get('order.season_list_id'))->first()->price * $val;
			$order_detail->setConnection(Auth::user()->options->brand_in_use->slug);
			$order_detail->save();
		}
		
		// pulisci la variabile di sessione
		Session::forget('order');
		Alert::success('Ordine salvato correttamente');
		return redirect('/');
	}
	
}