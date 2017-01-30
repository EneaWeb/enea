<?php

/*
==================
    BRAND DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Support\Collection as Collection;
use Auth;

class Size extends Model
{

	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'sizes';

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
		   'name.required' => trans('x.required-size-name'),
		   'slug.required' => trans('x.required-size-slug'),
		);

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/
	
	public static function sizes_for_type(\App\Product $product)
	{
		$sizes = new Collection;
		foreach (\App\Size::all() as $size) {
			$types = unserialize($size->types);
			if (in_array($product->type_id, $types)) {
				$sizes->push($size);
			}
		}
		return $sizes;
	}

}
