<?php

/*
==================
    GENERAL DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
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

    public function users()
    {
        return $this->belongsToMany('\App\User');
    }
    
    public function customers()
    {
        return $this->belongsToMany('\App\Customer');
    }
}
