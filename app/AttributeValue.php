<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Auth;

class AttributeValue extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'attribute_values';

    protected $fillable = [
    	'slug',
    	'name',
    	'description'
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'attribute_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
        );

        $messages = array(
            'attribute_id.required' => 'ERROR - Attribute ID not passed',
            'name.required' => trans('validation.required-attribute-value-name'),
            'slug.required' => trans('validation.required-attribute-value-slug'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
    public function attribute()
    {
        return $this->belongsTo('\App\Attribute');
    }

}
