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
use Localization;

class Log extends Model
{
    
	public function __construct()
	{
	  	$this->connection = Auth::user()->options->brand_in_use->slug;
	}
    
	protected $table = 'logs';

	protected $fillable = [
        'user_id',
        'product_id',
        'customer_id',
        'order_id',
        'action' // type of actions: C - U - D
	];

	protected $hidden = [

	];

	/* 
	Validation
	*/

	/**
	* Relations
	*/

	/**
	* Other methods
	*/

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public static function renderContent($log)
    {
        // get user Company Name
        $userCName = $log->user->profile->companyname;
        // get action verbosely
        switch ($log->action) {
            case 'C' :
                $action = trans('x.created');
                break;
            case 'D' :
                $action = trans('x.deleted');
                break;
            case 'U' :
                $action = trans('x.updated');
                break;
            default:
                $action = trans('x.created');
                break;
        }
        // get object
        if ($log->product_id !== '' && $log->product_id !== NULL) {
            $object = trans('x.Product');
            $id = $log->product_id;
        } else if ($log->customer_id !== '' && $log->customer_id !== NULL) {
            $object = trans('x.Customer');
            $id = $log->customer_id;
        }else if ($log->order_id !== '' && $log->order_id !== NULL) {
            $object = trans('x.Order');
            $id = $log->order_id;
        }

        // set locale
        \Carbon\Carbon::setLocale(Localization::getCurrentLocale());

        return $userCName.' <b>'.$action.'</b> '.$object.' # '.$id.' &nbsp; - ('.$log->created_at->diffForHumans().' - '.$log->created_at->format('d M y H:i').')';
        
    }

}
