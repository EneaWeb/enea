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
		'sku',
		'description',
        'pictures' // default: a:1:{i:0;s:11:"default.jpg";}
    ];

    protected $hidden = [
    
    ];
    
    /* 
    Validation
    */
    
    public static function validate( $input ) {

        $rules = array(
            'product_id' => 'required'
        );

        $messages = array(
            'product_id.required' => trans('x.required-product_variation-product_id')
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
	  return unserialize($this->pictures);
	}
    
    // use: $variation->terms()->associate($term);
    public function terms()
    {
        return $this->belongsToMany('\App\Term', 'term_variation');
    }

}
