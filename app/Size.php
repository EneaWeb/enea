<?php

/*
==================
    BRAND DB
==================
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Support\Collection as Collection;
use Auth;

class Size extends Model
{

	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
	
    protected $table = 'sizes';
    
    // id is varchar and not to increment
    public $incrementing = false;

	protected $fillable = [
        'id',
		'name',
        'types',
        'active'
	];

	protected $hidden = [

	];
    
    /* 
    Validation
    */
    
	public static function validate( $input ) {

		$rules = array(
		   'id' => 'required',
		   'name' => 'required'
		);

		$messages = array(
		   'id.required' => trans('x.required-size-slug'),
		   'name.required' => trans('x.required-size-name')
		);

	  	return Validator::make($input, $rules, $messages);
	}

	/**
	* Relations
	*/
	
	public static function sizes_for_type(\App\Product $product)
	{
		$sizes = new Collection;
		foreach (\App\Size::all() as $size) {
			$types = unserialize($size->types);
			if (in_array($product->type_id, $types)) {
				$sizes->push($size);
			}
		}
		return $sizes;
	}

    public function renderTypes()
    {
        $a = unserialize($this->types);
        $b = array();
        foreach ($a as $k => $v) {
            $b[] = trans('x.'.\App\Type::find($v)->name).''; 
        }
        return implode(', ',$b);
    }

    public static function activeCount()
    {
        return \App\Size::where('active', '1')->count();
    }

    public static function activeSizes()
    {
         return \App\Size::where('active', '1')->get();
    }

}
