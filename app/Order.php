<?php

/*
==================
    BRAND DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Auth;
use Session;
use Cart;
use X;

class Order extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    
    protected $table = 'orders';
    

    protected $fillable = [
        'user_id',
        'customer_id',
        'season_id',
        'price_list_id',
        'season_delivery_id',
        'customer_delivery_id',
        'products_qty',
        'items_qty',
        'subtotal',
        'payment_id',
        'payment_action',
        'payment_amount',
        'note',
        'total',
        'products_array'
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            
        );

        $messages = array(
            
        );

        return Validator::make($input, $rules, $messages);
    }
    
	/**
	* Relations
	*/

	public function user()
	{
		return $this->belongsTo('\App\User');
	}
    
    public function customer()
    {
        return $this->belongsTo('\App\Customer');
    }
    
    public function image()
    {
        return $this->belongsTo('\App\OrderImage');
    }
	
	public function order_details()
	{
		return $this->hasMany('\App\OrderDetail');
	}

	public function details()
	{
		return $this->hasMany('\App\OrderDetail');
	}
    
    public function order_items()
    {
        return $this->hasMany('\App\OrderDetail');
    }
    
    public function payment()
    {
        return $this->belongsTo('\App\Payment');
    }
    
    public function season_delivery()
    {
        return $this->belongsTo('\App\SeasonDelivery');
    }
    
    public function customer_delivery()
    {
        return $this->belongsTo('\App\CustomerDelivery');
    }

    public function log($action)
    {
        $log = new \App\Log;
        $log->order_id = $this->id;
        $log->action = $action;
        $log->save();
    }

    /*
    *
    Session::get('cart.options') = array (
        'customer_id',
        'price_list_id',
        'season_delivery_id',
        'customer_delivery_id',
        'payment_id'
    );
    *
    */

    // options can be an array ['key' => $val] as a single parameter,
    // or two parameters, as $key, $val

    public static function getOption($optionName)
    {
        return Session::has('cart.options.'.$optionName) ? Session::get('cart.options.'.$optionName) : '';
    }

    public static function setOptions($key, $val=NULL) // array
    {
        if (is_array($key)) {
            foreach ($key as $k => $val) {
                Session::put('cart.options.'.$k, $val);
            }
        } else {
            Session::put('cart.options.'.$key, $val);
        }
        return true;
    }

    public function saveOptions()
    {
        $options = Session::get('cart.options');
        $payment = \App\Payment::find($options['payment_id']);

        $this->user_id = Auth::user()->id;
        $this->customer_id = $options['customer_id'];
        $this->season_id = X::activeSeason();
        $this->price_list_id = $options['price_list_id'];
        $this->season_delivery_id = $options['season_delivery_id'];
        $this->customer_delivery_id = $options['customer_delivery_id'];
        $this->products_qty = '000'; // is it useful or not?
        $this->items_qty = Cart::count();
        $this->subtotal = number_format(Cart::instance('agent')->total(), 2, '.','');
        $this->payment_id = $payment->id;
        $this->payment_action = $payment->action;
        $this->payment_amount = $payment->amount;
        $this->total = X::calculateTotal($payment->action, $payment->amount, number_format(Cart::instance('agent')->total(), 2, '.',''));
        $this->products_array = serialize(Session::get('cart'));
        $this->setConnection(Auth::user()->options->brand_in_use->slug);  
        $this->save();

        return true;
    }

    public static function renderOrderInfos()
    {
        // if we have a payment option
        if (Session::has('cart.options.payment_id')) {
            $payment = \App\Payment::find(Session::get('cart.options.payment_id'));
            $total = X::calculateTotal($payment->action, $payment->amount, number_format(Cart::instance('agent')->total(), 2, '.',''));
        } else {
            $total = Cart::instance('agent')->total();
        }

        if (X::isOrderInProgress()) {
            $msg = '';
            $msg .= '<b>'.\App\Customer::find(Session::get('cart.options.customer_id'))->companyname.'</b>';
            $msg .= ' | ';
            $msg .= 'tot: <b>'.X::prettyPrice($total).'</b>';
            $msg .= ' | ';
            $msg .= 'pz: <b>'.Cart::instance('agent')->count().'</b>';
            return $msg;
        }
    }

    /*
        reorderCart() returns:
        {product_id} 
            => {variation_id} 
                => array( {item_id} => {qty} )
    */

    public static function reorderCart()
    {
        $cartContent = Cart::instance('agent')->content();
        $productsArray = array();
        $variationsArray = array();

        foreach ($cartContent as $line) {
            $item = \App\Item::find($line->id);
            $variation_id = $item->variation_id;
            $product_id = $item->product_id;
            //$productsArray[$product_id][$variation_id][] = [$line->id => $line->qty];
            $productsArray[$variation_id][$line->id] = $line->qty;            
        }

        return $productsArray;
    }

}

