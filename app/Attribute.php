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

class Attribute extends Model
{
    
    public function __construct()
    {
        $this->connection = Auth::user()->options->brand_in_use->slug;
    }
    protected $table = 'attributes';

    // id is varchar and not to increment
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'name',
        'description',
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
            'name' => 'required',
        );

        $messages = array(
            'id.required' => trans('x.required-attribute-id'),
            'name.required' => trans('x.required-attribute-name'),
        );

        return Validator::make($input, $rules, $messages);
    }
    
    /**
     * Relations
     */

    public function terms()
    {
        return $this->hasMany('\App\Term');
    }
    
}
