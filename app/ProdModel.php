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

class ProdModel extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'prodmodels';
    
    protected $fillable = [
    	'slug',
    	'name',
    	'description',
    	'picture',
        'type', // adult / kid / man / woman / male_kid / female_kid / unisex /
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
            'name.required' => trans('validation.required-prodmodel-name'),
            'slug.required' => trans('validation.required-prodmodel-slug'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
    public function season()
    {
        return $this->belongsTo('\App\Season', 'season_id', 'id');
    }
    
    public function type()
    {
        return $this->belongsTo('\App\Type');
    }
    
}
