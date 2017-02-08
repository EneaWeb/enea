<?php

/*
==================
    GENERAL DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandCustomer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function __construct()
	{
		$this->connection = 'mysql';
	}

    protected $fillable = [
        'brand_id',
        'customer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    
    ];
    
    /**
     * Relations
     */

}
