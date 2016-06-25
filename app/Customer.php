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

class Customer extends Model
{
    
	public function __construct()
	{
		$this->connection = 'mysql';
	}
	protected $table = 'customers';

	protected $fillable = [
		'companyname',
		'name',
		'address',
		'sign',
		'telephone',
		'email',
		'city',
		'province',
		'postcode',
		'country',
		'mobile',
		'fax',
		'email',
		'vat'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

		$rules = array(
		   'companyname' => 'required',
		   'name' => 'required',
		   'address' => 'required',
		   'telephone' => 'required',
		   'email' => 'required',
		);

		$messages = array(
		   'companyname.required' => trans('validation.required-customer-companyname'),
		   'name.required' => trans('validation.required-customer-name'),
		   'address.required' => trans('validation.required-customer-address'),
		   'telephone.required' => trans('validation.required-customer-telephone'),
		   'email.required' => trans('validation.required-customer-email'),
		);

		return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/
	
	public function deliveries()
	{
		return $this->hasMany('\App\CustomerDelivery');
	}

}
