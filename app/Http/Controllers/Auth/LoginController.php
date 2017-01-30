<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Input;
use Auth;
use \App\Alert as Alert;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login()
    {
        return view('auth.login');
    }
    
    public function authenticate(Input $input)
    {
        $username = $input->get('username');
        $password = $input->get('password_true');
        $honeypot = $input->get('password');
        
        // honeypot
        if ($honeypot != '')
            return redirect('/login');
        
        // login attempt
        // [array with credentials], (bool) remember
        if ( Auth::attempt(['email' => $username, 'password' => $password, 'active' => '1' ], true) ||
            Auth::attempt(['username' => $username, 'password' => $password, 'active' => '1' ], true) ) {
                // Authentication passed with EMAIL
                Alert::success(trans('x.Welcome back').', '.Auth::user()->username.'.');
                return redirect()->intended('dashboard');
        } else {
            // Authentication fails...
            Alert::error(trans('x.failed'));
            return redirect('/login');
        }
    }
}
