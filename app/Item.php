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
		'barcode',
		'product_id',
		'size_id',
		'color_id'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

	  	$rules = array(
	      'product_id' => 'required',
	      'type' => 'required',
	      'size_id' => 'required',
	      'color_id' => 'required',
	      
	  );

	  	$messages = array(
	      'product_id.required' => trans('validation.required-item-product_id'),
	      'type.required' => trans('validation.required-item-type'),
	      'size_id.required' => trans('validation.required-item-size_id'),
	      'color_id.required' => trans('validation.required-item-color_id'),
	  );

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/
    
	public function product()
	{
	  return $this->belongsTo('\App\Product', 'product_id', 'id');
	}
	
	public function attribute_values()
	{
	  return $this->belongsToMany('\App\AttributeValue');
	}
	
	public function price()
	{
		return $this->hasMany('\App\Price');
	}
	
	public function price_for_list($list_id)
	{
		return \App\ItemPrice::where('item_id', $this->id)->where('season_list_id', $list_id)->first()['price'];
	}
	
	public static function price_from_parameters($season_list_id, $product_id, $size_id, $color_id)
	{
		$item_id = \App\Item::where('product_id', $product_id)->where('color_id', $color_id)->where('size_id', $size_id)->first()['id'];
		if ( ! \App\ItemPrice::where('item_id', $item_id)->where('season_list_id', $season_list_id)->get()->isEmpty() ) 
		{
			$result = \App\ItemPrice::where('item_id', $item_id)->where('season_list_id', $season_list_id)->first()['price'];
			$result = number_format($result);
		} else {
			$result = '';
		}
		
		return $result;
	}

}
