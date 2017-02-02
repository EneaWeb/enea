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

class Log extends Model
{
    
	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
    
	protected $table = 'logs';

	protected $fillable = [
        'product_id',
        'customer_id',
        'order_id',
        'action' // type of actions: C - U - D
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	/**
	* Relations
	*/

	/**
	* Other methods
	*/

}
