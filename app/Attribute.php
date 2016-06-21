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

class Attribute extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'attributes';
    
    protected $fillable = [
    	'slug',
    	'name',
    	'description',
    	'picture'
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
            'name.required' => trans('validation.required-attribute-name'),
            'slug.required' => trans('validation.required-attribute-slug'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
    public function attribute_values()
    {
        return $this->hasMany('\App\AttributeValue');
    }

}
