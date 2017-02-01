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

class PriceList extends Model
{
    
	public function __construct()
	{
		$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'price_lists';
        
    // id is varchar and not to increment
    public $incrementing = false;

	protected $fillable = [
		'id',
		'name',
        'active'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

		$rules = array(
		   'id' => 'required',
		   'name' => 'required',
		);

		$messages = array(
		   'id.required' => trans('x.required-season_list-id'),
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
            return \App\PriceList::pluck('name', 'id');
		}
		else {
			// get only user price lists
			return Auth::user()->priceLists()->pluck('price_lists.name', 'price_lists.id');
		}
	}

}
