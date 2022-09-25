<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class QuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validate = false;
        if($this->routeIs('administrator.quote.store') || $this->routeIs('administrator.quote.update')){
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
            if($this->routeIs('administrator.quote.store') || $this->routeIs('administrator.quote.update')){
                $rules = [
                    'series'=>'required',
                    'patient_id'=>'required',
                    'date'=>'required|date',
                    'reduction_total_amount'=>'required|numeric|min:0|max:100',
                    'ht_total_amount'=>'required|numeric|gt:0',
                    'designation'=>'required|array',
                    'designation.*'=>'required',
                    'quantity'=>'required|array',
                    'quantity.*'=>'required|numeric|gt:0',
                    'unit_price'=>'required|array',
                    'unit_price.*'=>'required|numeric|gt:0',
                    'reduction'=>'required|array',
                    'reduction.*'=>'required|numeric|min:0|max:100',
                    'reduction_amount'=>'required|array',
                    'reduction_amount.*'=>'required|numeric|gt:0',
                    'ht_amount'=>'required|array',
                    'ht_amount.*'=>'required|numeric|gt:0',
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
                    'series.required'=>Lang::get('messages.the_series_is_required'),
                    'patient_id.required'=>Lang::get('messages.the_supplier_is_required'),
                    'date.required'=>Lang::get('messages.the_date_is_required'),
                    'date.date'=>Lang::get('messages.the_date_is_not_correct'),
                    'reduction_total_amount.required'=>Lang::get('messages.the_reduction_total_amount_is_required'),
                    'reduction_total_amount.numeric'=>Lang::get('messages.the_reduction_total_amount_is_not_numéric'),
                    'reduction_total_amount.gt'=>Lang::get('messages.the_reduction_total_amount_must_be_greater_than_0'),
                    'ht_total_amount.required'=>Lang::get('messages.the_HT_total_amount_is_required'),
                    'ht_total_amount.numeric'=>Lang::get('messages.the_HT_total_amount_is_not_numéric'),
                    'ht_total_amount.gt'=>Lang::get('messages.the_HT_total_amount_must_be_greater_than_0'),
        ];
        foreach ($this->designation as $key => $value) {
            $messages['designation.'.$key.'.required'] = Lang::get('messages.the_designation_of_the_line_is_required',["index"=>($key+1)]);
            $messages['quantity.'.$key.'.required'] = Lang::get('messages.the_quantity_of_the_line_is_required',["index"=>($key+1)]);
            $messages['quantity.'.$key.'.numeric'] = Lang::get('messages.the_quantity_of_the_line_is_not_numéric',["index"=>($key+1)]);
            $messages['quantity.'.$key.'.gt'] = Lang::get('messages.the_quantity_of_the_line_must_be_greater_than_0',["index"=>($key+1)]);
            $messages['unit_price.'.$key.'.required'] = Lang::get('messages.the_unit_price_of_the_line_is_required',["index"=>($key+1)]);
            $messages['unit_price.'.$key.'.numeric'] = Lang::get('messages.the_unit_price_of_the_line_is_not_numéric',["index"=>($key+1)]);
            $messages['unit_price.'.$key.'.gt'] = Lang::get('messages.the_unit_price_of_the_line_must_be_greater_than_0',["index"=>($key+1)]);
            $messages['reduction.'.$key.'.required'] = Lang::get('messages.the_reduction_of_the_line_is_required',["index"=>($key+1)]);
            $messages['reduction.'.$key.'.numeric'] = Lang::get('messages.the_reduction_of_the_line_is_not_numéric',["index"=>($key+1)]);
            $messages['reduction.'.$key.'.min'] = Lang::get('messages.the_reduction_of_the_line_must_be_greater_or_equal_0_and_less_than_or_equal_100',["index"=>($key+1)]);
            $messages['reduction.'.$key.'.max'] = Lang::get('messages.the_reduction_of_the_line_must_be_greater_or_equal_0_and_less_than_or_equal_100',["index"=>($key+1)]);
            $messages['reduction_amount.'.$key.'.required'] = Lang::get('messages.the_reduction_amount_of_the_line_is_required',["index"=>($key+1)]);
            $messages['reduction_amount.'.$key.'.numeric'] = Lang::get('messages.the_reduction_amount_of_the_line_is_not_numéric',["index"=>($key+1)]);
            $messages['reduction_amount.'.$key.'.gt'] = Lang::get('messages.the_reduction_amount_of_the_line_must_be_greater_than_0',["index"=>($key+1)]);
            $messages['ht_amount.'.$key.'.required'] = Lang::get('messages.the_HT_mount_of_the_line_is_required',["index"=>($key+1)]);
            $messages['ht_amount.'.$key.'.numeric'] = Lang::get('messages.the_HT_mount_of_the_line_is_not_numéric',["index"=>($key+1)]);
            $messages['ht_amount.'.$key.'.gt'] = Lang::get('messages.the_HT_mount_of_the_line_must_be_greater_than_0',["index"=>($key+1)]);
        }
        return $messages;
    }
}