<?php

/*
==================
    GENERAL DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{

    public function __construct()
	{
		$this->connection = 'mysql';
	}
    
    protected $table = 'role_user';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id'
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
