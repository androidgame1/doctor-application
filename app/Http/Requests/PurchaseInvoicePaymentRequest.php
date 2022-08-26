<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
                    'purchase_invoice_id.required'=>'The purchase invoice is required !',
                    'date.required'=>'The date of payment is required !',
                    'date.date'=>'The date of payment is not correct !',
                    'given_amount.required'=>'The given amount is required !',
                    'given_amount.numeric'=>'The given amount is not numeric !',
                    'given_amount.numeric'=>'The given amount must be greater than or equal 0 !',
                    'way_of_payment.required'=>'The way of payment is required !',
                    'justification.mimes'=>'The extention of justification muust be include in (jpg,png,jpeg,gif,svg,pdf,docx) !',
        ];
        
        return $messages;
    }
}
