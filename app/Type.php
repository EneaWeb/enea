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

 // adult / kid / man / woman / male_kid / female_kid / unisex /

class Type extends Model
{
    
	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'types';

	protected $fillable = [
		'name',
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
	      	'name.required' => trans('validation.required-type-name'),
	  	);

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

}
