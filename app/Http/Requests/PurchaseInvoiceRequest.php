<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.purchase_invoice.store') || $this->routeIs('administrator.purchase_invoice.update')){
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
            if($this->routeIs('administrator.purchase_invoice.store') || $this->routeIs('administrator.purchase_invoice.update')){
                $rules = [
                    'series'=>'required',
                    'supplier_id'=>'required',
                    'date'=>'required|date',
                    'reduction_total_amount'=>'required|numeric|min:0|max:100',
                    'ht_total_amount'=>'required|numeric|gt:0',
                    'tva_total_amount'=>'required|numeric|min:0|max:100',
                    'ttc_total_amount'=>'required|numeric|gt:0',
                    'designation'=>'required|array',
                    'designation.*'=>'required',
                    'quantity'=>'required|array',
                    'quantity.*'=>'required|numeric|gt:0',
                    'unit_price'=>'required|array',
                    'unit_price.*'=>'required|numeric|gt:0',
                    'reduction_amount'=>'required|array',
                    'reduction_amount.*'=>'required|numeric|min:0|max:100',
                    'ht_amount'=>'required|array',
                    'ht_amount.*'=>'required|numeric|gt:0',
                    'tva_amount'=>'required|array',
                    'tva_amount.*'=>'required|numeric|min:0|max:100',
                    'ttc_amount'=>'required|array',
                    'ttc_amount.*'=>'required|numeric|gt:0',
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
                    'series.required'=>'The series is required !',
                    'supplier_id.required'=>'The supplier is required !',
                    'date.required'=>'The date is required !',
                    'date.date'=>'The date is not correct !',
                    'reduction_total_amount.required'=>'The reduction total amount is required !',
                    'reduction_total_amount.numeric'=>'The reduction total amount is not numéric !',
                    'reduction_total_amount.min'=>'The reduction total amount must be greater or equal 0 and less than or equal 100 !',
                    'reduction_total_amount.max'=>'The reduction total amount must be greater or equal 0 and less than or equal 100 !',
                    'ht_total_amount.required'=>'The HT total amount is required !',
                    'ht_total_amount.numeric'=>'The HT total amount is not numéric !',
                    'ht_total_amount.gt'=>'The HT total amount must be greater than 0 !',
                    'tva_total_amount.required'=>'The TVA total amount is required !',
                    'tva_total_amount.numeric'=>'The TVA total amount is not numéric !',
                    'tva_total_amount.min'=>'The TVA total amount must be greater or equal 0 and less than or equal 100h !',
                    'tva_total_amount.max'=>'The TVA total amount must be greater or equal 0 and less than or equal 100h !',
                    'ttc_total_amount.required'=>'The TTC total amount is required !',
                    'ttc_total_amount.numeric'=>'The TTC total amount is numéric !',
                    'ttc_total_amount.gt'=>'The TTC total amount must be greater than 0 !',
        ];
        foreach ($this->designation as $key => $value) {
            $messages['designation.'.$key.'.required'] = "The designation of the line ".($key+1)." is required !";
            $messages['quantity.'.$key.'.required'] = "The quantity of the line ".($key+1)." is required !";
            $messages['quantity.'.$key.'.numeric'] = "The quantity of the line ".($key+1)." is not numéric !";
            $messages['quantity.'.$key.'.gt'] = "The quantity of the line ".($key+1)." must be greater than 0 !";
            $messages['unit_price.'.$key.'.required'] = "The unit price of the line ".($key+1)." is required !";
            $messages['unit_price.'.$key.'.numeric'] = "The unit price of the line ".($key+1)." is not numéric !";
            $messages['unit_price.'.$key.'.gt'] = "The unit price of the line ".($key+1)." must be greater than 0 !";
            $messages['reduction_amount.'.$key.'.required'] = "The quantity of the line ".($key+1)." is required !";
            $messages['reduction_amount.'.$key.'.numeric'] = "The quantity of the line ".($key+1)." is not numéric !";
            $messages['reduction_amount.'.$key.'.min'] = "The reduction amount of the line ".($key+1)." must be greater or equal 0 and less than or equal 100 !";
            $messages['reduction_amount.'.$key.'.max'] = "The reduction amount of the line ".($key+1)." must be greater or equal 0 and less than or equal 100 !";
            $messages['ht_amount.'.$key.'.required'] = "The HT amount of the line ".($key+1)." is required !";
            $messages['ht_amount.'.$key.'.numeric'] = "The HT amount of the line ".($key+1)." is not numéric !";
            $messages['ht_amount.'.$key.'.gt'] = "The HT amount of the line ".($key+1)." must be greater than 0 !";
            $messages['tva_amount.'.$key.'.required'] = "The TVA amount of the line ".($key+1)." is required !";
            $messages['tva_amount.'.$key.'.numeric'] = "The TVA amount of the line ".($key+1)." is not numéric !";
            $messages['tva_amount.'.$key.'.min'] = "The TVA amount of the line ".($key+1)." must be greater or equal 0 and less than or equal 100 !";
            $messages['tva_amount.'.$key.'.max'] = "The TVA amount of the line ".($key+1)." must be greater or equal 0 and less than or equal 100 !";
            $messages['ttc_amount.'.$key.'.required'] = "The TTC amount of the line ".($key+1)." is required !";
            $messages['ttc_amount.'.$key.'.numeric'] = "The TTC amount of the line ".($key+1)." is not numéric !";
            $messages['ttc_amount.'.$key.'.gt'] = "The TTC amount of the line ".($key+1)." must be greater than 0 !";
        }
        return $messages;
    }
}