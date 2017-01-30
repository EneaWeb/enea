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

class ItemPrice extends Model
{
    
	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'item_prices';

	protected $fillable = [
		'item_id',
		'season_list_id',
		'price'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

	  	$rules = array(

	  );

	  	$messages = array(
	      //'item_id.required' => trans('x.required-item_prices-item_id'),
	  );

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/
    
	public function item()
	{
	  return $this->belongsTo('\App\Item', 'item_id', 'id');
	}
	
	public function season_list()
	{
		return $this->belongsTo('\App\Season_List', 'season_list_id', 'id');
	}
    
}
