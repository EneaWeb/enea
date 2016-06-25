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

class Item extends Model
{
    
	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'items';

	protected $fillable = [
		'product_id',
		'product_variation_id',
		'size_id',
		'active'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

	  	$rules = array(
	      'product_id' => 'required',
	      'size_id' => 'required',
	      'active' => 'required',
	  );

	  	$messages = array(
	      'product_id.required' => trans('validation.required-item-product_id'),
	      'size_id.required' => trans('validation.required-item-size_id'),
	      'active.required' => trans('validation.required-item-active'),
	  );

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/
    
	public function product()
	{
	  return $this->belongsTo('\App\Product');
	}
	
	public function product_variation()
	{
		return $this->belongsTo('\App\ProducVariation');
	}
	
	public function price()
	{
		return $this->hasMany('\App\Price');
	}
	
	public function price_for_list($list_id)
	{
		return \App\ItemPrice::where('item_id', $this->id)->where('season_list_id', $list_id)->first()['price'];
	}

}
