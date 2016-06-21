<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use \App\User as User;
use \App\Brand as Brand;
use App\Http\Requests;

class ManageUsersController extends Controller
{
	public function index()
	{
		$active_brand = Auth::user()->options->active_brand;
		
		$users = User::whereHas('brands', function($q) use ($active_brand)
		{
		    $q->where('brand_id', $active_brand);
		})->get();
		
		return view('pages.admin.manage_users', compact('users'));
	}
	
	public function unlink_user_from_brand($userid)
	{
		
	}
}
