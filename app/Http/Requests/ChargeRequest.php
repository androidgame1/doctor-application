<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class ChargeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.charge.store') || $this->routeIs('administrator.charge.update')){
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
            if($this->routeIs('administrator.charge.store') || $this->routeIs('administrator.charge.update')){
                $rules = [
                    'name' => 'required',
                    'amount' => 'required|numeric|gt:0',
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
            'name.required'=>Lang::get('messages.the_name_is_required'),
            'amount.required'=>Lang::get('messages.the_amount_is_required'),
            'amount.numeric'=>Lang::get('messages.the_amount_is_not_numéric'),
            'amount.gt' => Lang::get('messages.the_amount_must_be_greater_than_0'),
        ];
        return $messages;
    }
}
