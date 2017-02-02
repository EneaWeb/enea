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
		'sign',
		'name',
		'vat',
		'address',
		'city',
		'province',
		'postcode',
		'country',
		'map_x',
		'map_y',
		'telephone',
		'mobile',
		'fax',
		'email',
		'language'
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
		   'language' => 'required',
		   'country' => 'required',
		);

		$messages = array(
		   'companyname.required' => trans('x.required-customer-companyname'),
		   'name.required' => trans('x.required-customer-name'),
		   'address.required' => trans('x.required-customer-address'),
		   'telephone.required' => trans('x.required-customer-telephone'),
		   'email.required' => trans('x.required-customer-email'),
		   'language.required' => trans('x.required-customer-language'),
		   'country.required' => trans('x.required-customer-country'),
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
	
	public function orders()
	{
		return $this->hasMany('\App\Order');
	}
	
    public function brands()
    {
        return $this->belongsToMany('\App\Brand');
    }

    public function log($action)
    {
        $log = new \App\Log;
        $log->product_id = $this->id;
        $log->action = $action;
        $log->save();
    }

}
