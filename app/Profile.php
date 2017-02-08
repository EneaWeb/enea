<?php

/*
==================
    GENERAL DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
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
        'user_id', 
        'name',
        'surname',
        'avatar'
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

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
    
    public function name_surname()
    {
        return ucfirst($this->name).' '.ucfirst($this->surname);
    }

    public function picture()
    {
        return 'http://s3.eu-central-1.amazonaws.com/enea-gestionale/users/'.$this->avatar;
    }

    public function avatar()
    {
        return 'http://s3.eu-central-1.amazonaws.com/enea-gestionale/users/'.$this->avatar;
    }

}
