<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class PurchaseInvoicePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.purchase_invoice_payment.store') || $this->routeIs('administrator.purchase_invoice_payment.update')){
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
            if($this->routeIs('administrator.purchase_invoice_payment.store') || $this->routeIs('administrator.purchase_invoice_payment.update')){
                $rules = [
                    'purchase_invoice_id'=>'required',
                    'date'=>'required|date',
                    'given_amount'=>'required|numeric|min:0',
                    'way_of_payment' => 'required',
                    'justification'=>'mimes:jpg,png,jpeg,gif,svg,pdf,docx',
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
                    'purchase_invoice_id.required'=>Lang::get('messages.the_purchase_invoice_is_required'),
                    'date.required'=>Lang::get('messages.the_date_of_payment_is_required'),
                    'date.date'=>Lang::get('messages.the_date_of_payment_is_not_correct'),
                    'given_amount.required'=>Lang::get('messages.the_given_amount_is_required'),
                    'given_amount.numeric'=>Lang::get('messages.the_given_amount_is_not_numeric'),
                    'given_amount.min'=>Lang::get('messages.the_amount_must_be_greater_than_or_equal_0'),
                    'way_of_payment.required'=>Lang::get('messages.the_way_of_payment_is_required'),
                    'justification.mimes'=>Lang::get('messages.the_extention_of_justification_must_be_include_in_(jpg,png,jpeg,gif,svg,pdf,docx)'),
        ];
        
        return $messages;
    }
}
