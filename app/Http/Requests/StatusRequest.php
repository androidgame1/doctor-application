<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class StatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.status.store') || $this->routeIs('administrator.status.update')){
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
            if($this->routeIs('administrator.status.store') || $this->routeIs('administrator.status.update')){
                $rules = [
                    'name' => 'required',
                    'color' => 'required',
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
            'color.required'=>Lang::get('messages.the_color_is_required'),
        ];
        return $messages;
    }
}
