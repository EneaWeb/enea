<?php

/*
==================
    GENERAL DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Auth;

// / all / adult / kid / man / woman / male_kid / female_kid 

class Type extends Model
{

    public function __construct()
	{
		$this->connection = 'mysql';
	}

	protected $table = 'types';

	protected $fillable = [
		'slug',
		'description',
		'active'
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	public static function validate( $input ) {

	  	$rules = array(
	      'slug' => 'required',
	  	);

	  	$messages = array(
	      	'slug.required' => trans('x.required-type-slug'),
	  	);

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/

}
