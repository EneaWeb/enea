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
        'note',
        'season_delivery_id',
        'active',
        'items',
        'qty',
        'discount',
        'price',
        'subtotal',
        'total'
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'name' => 'required',
        );

        $messages = array(
            'name.required' => trans('validation.required-season-name'),
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
	
	public function oreder_details()
	{
		return $this->hasMany('\App\OrderDetail');
	}

}