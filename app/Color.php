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

class Color extends Model
{

	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'colors';

	protected $fillable = [
		'slug',
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
		   'slug' => 'required',
		);

		$messages = array(
		   'name.required' => trans('validation.required-color-name'),
		   'slug.required' => trans('validation.required-color-slug'),
		);

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

}
