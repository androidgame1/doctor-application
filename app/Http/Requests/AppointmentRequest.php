<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('secretary.appointment.store') || $this->routeIs('secretary.appointment.update') || $this->routeIs('administrator.appointment.store') || $this->routeIs('administrator.appointment.update')){
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
        $rules = [];
        if($this->isMethod('post') || $this->isMethod('put')){
            if($this->routeIs('secretary.appointment.store') || $this->routeIs('secretary.appointment.update') || $this->routeIs('administrator.appointment.store') || $this->routeIs('administrator.appointment.update')){
                $rules = [
                    'patient_id' => 'required',
                    'status_id' => 'required|numeric',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                ];
            }
        }
        return $rules;
    }
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(){
        $messages = [
            'patient_id.required'=>'The patient is required !',
            'status_id.required' => 'The status is required !',
            'start_date.required'=>'The start date is required !',
            'start_date.date'=>'The start date is not correct !',
            'end_date.required'=>'The end date is required !',
            'end_date.date'=>'The end date is not correct !',
        ];
        return $messages;
    }
}
