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

class TermVariation extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'term_variation';
    
    protected $fillable = [
		'term_id',
		'variation_id'
    ];
    
    public $timestamps = false;

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array (
            'variation_id' => 'required',
            'term_id' => 'required'
        );

        $messages = array (
            'variation_id.required' => trans('x.required-product_variation-product_id'),
            'term_id.required' => trans('x.required-product_variation-product_id')
        );

        return Validator::make($input, $rules, $messages);
    }


}
