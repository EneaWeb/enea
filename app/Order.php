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
        'season_list_id',
        'season_delivery_id',
        'customer_delivery_id',
        'products_qty',
        'items_qty',
        'subtotal',
        'payment_action',
        'payment_amount',
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

}