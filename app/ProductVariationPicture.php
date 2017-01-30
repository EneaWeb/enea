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

class ProductVariationPicture extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'product_variation_pictures';
    
    protected $fillable = [
    	'product_variation_id',
    	'image',
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'product_variation_id' => 'required',
            'image' => 'required',
            
        );

        $messages = array(
            'product_variation_id.required' => trans('x.required-product_pictures-product_variation_id'),
            'image.required' => trans('x.required-product_pictures-image'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
	public function product_variation()
	{
	  return $this->belongsTo('\App\ProductVariation');
	}

    
}
