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

class ProductPicture extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'product_pictures';
    
    protected $fillable = [
    	'product_id',
    	'image',
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'product_id' => 'required',
            'image' => 'required',
            
        );

        $messages = array(
            'product_id.required' => trans('validation.required-product_pictures-product_id'),
            'image.required' => trans('validation.required-product_pictures-image'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
    public function season()
    {
        return $this->belongsTo('\App\Product', 'product_id', 'id');
    }
    

    
}
