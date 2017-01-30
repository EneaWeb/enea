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
		'action', //   '', '+', '-''
				// => nessuno, maggiorazione, sconto
		'amount',
        'days',
		'active'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

		$rules = array(
		   'name' => 'required',
		   'days' => 'required',
		);

		$messages = array(
		   'name.required' => trans('x.required-payment-name'),
		   'days.required' => trans('x.required-payment-days'),
		);

		return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

}
