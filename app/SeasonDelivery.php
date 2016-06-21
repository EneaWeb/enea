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

class SeasonDelivery extends Model
{
    
	public function __construct()
	{
		$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'season_deliveries';

	protected $fillable = [
		'season_id',
		'slug',
		'name',
		'date'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

		$rules = array(
		   'season_id' => 'required',
		   'name' => 'required',
		);

		$messages = array(
		   'season_id.required' => trans('validation.required-season_delivery-season_id'),
		   'name.required' => trans('validation.required-season_delivery-name'),
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
