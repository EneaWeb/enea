<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use \App\User;
use Auth;
use Input;

class EneaHelper extends Model
{
	
	public static function percentage($num1, $num2)
	{
		return ($num1 / $num2) * 100;
	}
	
}