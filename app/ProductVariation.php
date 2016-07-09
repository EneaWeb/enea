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

class ProductVariation extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'product_variations';
    
    protected $fillable = [
		'product_id',
		'picture',
		'color_id',
		'attributes',
		'active'
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'product_id' => 'required',
            'active' => 'required',
        );

        $messages = array(
            'product_id.required' => trans('validation.required-product_variation-product_id'),
            'active.required' => trans('validation.required-product_variation-active'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
	public function product()
	{
	  return $this->belongsTo('\App\Product');
	}
    
	public function items()
	{
	  	return $this->hasMany('\App\Item');
	}
    
	public function pictures()
	{
	  return $this->hasMany('\App\ProductVariationPicture');
	}
    
    public function color()
    {
        return $this->belongsTo('\App\Color');
    }

}
