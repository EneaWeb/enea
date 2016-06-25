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

class OrderDetail extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'order_details';
    
    protected $fillable = [
        'order_id',
        'product_id',
        'variation_id',
        'item_id',
        'qty',
        'price',
        'total_price'
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'order_id' => 'required',
            'item_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'total_price' => 'required',
        );

        $messages = array(
            'order_id.required' => trans('validation.required-order_detail-order_id'),
            'item_id.required' => trans('validation.required-order_detail-item_id'),
            'qty.required' => trans('validation.required-order_detail-qty'),
            'price.required' => trans('validation.required-order_detail-price'),
            'total_price.required' => trans('validation.required-order_detail-total_price'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
	/**
	* Relations
	*/

	public function order()
	{
		return $this->belongsTo('\App\Order');
	}

}