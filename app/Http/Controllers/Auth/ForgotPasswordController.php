<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon; 
use App\Models\User;
use App\Models\Password_reset; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Mail\RecoverPasswordMail;

class ForgotPasswordController extends Controller
{
    /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth.passwords.email');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(UserRequest $request)
      {
  
        $token = Str::random(64);
        $data = [
            "subject"=>"Reset password",
                "token"=>$token,
                "email"=>$request->email,
                "message"=>"You are receiving this email because we have received a password reset request for your account",
                "long_message"=>"This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required, Regards"
        ];
            if(Password_reset::create(['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()])){
                try {
                    Mail::to($request->email)->send(new RecoverPasswordMail($data));
                    toastr()->success('The email has sent by success, check your email out.');
                    return redirect()->route('login');
                } catch (\Throwable $th) {
                    toastr()->warning('The email has not sent by success !');
                }
            }else{
                toastr()->warning('The email has not inserted by success !');
            }
        return redirect()->back()->withInput();
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token,$email) { 
         return view('auth.passwords.reset', compact('token' ,'email'));
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(UserRequest $request)
      {
       
          if(Password_reset::where('email' , $request->email)->where('token' , $request->token)->exists()){
                $user = User::where('email', $request->email)->update(['password' => Hash::make($request->new_password)]);
                $passwords_resets = Password_reset::where('email', $request->email)->delete();
              
                toastr()->success('Your password has changed by success !');
                
          }else{
            toastr()->warning('Invalid token !');
            return redirect()->back()->withInput();
          }
         
          return redirect()->route('login');
      }
}
