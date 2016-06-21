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

class Payment extends Model
{
    
	public function __construct()
	{
		$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'payments';

	protected $fillable = [
		'slug',
		'name',
		'description',
		'active',
		'action', //   none, increase, discount
					// => nessuno, maggiorazione, sconto
		'amount'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

		$rules = array(
		   'name' => 'required'
		);

		$messages = array(
		   'name.required' => trans('validation.required-payment-name'),
		);

		return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

}
