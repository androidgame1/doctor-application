<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->isMethod('post')){
            $rules = [
                'email'=>'required|email',
                'password'=>'required'
            ];
            return $rules;
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
            'password.required'=>Lang::get('messages.the_password_is_required'),
        ];
        return $messages;
    }
}
