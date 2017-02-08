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
        return $this->hasMany('\App\Variation')->where('active', '1');
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

    public function renderSizes() {
        $arr = array();
        foreach (\App\Item::where('product_id', $this->id)->get() as $item) {
            $arr[] = $item->size->name;
        }
        return \App\X::rangeNumbers($arr);
    }

    public function getSizesNameArray()
    {
        $sizes = array();
        foreach (\App\Item::where('product_id', $this->id)->get() as $item) {
            $sizes[] = $item->size->name;
        }
        return array_unique($sizes);
    }

    public function getSizesIdArray()
    {
        $sizes = array();
        foreach (\App\Item::where('product_id', $this->id)->get() as $item) {
            $sizes[] = $item->size_id;
        }
        return array_unique($sizes);
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

    public function renderPrices()
    {
        $arr = array();
        foreach (\App\Item::where('product_id', $this->id)->get() as $item) {
            $arr[] = $item->priceForOrderList();
        }
        return \App\X::rangeNumbers($arr);
    }

    public static function activeTypes()
    {
        return \App\Product::where('active', '1')->groupBy('type_id')->pluck('type_id');
    }

}
