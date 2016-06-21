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
	protected $table = 'variations';

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
		   'name.required' => trans('validation.required-variation-name'),
		   'slug.required' => trans('validation.required-variation-slug'),
		   'season_id.required' => trans('validation.required-variation-season_id'),
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

}
