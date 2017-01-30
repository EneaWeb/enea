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

class Option extends Model
{
    
	public function __construct()
	{
		$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'options';

	protected $fillable = [
	'name',
	'value'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

		$rules = array(
		   'name' => 'required',
		   'value' => 'required',
		);

		$messages = array(
		   'name.required' => trans('x.required-option-name'),
		   'value.required' => trans('x.required-option-slug'),
		);

		return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

	public static function getOption($name)
	{
		return \App\Option::where('name', $name)->first()->value;
	}

	public static function active_season()
	{
		return \App\Season::find(\App\Option::where('name', 'active_season')->first()->value);
	}

}
