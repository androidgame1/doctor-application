<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.supplier.store') || $this->routeIs('administrator.supplier.update')){
            $validate = true;
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
            if($this->routeIs('administrator.supplier.store')){
                $rules = [
                    'cin' => 'required|unique:suppliers',
                    'fullname' => 'required',
                    'email' => 'required|email|unique:suppliers',
                    'address' => 'required',
                    'phone' => 'required',
                    'city' => 'required',
                ];
                return $rules;
            }
        }else if($this->isMethod('put')){
            if($this->routeIs('administrator.supplier.update')){
                $rules = [
                    'cin' => 'required|unique:suppliers,cin,'.$this->id,
                    'fullname' => 'required',
                    'email' => 'required|email|unique:suppliers,email,'.$this->id,
                    'address' => 'required',
                    'phone' => 'required',
                    'city' => 'required',
                ];
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
            'cin.required'=>Lang::get('messages.the_CIN_is_required'),
            'cin.unique'=>Lang::get('messages.the_CIN_is_already_exists'),
            'fullname.required' =>Lang::get('messages.the_fullname_is_required'),
            'email.required'=>Lang::get('messages.the_email_is_required'),
            'email.email'=>Lang::get('messages.the_email_is_incorrect'),
            'email.unique'=>Lang::get('messages.the_email_is_already_exists'),
            'address.required' =>Lang::get('messages.the_address_is_required'),
            'phone.required' =>Lang::get('messages.the_phone_is_required'),
            'city.required' =>Lang::get('messages.the_city_is_required'),
        ];
        return $messages;
    }
}
