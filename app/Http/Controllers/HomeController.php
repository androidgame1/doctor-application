<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->is_superadministrator){
            $administrators = User::where('role','administrator')->get();
            $activated_administrators = $administrators->filter(function($value){
                return $value->isvalidate == '1';
            });
            $deactivated_administrators = $administrators->filter(function($value){
                $value->isvalidate == '0';
            });
            return view('home',compact('administrators','activated_administrators','deactivated_administrators'));
        }else if(Auth::user()->is_administrator){
            return view('home');
        }else if(Auth::user()->is_secretary){
            return view('home');
        }else{
            return view('error');
        }
        
    }
}
