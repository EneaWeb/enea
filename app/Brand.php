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

    public function __construct()
	{
		$this->connection = 'mysql';
	}

    protected $fillable = [
        'slug',
        'name',
        'companyname',
        'website',
        'description',
        'logo',
        'address',
        'postcode',
        'city',
        'province',
        'country',
        'vat',
        'bank_name',
        'bank_IBAN',
        'bank_SWIFT',
        'email',
        'telephone',
        'confirmation_email',
        'active',
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
        return $this->belongsToMany('\App\Customer')->orderBy('companyname');
    }

    public function picture()
    {
        return 'http://s3.eu-central-1.amazonaws.com/enea-gestionale/brands/'.$this->logo;
    }

    public function logo()
    {
        return 'http://s3.eu-central-1.amazonaws.com/enea-gestionale/brands/'.$this->logo;
    }


}
