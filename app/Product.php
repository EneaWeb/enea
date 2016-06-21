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
    	'slug',
    	'name',
    	'description',
    	'picture',
        'season_id',
        'prodmodel_id',
        'variation_id',
        'active'
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
        );

        $messages = array(
            'name.required' => trans('validation.required-product-name'),
            'slug.required' => trans('validation.required-product-slug'),
            'season_id.required' => trans('validation.required-product-season'),
            'prodmodel_id.required' => trans('validation.required-product-prodmodel'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */
    
    public function season()
    {
        return $this->belongsTo('\App\Season', 'season_id', 'id');
    }
    
    public function model()
    {
        return $this->belongsTo('\App\ProdModel', 'prodmodel_id', 'id');
    }
    
    public function items()
    {
        return $this->hasMany('\App\Item');
    }
    
    public function pictures()
    {
        return $this->hasMany('\App\ProductPicture');
    }
    
    public function variation()
    {
        return $this->belongsTo('\App\Variation');
    }
    
    public static function product_colors($product_id)
    {
        return \App\Item::where('product_id', $product_id)->groupBy('color_id')->lists('color_id');
    }
}
