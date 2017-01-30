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
		   'season_id.required' => trans('x.required-season_list-season_id'),
		   'name.required' => trans('x.required-season_list-name'),
		);

		return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

	public static function return_user_lists()
	{
		if(Auth::user()->can('manage brands')) {
			// get all the price lists
			return \App\SeasonList::where('season_id', \App\Option::where('name', 'active_season')->first()->value)->lists('name', 'id');
		}
		else {
			// get only user price lists
			return Auth::user()->season_lists()->where('season_lists.season_id', \App\Option::where('name', 'active_season')->first()->value)->lists('season_lists.name', 'season_lists.id');
		}
	}

}
