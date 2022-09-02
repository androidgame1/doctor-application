<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class DrugRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.drug.store') || $this->routeIs('administrator.drug.update')){
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
            if($this->routeIs('administrator.drug.store') || $this->routeIs('administrator.drug.update')){
                $rules = [
                    'trade_name' => 'required',
                    'generic_name' => 'required',
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
            'trade_name.required'=>Lang::get('messages.the_trade_name_is_required'),
            'generic_name.required'=>Lang::get('messages.the_generic_name_is_required'),
        ];
        return $messages;
    }
}
