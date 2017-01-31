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

class Variation extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'variations';
    
    protected $fillable = [
		'product_id',
		'picture',
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
            'product_id.required' => trans('x.required-product_variation-product_id'),
            'active.required' => trans('x.required-product_variation-active'),
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
	  return $this->hasMany('\App\VariationPicture');
	}
    
    public function color()
    {
        return $this->belongsTo('\App\Color');
    }

    public function fullName()
    {
        return $this->product->name.' '.$this->color->name;
    }

}
