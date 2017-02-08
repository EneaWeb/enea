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
use Session;

class Item extends Model
{
    
	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'items';

	protected $fillable = [
		'product_id',
		'variation_id',
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
	      'product_id.required' => trans('x.required-item-product_id'),
	      'size_id.required' => trans('x.required-item-size_id'),
	      'active.required' => trans('x.required-item-active'),
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
	
	public function variation()
	{
		return $this->belongsTo('\App\Variation');
	}
	
	public function prices()
	{
		return $this->hasMany('\App\ItemPrice');
	}
	
	public function size()
	{
		return $this->belongsTo('\App\Size');
	}
	
	public function priceForOrderList()
	{
		return \App\ItemPrice::where('item_id', $this->id)->where('price_list_id', Session::get('cart.options.price_list_id'))->value('price');
	}

	public function priceForList($price_list_id)
	{
		return \App\ItemPrice::where('item_id', $this->id)->where('price_list_id', $price_list_id)->value('price');
	}

}
