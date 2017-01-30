<?php

/*
==================
    GENERAL DB
==================
*/

namespace App;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Auth;

class CustomerDelivery extends Model
{
    
	public function __construct()
	{
		$this->connection = 'mysql';
	}
	protected $table = 'customer_deliveries';

	protected $fillable = [
		'customer_id',
		'address',
		'receiver',
		'city',
		'province',
		'postcode',
		'country',
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

		$rules = array(
		   'customer_id' => 'required',
		   'address' => 'required',
		);

		$messages = array(
		   'customer_id.required' => trans('x.required-customer_delivery-customer_id'),
		   'address.required' => trans('x.required-customer_delivery-address'),
		);

		return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/
	
	public function customer()
	{
		$this->belongsTo('\App\Customer');
	}

}
