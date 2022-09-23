<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class PurchaseOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.purchase_order.store') || $this->routeIs('administrator.purchase_order.update')){
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
            if($this->routeIs('administrator.purchase_order.store') || $this->routeIs('administrator.purchase_order.update')){
                $rules = [
                    'supplier_id' => 'required',
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
            'supplier_id.required'=>Lang::get('messages.the_supplier_is_required'),
            'date.required'=>Lang::get('messages.the_date_is_required'),
            'date.date'=>Lang::get('messages.the_date_is_not_correct'),
            'note.required'=>Lang::get('messages.the_note_is_required'),
        ];
        return $messages;
    }
}
