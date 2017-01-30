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

class Variation extends Model
{

	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	protected $table = 'product_variations';

	protected $fillable = [
		'slug',
		'name',
		'description',
		'season_id',
		'active'
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
		   'season_id' => 'required',
		);

		$messages = array(
		   'name.required' => trans('x.required-variation-name'),
		   'slug.required' => trans('x.required-variation-slug'),
		   'season_id.required' => trans('x.required-variation-season_id'),
		);

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

	public function season()
	{
	  return $this->belongsTo('\App\Season');
	}

   public function items()
   {
      return $this->hasMany('\App\Item');
   }

   public static function renderSizes($variation)
   {
        $arr = array();
        foreach ($variation->items as $item) {
            $arr[] = $item->size->name;
        }
        return \App\X::rangeNumbers($arr);
    }

}
