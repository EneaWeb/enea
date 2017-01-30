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

class OrderImage extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    
    protected $table = 'order_image';
    
    protected $fillable = [
        'order_id',
        'image'
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'order_id' => 'required',
            'image' => 'required',
        );

        $messages = array(
            'order_id.required' => trans('x.required-order_image-order_id'),
            'image.required' => trans('x.required-order_image-image'),
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