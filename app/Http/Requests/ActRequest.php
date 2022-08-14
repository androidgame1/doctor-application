<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.act.store') || $this->routeIs('administrator.act.update')){
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
            if($this->routeIs('administrator.act.store') || $this->routeIs('administrator.act.update')){
                $rules = [
                    'name' => 'required',
                    'amount' => 'required|gt:0',
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
            'name.required'=>'The name is required !',
            'amount.required'=>'The amount is required !',
            'amount.gt' => 'The amount must be greater than 0 !',
        ];
        return $messages;
    }
}
