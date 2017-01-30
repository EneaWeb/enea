<?php

/*
==================
    GENERAL DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOption extends Model
{

	public function __construct()
	{
		$this->connection = 'mysql';
	}
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active_brand',
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
    
    public function brand_in_use()
    {
    	return $this->belongsTo('\App\Brand', 'active_brand', 'id');
    }

    public function type_in_use()
    {
        return $this->belongsTo('\App\Type', 'active_type', 'id');
    }
}
