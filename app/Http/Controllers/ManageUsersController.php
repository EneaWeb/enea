<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use \App\User as User;
use \App\Profile as Profile;
use \App\Brand as Brand;
use \App\Alert as Alert;
use \App\EneaMail as EneaMail;
use Input;
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
	
	public function add_user()
	{
		// Input: [ name | email | message ]
		
		$active_brand = Auth::user()->options->active_brand;
		$companyname = Input::get('companyname');
		$custom_message = Input::get('message');
		
		// check if User already exhists
		if (User::where('email', Input::get('email'))->count() > 0) {
		   // user found
		   
		   // get user id
		   $user_id = User::where('email', Input::get('email'))->value('id');
		   
		   // if user already linked to brand
		   if (\App\Brand::find($active_brand)->users->contains($user_id)) {
		   	// throw error
		   	Alert::error(trans('User already linked to your network'));
		   	// redirect back
		   	return redirect()->back();
		   }
		   
		   // attach user id to brand id within brand_user pivot
		   \App\Brand::find($active_brand)->users()->attach($user_id);
		   // success message
		   Alert::success(trans('User correctly linked to your network'));
		   // send email to user
		   $mail = EneaMail::user_linked_to_network($user_id, $active_brand, $custom_message);
		   // redirect back
		   return redirect()->back();
		   
		} else {
			// user not found.. need to create it
			// instanciate new User
			$user = new User;
			// if user inserted a companyname
			if ($companyname != '')
				$user->username = strtolower(trim(mb_substr($companyname, 0, 8)));
			// if not, I set 'changeme' + 0-100 random number as username
			else
				$user->username = 'changeme'.rand(0,100);
			$user->email = Input::get('email');
			// I set a provisory password
			$user->password = bcrypt('provvisoria');
			$user->active = 0;
			$user->save();
			
			$user_profile = new Profile;
			$user_profile->user_id = $user->id;
			$user_profile->companyname = $companyname;
			$user_profile->name = '';
			$user_profile->surname = '';
			$user_profile->avatar = 'avatar.jpg';
			$user_profile->save();
			
			$user->assignRole('agent');
			
			\App\Brand::find($active_brand)->users()->attach($user->id);

			$options = new \App\UserOption;
			$option->user_id = $user->id;
			$option->active_brand = \App\Option::where('name', 'active_brand')->first()->value;
			$option->save();
			
		   // send email to user
		   $mail = EneaMail::user_invited_to_register($user, $active_brand, $custom_message);
		   // success message
		   Alert::success(trans('User invited to confirm the registration'));
		   // redirect back
		   return redirect()->back();
		}
	}
	
	public function register()
	{
		return view('auth.registration');
	}
	
	public function confirm_registration()
	{
		return redirect('');
	}
	
}
