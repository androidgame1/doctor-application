<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

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
                    'status_id' => 'required',
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
            'patient_id.required'=>Lang::get('messages.the_patient_is_required'),
            'status_id.required' => Lang::get('messages.the_status_is_required'),
            'start_date.required'=>Lang::get('messages.the_start_date_is_required'),
            'start_date.date'=>Lang::get('messages.the_start_date_is_not_correct'),
            'end_date.required'=>Lang::get('messages.the_end_date_is_required'),
            'end_date.date'=>Lang::get('messages.the_end_date_is_not_correct'),
            'end_date.after_or_equal'=>Lang::get('messages.the_end_date_must_be_greater_than_or_equal_the_start_date'),
        ];
        return $messages;
    }
}
