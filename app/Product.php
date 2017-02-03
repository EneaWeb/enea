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

class Product extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'products';
    
    protected $fillable = [
        'sku',
        'name',
        'description',
        'pictures', // default: a:1:{i:0;s:11:"default.jpg";}
        'prodmodel_id', 
        'season_id',
        'type_id',
        'has_variations',
        'active' // default: 1
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
            'season_id' => 'required',
            'prodmodel_id' => 'required',
            'type_id' => 'required',
        );

        $messages = array(
            'name.required' => trans('x.required-product-name'),
            'slug.required' => trans('x.required-product-slug'),
            'season_id.required' => trans('x.required-product-season'),
            'prodmodel_id.required' => trans('x.required-product-prodmodel'),
            'type_id.required' => trans('x.required-product-type_id'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
    public function season()
    {
        return $this->belongsTo('\App\Season');
    }
    
    public function prodmodel()
    {
        return $this->belongsTo('\App\ProdModel');
    }
    
    public function type()
    {
        return $this->belongsTo('\App\Type');
    }
    
    public function items()
    {
        return $this->hasMany('\App\Item');
    }
    
    public function pictures()
    {
        return $this->hasMany('\App\ProductPicture');
    }
    
    public function variations()
    {
        return $this->hasMany('\App\Variation');
    }
    
    public static function product_colors($product_id)
    {
        return \App\Item::where('product_id', $product_id)->groupBy('color_id')->pluck('color_id');
    }

    public function renderVariations()
    {
        $msg = '';
        foreach ($this->variations as $variation) {
            //return dd($variation->terms()->pluck('name')->toArray());
            $msg .= implode(' + ',$variation->terms()->pluck('name')->toArray()).'<br>';
        }
        return $msg;
    }

    public static function availColors($product_id)
    {
        $str = array();
        foreach (\App\Variation::where('product_id', $product_id)->get() as $prodVar)
        {
            $str[] = $prodVar->color->name;
        }
        return implode($str, ', ');
    }

    public static function availSizes($product_id)
    {
        $str = array();
        foreach (\App\Item::where('product_id', $product_id)->get() as $item)
        {
            $str[] = $item->size->name;
        }
        return implode(array_unique($str), ', ');
    }

    public static function renderSizes($product_id) {
        $arr = array();
        foreach (\App\Item::where('product_id', $product_id)->get() as $item) {
            $arr[] = $item->size->name;
        }
        return \App\X::rangeNumbers($arr);
    }

    // use: $product->terms()->associate($term);
    // public function terms()
    // {
    //     return $this->belongsToMany('\App\Term', 'term_product');
    // }

    public function log($action)
    {
        $log = new \App\Log;
        $log->product_id = $this->id;
        $log->action = $action;
        $log->user_id = Auth::user()->id;
        $log->save();
    }

    public function getPictures()
    {
        return unserialize($this->pictures);
    }

    public function featuredPicture()
    {
        return unserialize($this->pictures)[0];
    }

}
