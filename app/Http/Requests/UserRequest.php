<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Lang;

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
            $messages = [
                'email.required'=>Lang::get('messages.the_email_is_required'),
                'email.email'=>Lang::get('messages.the_email_is_incorrect'),
                'email.exists'=>Lang::get('messages.the_email_is_not_exists'),
                'password.required'=>Lang::get('messages.the_password_is_required'),
                'new_password.required' =>Lang::get('messages.the_new_password_is_required'),
                'confirm_password.required' =>Lang::get('messages.the_confirm_password_is_required'),
                'confirm_password.same' =>Lang::get('messages.the_confirm_password_must_be_like_the_new_password'),
                'cin.required' =>Lang::get('messages.the_CIN_is_required'),
                'cin.unique' =>Lang::get('messages.the_CIN_is_already_exists'),
                'fullname.required' =>Lang::get('messages.the_fullname_is_required'),
                'email.unique' =>Lang::get('messages.the_email_is_already_exists'),
                'address.required' =>Lang::get('messages.the_address_is_required'),
                'phone.required' =>Lang::get('messages.the_phone_is_required'),
                'city.required' =>Lang::get('messages.the_city_is_required'),
                'old_password.required' =>Lang::get('messages.the_old_password_is_required'),
                'image.image'=>Lang::get('messages.the_file_is_not_image'),
                'image.mimes'=>Lang::get('messages.the_file_extention_must_be_include_to_(jpg,png,jpeg,gif,svg)'),
            ];
            return $messages;

    }
}
