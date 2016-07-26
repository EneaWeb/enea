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
		if ($num2 != 0)
			return ($num1 / $num2) * 100;
	}
	
	public static function inverse_percentage($num, $percentage)
	{
		return ($percentage / 100) * $num;
	}
	
}