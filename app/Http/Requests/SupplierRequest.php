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
                    'fullname' => 'required',
                    'phone' => 'required',
                ];
                if($this->cin){
                    $rules['email'] = 'unique:suppliers';
                }
                if($this->email){
                    $rules['email'] = 'email|unique:suppliers';
                }
                return $rules;
            }
        }else if($this->isMethod('put')){
            if($this->routeIs('administrator.supplier.update')){
                $rules = [
                    'fullname' => 'required',
                    'phone' => 'required',
                ];
                if($this->cin){
                    $rules['cin'] = 'unique:suppliers,cin,'.$this->id;
                }
                if($this->email){
                    $rules['email'] = 'email|unique:suppliers,email,'.$this->id;
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
