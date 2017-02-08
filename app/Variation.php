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

    public function getPictures()
    {
        return unserialize($this->pictures);
    }

    public function featuredPicture()
    {
        return unserialize($this->pictures)[0];
    }

    public function renderTerms()
    {
        return implode(' + ',$this->terms()->pluck('name')->toArray());
    }

    public function getSizesArray()
    {
        return \App\Item::where('variation_id', $this->id)->pluck('size_id')->toArray();
    }

    public static function renderSizes($variation_id) {
        $arr = array();
        foreach (\App\Item::where('variation_id', $variation_id)->get() as $item) {
            $arr[] = $item->size->name;
        }
        return \App\X::rangeNumbers($arr);
    }

    public function renderPrices()
    {
        $arr = array();
        foreach (\App\Item::where('variation_id', $this->id)->get() as $item) {
            $arr[] = $item->priceForOrderList();
        }
        return \App\X::rangeNumbers($arr);
    }

}
