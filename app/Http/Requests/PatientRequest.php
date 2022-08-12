<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
                    'cin' => 'required|unique:patients',
                    'fullname' => 'required',
                    'email' => 'required|email|unique:patients',
                    'phone' => 'required',
                    'birthday' => 'required|date',
                    'gender' => 'required',
                    'weight' => 'numeric',
                    'height' => 'numeric',
                ];
                return $rules;
            }
        }else if($this->isMethod('put')){
            if($this->routeIs('secretary.patient.update') || $this->routeIs('administrator.patient.update')){
                $rules = [
                    'cin' => 'required|unique:patients,cin,'.$this->id,
                    'fullname' => 'required',
                    'email' => 'required|email|unique:patients,email,'.$this->id,
                    'phone' => 'required',
                    'birthday' => 'required|date',
                    'gender' => 'required',
                    'weight' => 'numeric',
                    'height' => 'numeric',
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
            'cin.required'=>'The CIN is required !',
            'cin.unique'=>'The CIN is already exists !',
            'fullname.required' => 'The fullname is required !',
            'email.required'=>'The email is required !',
            'email.email'=>'The email is incorrect !',
            'email.unique'=>'The email is already exists !',
            'address.required' => 'The address is required !',
            'phone.required' => 'The phone is required !',
            'city.required' => 'The city is required !',
            'birthday.required' => 'The birthday is required !',
            'birthday.date' => 'The birthday is not date !',
            'gender.required' => 'The gender is required !',
            'blood_group.required' => 'The blood_group is required !',
            'weight.required' => 'The weight is required !',
            'weight.numeric' => 'The weight must be numeric !',
            'weight.gt' => 'The weight must be greater than 0 !',
            'height.required' => 'The height is required !',
            'height.numeric' => 'The height must be numeric !',
            'height.gt' => 'The height must be greater than 0 !',
        ];
        return $messages;
    }
}
