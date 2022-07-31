<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('forget.password.post') || $this->routeIs('reset.password.post') || $this->routeIs('administrator.password.update') || $this->routeIs('administrator.profile.update') || $this->routeIs('administrator.user.store') || $this->routeIs('administrator.user.update')  || $this->routeIs('superadministrator.password.update') || $this->routeIs('superadministrator.profile.update') || $this->routeIs('superadministrator.user.store') || $this->routeIs('superadministrator.user.update') || $this->routeIs('secretary.password.update') || $this->routeIs('secretary.profile.update')){
            $validate=true;
        }
        return $validate;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->isMethod('post')){
            if($this->routeIs('forget.password.post')){
                $rules = [
                    'email'=>'required|email|exists:users'
                ];
                return $rules;
            }else if($this->routeIs('reset.password.post')){
                $rules = [
                    'email' => 'required|email|exists:users',
                    'new_password' => 'required',
                    'confirm_password' => 'required|same:new_password'
                ];
                return $rules;
            }else if($this->routeIs('administrator.user.store') || $this->routeIs('superadministrator.user.store')){
                $rules = [
                    'cin' => 'required|unique:users',
                    'fullname' => 'required',
                    'email' => 'required|email|unique:users',
                    'address' => 'required',
                    'phone' => 'required',
                    'city' => 'required',
                    'password'=>'required',
                    'confirm_password'=>'required|same:password'
                ];
                return $rules;
            }
        }else if($this->isMethod('put')){
            if($this->routeIs('administrator.password.update') || $this->routeIs('superadministrator.password.update')|| $this->routeIs('secretary.password.update')){
                $rules = [
                    'old_password' => 'required',
                    'new_password' => 'required',
                    'confirm_password' => 'required|same:new_password',
                ];
                return $rules;
            }else if($this->routeIs('administrator.profile.update') || $this->routeIs('superadministrator.profile.update')|| $this->routeIs('secretary.profile.update')){
                $user = Auth::user();
                $rules = [
                    'image'=>'image|mimes:jpg,png,jpeg,gif,svg',
                    'fullname' => 'required',
                    'email' => 'required|email|unique:users,email,'.$user->id,
                    'address' => 'required',
                    'phone' => 'required',
                    'city' => 'required',
                ];
                return $rules;
            }else if($this->routeIs('administrator.user.update') || $this->routeIs('superadministrator.user.update')){
                $rules = [
                    'cin' => 'required|unique:users,cin,'.$this->id,
                    'fullname' => 'required',
                    'email' => 'required|email|unique:users,email,'.$this->id,
                    'address' => 'required',
                    'phone' => 'required',
                    'city' => 'required',
                ];
                if($this->password || $this->confirm_password){
                    $rules['password'] = 'required';
                    $rules['confirm_password'] = 'required|same:password';
                }
                return $rules;
            }

        }
    }
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(){
        if($this->isMethod('post')){
            if($this->routeIs('forget.password.post')){
                $messages = [
                    'email.required'=>'Email is required !',
                    'email.email'=>'Email is incorrect !',
                    'email.exists'=>'Email is not exists !',
                    'password.required'=>'Password is required !'
                ];
                return $messages;
            }else if($this->routeIs('reset.password.post')){
                $messages = [
                    'email.required'=>'Email is required !',
                    'email.email'=>'Email is incorrect !',
                    'email.exists'=>'Email is not exists !',
                    'new_password.required' => 'The new password is required !',
                    'confirm_password.required' => 'The confirm password is required !',
                    'confirm_password.same' => 'The confirm password must be like the new password !'
                ];
                return $messages;
            }else if($this->routeIs('administrator.user.store') || $this->routeIs('superadministrator.user.store')){
                $messages = [
                    'cin.required' => 'The CIN is required !',
                    'cin.unique' => 'The CIN is already exists !',
                    'fullname.required' => 'The fullname is required !',
                    'email.required' => 'The email is required !',
                    'email.email' => 'The email is incorrect !',
                    'email.unique' => 'The email is already exists !',
                    'address.required' => 'The address is required !',
                    'phone.required' => 'The phone is required !',
                    'city.required' => 'The city is required !',
                    'password.required' => 'The password is required !',
                    'confirm_password.required' => 'The confirm password is required !',
                    'confirm_password.same' => 'The confirm password must be like the first password !',
                ];
                return $messages;
            }
        }else if($this->isMethod('put')){
            if($this->routeIs('administrator.password.update') || $this->routeIs('superadministrator.password.update')|| $this->routeIs('secretary.password.update')){
                $messages = [
                    'old_password.required' => 'The old password is required !',
                    'new_password.required' => 'The new password is required !',
                    'confirm_password.required' => 'The confirm password is required !',
                    'confirm_password.same' => 'The confirm password must be like the new password !',
                ];
                return $messages;
            }else if($this->routeIs('administrator.profile.update') || $this->routeIs('superadministrator.profile.update')|| $this->routeIs('secretary.profile.update')){
                $messages = [
                    'image.image'=>'The file is not image !',
                    'image.mimes'=>'The file extention must be include to (jpg,png,jpeg,gif,svg) !',
                    'fullname.required' => 'The fullname is required !',
                    'email.required' => 'The email is required !',
                    'email.email' => 'The email is incorrect !',
                    'email.unique' => 'The email is already exists !',
                    'address.required' => 'The address is required !',
                    'phone.required' => 'The phone is required !',
                    'city.required' => 'The city is required !',
                ];
                return $messages;
            }else if($this->routeIs('administrator.user.update') || $this->routeIs('superadministrator.user.update')){
                $messages = [
                    'cin.required' => 'The CIN is required !',
                    'cin.unique' => 'The CIN is already exists !',
                    'fullname.required' => 'The fullname is required !',
                    'email.required' => 'The email is required !',
                    'email.email' => 'The email is incorrect !',
                    'email.unique' => 'The email is already exists !',
                    'address.required' => 'The address is required !',
                    'phone.required' => 'The phone is required !',
                    'city.required' => 'The city is required !',
                    'password.required' => 'The password is required !',
                    'confirm_password.required' => 'The confirm password is required !',
                    'confirm_password.same' => 'The confirm password must be like the first password !',
                ];
                return $messages;
            }

        }
    }
}
