<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class TestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.test.store') || $this->routeIs('administrator.test.update')){
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
            if($this->routeIs('administrator.test.store') || $this->routeIs('administrator.test.update')){
                $rules = [
                    'name' => 'required',
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
        ];
        return $messages;
    }
}
