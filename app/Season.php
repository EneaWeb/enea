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

class Season extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'seasons';
    
    protected $fillable = [
    	'slug',
    	'name',
    	'description',
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
        );

        $messages = array(
            'name.required' => trans('validation.required-season-name'),
            'slug.required' => trans('validation.required-season-slug'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
    public function season_deliveries()
    {
        return $this->hasMany('\App\SeasonDelivery');
    }
    
    public function season_lists()
    {
        return $this->hasMany('\App\SeasonList');
    }

}
