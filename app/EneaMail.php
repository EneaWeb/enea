<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Auth;
use Mail;
use Input;

class EneaMail extends Model
{

	protected $sender = Auth::user()->options->brand_in_use->name;
	protected $sender_mail = 'no-reply@eneaweb.com';
	protected $cc = Auth::user()->options->brand_in_use->confirmation_email;
	protected $reply_to = Auth::user()->options->brand_in_use->confirmation_email;
	
	public function order_confirmation()
	{
		
	}

}
