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

class Term extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'terms';
    
    // id is varchar and not to increment
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'name',
        'attribute_id',
        'hex'
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'id' => 'required',
            'name' => 'required',
            'attribute_id' => 'required'
        );

        $messages = array(
            'id.required' => trans('x.required-term-id'),
            'name.required' => trans('x.required-term-name'),
            'attribute_id.required' => trans('x.required-term-attribute_id'),
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

    public function products()
    {
        return $this->belongsToMany('\App\Product', 'term_product');
    }

    public function variations()
    {
        return $this->belongsToMany('\App\Variation', 'term_product');
    }
    
}
