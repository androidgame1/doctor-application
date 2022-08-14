<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.prescription.store') || $this->routeIs('administrator.prescription.update')){
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
        $rules=[];
        if($this->isMethod('post') || $this->isMethod('put')){
            if($this->routeIs('administrator.prescription.store') || $this->routeIs('administrator.prescription.update')){
                $rules = [
                    'patient_id' => 'required',
                    'date' => 'required|date',
                    'note' => 'required',
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
            'date.required'=>'The date is required !',
            'date.date'=>'The date is incorrect !',
            'note.required'=>'The note is required !',
        ];
        return $messages;
    }
}
