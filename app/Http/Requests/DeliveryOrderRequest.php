<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class DeliveryOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.delivery_order.store') || $this->routeIs('administrator.delivery_order.update')){
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
            $rules = [
                'supplier_id'=>'required',
                'date'=>'required|date',
                'file'=>'mimes:jpg,png,jpeg,gif,svg,pdf,docx'
            ];
            if($this->routeIs('administrator.delivery_order.store')){
                $rules['series']='required|unique:delivery_orders';
            }else if($this->routeIs('administrator.delivery_order.update')){
                $rules['series']='required|unique:delivery_orders,series,'.$this->id;
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
                    'series.required'=>Lang::get('messages.the_series_is_required'),
                    'series.unique'=>Lang::get('messages.the_series_is_already_exists'),
                    'supplier_id.required'=>Lang::get('messages.the_supplier_is_required'),
                    'date.required'=>Lang::get('messages.the_date_of_payment_is_required'),
                    'file.required'=>Lang::get('messages.the_file_is_required'),
                    'file.mimes'=>Lang::get('messages.the_extention_of_file_must_be_include_in_(jpg,png,jpeg,gif,svg,pdf,docx)'),
        ];
        
        return $messages;
    }
}
