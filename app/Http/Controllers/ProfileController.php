<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Alert;
use Auth;
use Session;
use App\Http\User;
use App\Http\Requests;

class ProfileController extends Controller
{
	public function index()
	{
		
	}
	
    public function edit()
    {
    	// current user
    	$user = Auth::user();
        
        // pages/profile/edit view
        return view('pages.profile.edit', compact('user'));
    }
    
    public function set_current_brand($brand_id)
    {
        // flush working orders
        Session::forget('order');
        
        $user_options = \App\UserOption::where('user_id', Auth::user()->id)->first();
        $user_options->active_brand = $brand_id;
        $user_options->save();
        
        \App\Alert::success(trans('messages.Brand in use changed'));
        return redirect('/');
    }

    public function set_current_type($type_id)
    {
        // flush working orders
        //Session::forget('order');
        
        $user_options = \App\UserOption::where('user_id', Auth::user()->id)->first();
        $user_options->active_type = $type_id;
        $user_options->save();
        
        \App\Alert::success(trans('messages.Type in use changed'));
        return redirect()->back();
    }
}
