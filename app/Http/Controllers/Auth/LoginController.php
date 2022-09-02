<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Cookie;
use Lang;

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
    protected $redirectTo = RouteServiceProvider::HOME;
     /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo(){
        if(Auth::user()->is_superadministrator){
            return redirect()->route('superadministrator.home');
        }else if(Auth::user()->is_administrator){
            return redirect()->route('administrator.home');
        }else if(Auth::user()->is_secretary){
            return redirect()->route('secretary.home');
        }
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
/**
     * login.
     *
     * @return void
     */
    public function login(LoginRequest $request){
        
        if(Auth::attempt(array('email'=>$request->email,'password'=>$request->password))){
            if(Auth::user()->is_superadministrator || Auth::user()->is_administrator || Auth::user()->is_secretary){
                if($request->has('remember')){
                    Cookie::queue("email",$request->email,1440);
                    Cookie::queue("password",$request->password,1440);
                }else{
                    Cookie::queue(Cookie::forget("email"));
                    Cookie::queue(Cookie::forget("password"));  
                }
                if(Auth::user()->is_superadministrator){
                    return redirect()->route('superadministrator.home');
                }else if(Auth::user()->is_administrator){
                    return redirect()->route('administrator.home');
                }else if(Auth::user()->is_secretary){
                    return redirect()->route('secretary.home');
                }
            }
        }else{
            toastr()->warning(Lang::get('messages.email_or_password_is_incorrect'));
        }
        return redirect()->route('login');
    }
    
}
