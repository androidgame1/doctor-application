<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('secretary.patient.store') || $this->routeIs('secretary.patient.update') || $this->routeIs('administrator.patient.store') || $this->routeIs('administrator.patient.update')){
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
            if($this->routeIs('secretary.patient.store') || $this->routeIs('administrator.patient.store')){
                $rules = [
                    'fullname' => 'required',
                    'phone' => 'required',
                    'weight' => 'numeric',
                    'height' => 'numeric',
                ];
                if($this->cin){
                    $rules['cin'] = 'unique:patients';
                }
                if($this->email){
                    $rules['email'] = 'email|unique:patients';
                }
                if($this->birthday){
                    $rules['birthday'] = 'date';
                }
                return $rules;
            }
        }else if($this->isMethod('put')){
            if($this->routeIs('secretary.patient.update') || $this->routeIs('administrator.patient.update')){
                $rules = [
                    'fullname' => 'required',
                    'phone' => 'required',
                    'weight' => 'numeric',
                    'height' => 'numeric',
                ];
                if($this->cin){
                    $rules['cin'] = 'unique:patients,cin,'.$this->id;
                }
                if($this->email){
                    $rules['email'] = 'email|unique:patients,email,'.$this->id;
                }
                if($this->birthday){
                    $rules['birthday'] = 'date';
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
            'fullname.required' => Lang::get('messages.the_fullname_is_required'),
            'email.required'=>Lang::get('messages.the_email_is_required'),
            'email.email'=>Lang::get('messages.the_email_is_incorrect'),
            'email.unique'=>Lang::get('messages.the_email_is_already_exists'),
            'address.required' => Lang::get('messages.the_address_is_required'),
            'phone.required' => Lang::get('messages.the_phone_is_required'),
            'city.required' => Lang::get('messages.the_city_is_required'),
            'birthday.required' => Lang::get('messages.the_birthday_is_required'),
            'birthday.date' => Lang::get('messages.the_birthday_is_not_date'),
            'gender.required' => Lang::get('messages.the_gender_is_required'),
            'blood_group.required' => Lang::get('messages.the_blood_group_is_required'),
            'weight.required' => Lang::get('messages.the_weight_is_required'),
            'weight.numeric' => Lang::get('messages.the_weight_must_be_numeric'),
            'weight.gt' => Lang::get('messages.the_weight_must_be_greater_than_0'),
            'height.required' => Lang::get('messages.the_height_is_required'),
            'height.numeric' => Lang::get('messages.the_height_must_be_numeric'),
            'height.gt' => Lang::get('messages.the_height_must_be_greater_than_0'),
        ];
        return $messages;
    }
}
