<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Order as Order;
use \App\OrderDetails as OrderDetails;
use App\Http\Requests;
use Input;
use App;
use X;
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
use Cart;

class OrderController extends Controller
{
	public function step1_customer()
	{

		// prepare dropdown with supported Locales
		$configLocales = Config::get('localization.supported-locales');
		$supportedLocales = array();
		foreach ($configLocales as $key => $locale) {
			$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
		}

        // retrieve all brand customers
		$customers = X::brandInUseCustomers();
        // return view step1
		return view('pages.orders.step1_customer', compact('autocomplete', 'autocompleteHelper', 'supportedLocales'));
	}
	
	public function step2_options(Request $request)
	{
        // check if customer_id was setted
        if (!$request->has('customer_id') && !Session::has('cart.options.customer_id'))
            return redirect('/orders/new/step1');
        
        // get customer object
        if (Session::has('cart.options.customer_id'))
            $customer = \App\Customer::find(Session::get('cart.options.customer_id'));
        else
            $customer = \App\Customer::find($request->get('customer_id'));

        // set option customer_id
        if ($request->get('customer_id') !== NULL)
		    Order::setOptions( 'customer_id', $request->get('customer_id') );

		// prepare dropdown with supported Locales
		$configLocales = Config::get('localization.supported-locales');
		$supportedLocales = array();
		foreach ($configLocales as $key => $locale) {
			$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
		}

        // return view step2
        return view('pages.orders.step2_options', compact('supportedLocales', 'customer'));
	}
	
	public function step3_products(Request $request)
	{
		/* In request there should be 4 values : 

            - "customer_delivery_id"
            - "payment_id"
            - "price_list_id"
            - "season_delivery_id"

        */

        // if order has not the 5 values it needs here
        if ( !(Session::has('cart.options.customer_id') && 
            Session::has('cart.options.customer_delivery_id') && 
            Session::has('cart.options.price_list_id') && 
            Session::has('cart.options.payment_id') &&
            Session::has('cart.options.season_delivery_id') ) ) {

                // count if $_GET request has 4 values
                if (count($request->all()) !== 4)
                    return redirect()->back();

                // check if one of the values is NULL
                foreach ($request->all() as $k => $v) {
                    if ($v == "null")
                        return redirect('/orders/new/step2');
                }
            }

        // check if Price List is the same as before
        if (Order::getOption('price_list_id') !== $request->get('price_list_id')) {
            // need to update all the prices
            if ($request->get('price_list_id') !== NULL && $request->get('price_list_id') !== '')
            X::cartRefreshPrices($request->get('price_list_id'));
        }

        // set remaining options to session
		Order::setOptions( $request->all() );

		// get active season value
		$active_season = X::activeSeason();
		// query all products for active season
		$type_id = Auth::user()->options->active_type;

		if (Input::has('active')) {
			$products = Product::where('season_id', $active_season)
								->where('active', Input::get('active'))
								->orderBy('type_id', 'asc')
								->orderBy('name', 'asc')
								->get();
		} else {
			$products = Product::where('season_id', $active_season)
								->where('active', 1)
								->orderBy('type_id', 'asc')
								->orderBy('name', 'asc')
								->get();
		}

        // set List variable
        $list = FALSE;
        $fast = FALSE;

        // if List is requested, set $list var to TRUE
        if ($request->has('show') && $request->get('show') == 'list')
            $list = TRUE;

        if ($request->has('show') && $request->get('show') == 'fast')
            $fast = TRUE;

		// redirect to step 3 => products selection
		return view('pages.orders.step3_products', compact('products', 'list', 'fast'));
	}

    public function save_line(Request $request)
    {

        // clean $_POST data
        unset($request['_token']); 
        //$items_qty = (array_filter($request->all()));
        $items_qty = ($request->all());
        
        // var $items_qty = [ {itemId} => {itemQty} ]
        // loop through $items_qty data
        foreach ($items_qty as $itemId => $qty) {
            // add to Cart ( id, name, qty, price )
            X::addToCart( $itemId, $qty);
        }

        return Order::renderOrderInfos();
    }

    public function save_fast(Request $request)
    {

        // clean $_POST data
        unset($request['_token']); 
        unset($request['fast-type']); 
        unset($request['fast-products']); 
        unset($request['fast-variations']); 
        
        //$items_qty = (array_filter($request->all()));
        $items_qty = ($request->all());
        
        // var $items_qty = [ {itemId} => {itemQty} ]
        // loop through $items_qty data
        foreach ($items_qty as $itemId => $qty) {
            // add to Cart ( id, name, qty, price )
            X::addToCart( $itemId, $qty);
        }

        return Order::renderOrderInfos();
    }
	
	public function step4_confirm()
	{
		// prepare dropdown with supported Locales
		$configLocales = Config::get('localization.supported-locales');
		$supportedLocales = array();
		foreach ($configLocales as $key => $locale) {
			$supportedLocales[$locale] = Config::get('localization.locales.'.$locale.'.native');
		}

        $brand = X::brandInUse();
        $customer = \App\Customer::find(Order::getOption('customer_id'));
        if (\App\Order::getOption('customer_delivery_id') == '0')
            $delivery = $customer;
        else
            $delivery = \App\CustomerDelivery::find(Order::getOption('customer_delivery_id'));
        $payment = \App\Payment::find(\App\Order::getOption('payment_id'));

        return view('pages.orders.step4_confirm', compact('supportedLocales', 'brand', 'customer', 'delivery', 'payment'));

	}

    public function confirm_and_save(Request $request)
    {

        // check if there are almost 1 product in Session
        if (Cart::instance('agent')->count() < 1) {
            // throw error alert
            Alert::error('x.You can\'t confirm an order without products');
            // return to '/orders/new' page
            return redirect('/orders/new');
        }

        // if order is edited ... get original Order object
        if (Session::has('cart.options.order_id')) {
            $order = \App\Order::find(Session::get('cart.options.order_id'));
            $order->log('U');
        // if is new order, instanciate Order
        } else {
            $order = new \App\Order;
            $order->log('C');
        }

        $order->note = $request->get('note');   
        // see saveOptions() method of \App\Order class
        $order->saveOptions();

        // if order is edited.. 
        if (Session::has('cart.options.order_id')) {
            // remove all previous order details
           \App\OrderDetail::where('order_id', $order->id)->delete();
        }

        // save new order details
        foreach (Cart::instance('agent')->content() as $row) {
            // create orderDetail instance
            $detail = new \App\OrderDetail;
            // get Item instance
            $item = \App\Item::find($row->id);
            // save data
            $detail->order_id = $order->id;
            $detail->product_id = $item->product_id;
            $detail->variation_id = $item->variation_id;
            $detail->item_id = $row->id;
            $detail->qty = $row->qty;
            $detail->price = $row->price;
            $detail->total_price = (int)$row->qty * $row->price;
            $detail->setConnection(Auth::user()->options->brand_in_use->slug);  
            $detail->save();
        }

        Session::forget('cart');

        Alert::success(trans('x.Order correctly saved'));
        return redirect('/');
    }

    public function edit($id)
    {
        // get Order instance
        $order = \App\Order::find($id);
        // restore Session
        Session::put('cart', unserialize($order->products_array));
        Session::put('cart.options.order_id', $id);

        return redirect('/orders/new');
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
		\App\OrderDetail::where('order_id', $order->id)->delete();
			
		// delete order
		$order->setConnection(Auth::user()->options->brand_in_use->slug);
		$order->delete();
		
		Alert::success('Ordine eliminato correttamente');
		return redirect('/');

	}
	
	public function send_mail($id)
	{
		if (!App::environment('local'))
			$mail = \App\EneaMail::order_confirmation($id, FALSE);
		
		Alert::success('Mail inviata');
		return redirect()->back();
	}

	public function modalEdit(Request $request)
	{
		$order = \App\Order::find($request->get('order_id'));
		return view('modals.orders.edit', compact('order'));
	}

    public function clearSessionOrder()
    {
        Session::forget('cart');
        Alert::success(trans('x.Session clear'));
        return redirect('/');
    }
	
}