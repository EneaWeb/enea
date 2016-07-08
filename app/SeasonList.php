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

class SeasonList extends Model
{
    
	public function __construct()
	{
		$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'season_lists';

	protected $fillable = [
		'season_id',
		'slug',
		'name'
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
		   'season_id.required' => trans('validation.required-season_list-season_id'),
		   'name.required' => trans('validation.required-season_list-name'),
		);

		return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

	public static function return_user_lists()
	{
		
	}

}
