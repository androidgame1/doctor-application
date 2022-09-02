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
use Lang;

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
            "subject"=>Lang::get("messages.reset_password"),
                "token"=>$token,
                "email"=>$request->email,
                "message"=>Lang::get("messages.you_are_receiving_this_email_because_we_have_received_a_password_reset_request_for_your_account"),
                "long_message"=>Lang::get("messages.this_password_reset_link_will_expire_in_60_minutes_If_you_did_not_request_a_password_reset_no_further_action_is_required_Regards")
        ];
            if(Password_reset::create(['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()])){
                try {
                    Mail::to($request->email)->send(new RecoverPasswordMail($data));
                    toastr()->success(Lang::get("messages.the_email_has_sent_by_success_check_your_email_out"));
                    return redirect()->route('login');
                } catch (\Throwable $th) {
                    toastr()->warning(Lang::get("messages.the_email_has_not_sent_by_success"));
                }
            }else{
                toastr()->warning(Lang::get("messages.the_email_has_not_inserted_by_success"));
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
              
                toastr()->success(Lang::get("messages.your_password_has_changed_by_success"));
                
          }else{
            toastr()->warning(Lang::get("messages.invalid_token"));
            return redirect()->back()->withInput();
          }
         
          return redirect()->route('login');
      }
}
