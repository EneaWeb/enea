<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use \App\User as User;
use \App\Profile as Profile;
use \App\Brand as Brand;
use \App\Alert as Alert;
use \App\EneaMail as EneaMail;
use Localization;
use Input;
use Hash;
use App\Http\Requests;
use Image;
use Storage;

class ManageUsersController extends Controller
{

    public function profile($id)
    {
        $user = \App\User::find($id);
        $profile = $user->profile;
        $logs = \App\Log::where('user_id', $id)->get();
        return view('pages.users.profile', compact('user', 'profile', 'logs'));
    }

    public function upload_picture(Request $request)
    {
        // get file object
        $image = $request->file('file');

        // check if file is an image
        if(substr($image->getMimeType(), 0, 5) !== 'image') {
            return 'not an image';
        }

        // get correct path for uploading : /{products}/{brand_slug}/
        $path = '/users/';

        // get file extension
        $ext = $image->getClientOriginalExtension();

        // create new unique filename for the storage, composed as:
        // {originalName}-{random5str}.{ext}
        $fileName = str_replace(' ','-',str_replace('.'.$ext,'',$image->getClientOriginalName())).'-'.str_random(5).'.'.$ext;

        // save picture filename in 'profiles'
        $profile = Auth::user()->profile;
        $profile->avatar = $fileName;
        $profile->save();

        // create Image instance for 600 x 600 picture
        $image_normal = Image::make($image)->resize(600, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // save 600 x 600 to Filesystem
        $image_normal = $image_normal->stream();
        Storage::disk('s3')->put($path.$fileName, $image_normal->__toString());

        // return filename of uploaded file
        return $fileName;
    }

	public function index()
	{
		$active_brand = Auth::user()->options->active_brand;
		
		$users = User::with(['roles' => function($q){
    		$q->where('name', '!=', 'superuser');
		}])
		->whereHas('brands', function($q) use ($active_brand)
			{
			    $q->where('brand_id', $active_brand);
			})->get();
		
		return view('pages.settings.users', compact('users'));
	}
	
	public function unlink_user_from_brand($userid)
	{
		$active_brand = Auth::user()->options->active_brand;
		\App\Brand::find($active_brand)->users()->detach($userid);
		
		Alert::success(trans('x.User unlinked from your network'));
		return redirect()->back();
	}
	
	public function add_user()
	{
		// Input: [ (role) | name | email | message ]
		
		$active_brand = Auth::user()->options->active_brand;
		$companyname = Input::get('companyname');
		$custom_message = Input::get('message');
		$season_lists = Input::get('season_list_id');
		
		// check if User already exhists
		if (User::where('email', Input::get('email'))->count() > 0) {
		   // user found !!
		   
		   // get user id
		   $user_id = User::where('email', Input::get('email'))->value('id');
		   
		   // if user already linked to brand
		   if (\App\Brand::find($active_brand)->users->contains($user_id)) {
		   	// throw error
		   	Alert::error(trans('x.User already linked to your network'));
		   	// redirect back
		   	return redirect()->back();
		   }
		   
		   // attach user id to brand id within brand_user pivot
		   \App\Brand::find($active_brand)->users()->attach($user_id);
		   
		   // attach season_list_id to user id within user_season_list pivot
		   if (Input::has('season_list_id')) {
			   foreach ($season_lists as $key => $season_list) {
			   	\App\User::find($user_id)->season_lists()->attach($season_list);
			   }
			}
		   
		   // success message
		   Alert::success(trans('x.User correctly linked to your network'));
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
				$user->username = strtolower(mb_substr(str_replace(' ', '', trim($companyname)), 0, 8));
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
			
			if (!Input::has('role'))
				$user->assignRole('agent');
			else 
				$user->assignRole(Input::get('role'));
			
			// attach user id to brand id within brand_user pivot
			\App\Brand::find($active_brand)->users()->attach($user->id);
			
		   // attach season_list_id to user id within user_season_list pivot
		   if (Input::has('season_list_id')) {
			   foreach ($season_lists as $key => $season_list) {
			   	$user->season_lists()->attach($season_list);
			   }
			}

			$option = new \App\UserOption;
			$option->user_id = $user->id;
			$option->active_brand = $active_brand;
			$option->save();
			
		   // send email to user
		   $mail = EneaMail::user_invited_to_register($user, $active_brand, $custom_message);
		   // success message
		   Alert::success(trans('x.User invited to confirm the registration'));
		   // redirect back
		   return redirect()->back();
		}
	}
	
	public function register()
	{
		if (Input::has('lang'))
			Localization::setLocale(Input::get('lang'));
		return view('auth.registration');
	}
	
	public function confirm_registration()
	{
		
		// provisory authentication
		if (Auth::once(['email' => Input::get('email'), 'password' => 'provvisoria'])) {
			if (Input::has('new_username') && Input::has('new_password') && Input::has('confirm_new_password')) {
				// retrieve user temporary logged
			   $user = Auth::user();
			   // update username and pass
			   $user->username = Input::get('new_username');
			   $user->password = bcrypt(Input::get('new_password'));
			   $user->active = '1';
			   $user->save();
			   // save companyname
			   $user->profile->companyname = Input::get('companyname');
			   $user->profile->save();
			   // logout user
			   Auth::logout();
			   // login with new credentials
				if ( Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('new_password'), 'active' => '1' ], true) ||
				   Auth::attempt(['username' => Input::get('new_username'), 'password' => Input::get('new_password'), 'active' => '1' ], true) ) {
						// auth success
						// throw confirmation message
				      Alert::success(trans('x.Welcome').', '.Auth::user()->username.'.');
				   	// redirect on dashboard
				      return redirect()->intended('dashboard');
				} else {
				   // Authentication fails...
				   Alert::error(trans('x.failed'));
				   return redirect('/login');
				}
			} else {
				Alert::error(trans('x.Check and fill all the required fields'));
				return redirect()->back();
			}
		} else {
			// provisory authentication failed
			Alert::error('autenticazione provvisoria fallita');
			return redirect()->back();
		}

		return redirect()->back();
	}
	
	public function change_password()
	{
		if (! Hash::check(Input::get('old_password'), Auth::user()->password)) {
			// old password is wrong ..
			Alert::error('Password is wrong');
		} else {
			// old password matches
			// check if 2 new passwords match
			if (Input::get('new_password') == Input::get('confirm_new_password')) {
				// retrieve user instance
				$user = Auth::user();
				// change password
			   $user->password = bcrypt('new_password');
			   $user->save();
			   // throw success message
			   Alert::success('Password changed');
			   
			} else {
				// 2 new passwords doesn't match
				Alert::error("Password doesn't match");
			}
		}
		// return redirect back
		return redirect()->back();
	}
	
}
