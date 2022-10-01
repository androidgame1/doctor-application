<?php

namespace App\Http;

use App\Models\Purchase_invoice;
use App\Models\Purchase_invoice_payment;
use App\Models\Sale_invoice;
use App\Models\Sale_invoice_payment;
use App\Models\Activity;
use App\Models\Quote;
use App\Models\Activity_payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Helper{

    public static function seriesPurchaseInvoice(){
        $user = Auth::user();
        $series = "F-0001";
        if(Purchase_invoice::where('administrator_id',$user->id)->exists()){
            $last_purchase_invoice = Purchase_invoice::orderBy('id','desc')->where('administrator_id',$user->id)->firstOrFail();
            $cut_series = explode('-',$last_purchase_invoice->series);
            $length_id = strlen(intval($cut_series[1]));
            $next_id =intval($cut_series[1]) + 1;
            $length_zero =  ((4 - intval($length_id)) >=0 ? (4 - intval($length_id)) : 0);
            $zero = "";
            for ($i=0; $i < intval($length_zero); $i++) { 
                $zero.="0";
            }
            $series = "F-".$zero.$next_id;
        }
        return $series; 
        
    }

    public static function seriesSaleInvoice(){
        $user = Auth::user();
        $series = "F-0001";
        if(Sale_invoice::where('administrator_id',$user->id)->exists()){
            $last_sale_invoice = Sale_invoice::orderBy('id','desc')->where('administrator_id',$user->id)->firstOrFail();
            $cut_series = explode('-',$last_sale_invoice->series);
            $length_id = strlen(intval($cut_series[1]));
            $next_id =intval($cut_series[1]) + 1;
            $length_zero =  ((4 - intval($length_id)) >=0 ? (4 - intval($length_id)) : 0);
            $zero = "";
            for ($i=0; $i < intval($length_zero); $i++) { 
                $zero.="0";
            }
            $series = "F-".$zero.$next_id;
        }
        return $series; 
        
    }

    public static function seriesActivity(){
        $user = Auth::user();
        $series = "A-0001";
        if(Activity::where('administrator_id',$user->id)->exists()){
            $last_activity = Activity::orderBy('id','desc')->where('administrator_id',$user->id)->firstOrFail();
            $cut_series = explode('-',$last_activity->series);
            $length_id = strlen(intval($cut_series[1]));
            $next_id =intval($cut_series[1]) + 1;
            $length_zero =  ((4 - intval($length_id)) >=0 ? (4 - intval($length_id)) : 0);
            $zero = "";
            for ($i=0; $i < intval($length_zero); $i++) { 
                $zero.="0";
            }
            $series = "A-".$zero.$next_id;
        }
        return $series; 
        
    }

    public static function seriesQuote(){
        $user = Auth::user();
        $series = "D-0001";
        if(Quote::where('administrator_id',$user->id)->exists()){
            $last_quote = Quote::orderBy('id','desc')->where('administrator_id',$user->id)->firstOrFail();
            $cut_series = explode('-',$last_quote->series);
            $length_id = strlen(intval($cut_series[1]));
            $next_id =intval($cut_series[1]) + 1;
            $length_zero =  ((4 - intval($length_id)) >=0 ? (4 - intval($length_id)) : 0);
            $zero = "";
            for ($i=0; $i < intval($length_zero); $i++) { 
                $zero.="0";
            }
            $series = "D-".$zero.$next_id;
        }
        return $series; 
        
    }

    function remainingAmountActivityPayment($activity_id,$given_amount=0){
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$activity_id])->firstOrFail();
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id,'activity_id'=>$activity_id])->get();
        $remaining_amount = floatval($activity->ht_total_amount) - floatval($activity_payment->sum('given_amount')) - floatval($given_amount);
        return $remaining_amount;
    }

    function remainingAmountPlusEditedAmountActivityPayment($activity_id,$given_amount=0){
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$activity_id])->firstOrFail();
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id,'activity_id'=>$activity_id])->get();
        $remaining_amount = floatval($activity->ht_total_amount) - floatval($activity_payment->sum('given_amount')) + floatval($given_amount);
        return $remaining_amount;
    }

    function givenAmountActivityPayment($activity_id){
        $user = Auth::user();
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id,'activity_id'=>$activity_id])->get();
        $given_amount = floatval($activity_payment->sum('given_amount'));
        return $given_amount;
    }

    function remainingAmountSaleInvoicePayment($sale_invoice_id,$given_amount=0){
        $user = Auth::user();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$sale_invoice_id])->firstOrFail();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id,'sale_invoice_id'=>$sale_invoice_id])->get();
        $remaining_amount = floatval($sale_invoice->ttc_total_amount) - floatval($sale_invoice_payment->sum('given_amount')) - floatval($given_amount);
        return $remaining_amount;
    }

    function remainingAmountPlusEditedAmountSaleInvoicePayment($sale_invoice_id,$given_amount=0){
        $user = Auth::user();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$sale_invoice_id])->firstOrFail();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id,'sale_invoice_id'=>$sale_invoice_id])->get();
        $remaining_amount = floatval($sale_invoice->ttc_total_amount) - floatval($sale_invoice_payment->sum('given_amount')) + floatval($given_amount);
        return $remaining_amount;
    }

    function givenAmountSaleInvoicePayment($sale_invoice_id){
        $user = Auth::user();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id,'sale_invoice_id'=>$sale_invoice_id])->get();
        $given_amount = floatval($sale_invoice_payment->sum('given_amount'));
        return $given_amount;
    }

    function remainingAmountPurchaseInvoicePayment($purchase_invoice_id,$given_amount=0){
        $user = Auth::user();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$purchase_invoice_id])->firstOrFail();
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'purchase_invoice_id'=>$purchase_invoice_id])->get();
        $remaining_amount = floatval($purchase_invoice->ttc_total_amount) - floatval($purchase_invoice_payment->sum('given_amount')) - floatval($given_amount);
        return $remaining_amount;
    }

    function remainingAmountPlusEditedAmountPurchaseInvoicePayment($purchase_invoice_id,$given_amount=0){
        $user = Auth::user();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$purchase_invoice_id])->firstOrFail();
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'purchase_invoice_id'=>$purchase_invoice_id])->get();
        $remaining_amount = floatval($purchase_invoice->ttc_total_amount) - floatval($purchase_invoice_payment->sum('given_amount')) + floatval($given_amount);
        return $remaining_amount;
    }

    function givenAmountPurchaseInvoicePayment($purchase_invoice_id){
        $user = Auth::user();
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'purchase_invoice_id'=>$purchase_invoice_id])->get();
        $given_amount = floatval($purchase_invoice_payment->sum('given_amount'));
        return $given_amount;
    }

    function totalActivityPayments($status,$start_date=null,$end_date=null){
        $user = Auth::user();
        $total_activity_payments = 0;
        if(!is_null($start_date) && !is_null($end_date)){
            if($status == 'canceled'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>3])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ht_total_amount');
            }else if($status == 'activated'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->where('status','<>',3)->get()->sum('ht_total_amount');
            }else if($status == 'paid'){
                $total_activity_payments = Activity_payment::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->whereHas('activity',function(Builder $query) use ($status){
                    $query->where('status',2);
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>1])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ht_total_amount');
                $total_given_amount = Activity_payment::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->whereHas('activity',function(Builder $query) use ($status){
                    $query->where('status',1);
                })->get()->sum('given_amount');
                $total_activity_payments = floatval($total_activity_payments) - floatval($total_given_amount);
            }else if($status == 'unpaid'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>0])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ht_total_amount');
            }
        }else{
            if($status == 'canceled'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>3])->get()->sum('ht_total_amount');
            }else if($status == 'activated'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id])->where('status','<>',3)->get()->sum('ht_total_amount');
            }else if($status == 'paid'){
                $total_activity_payments = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function(Builder $query) use ($status){
                    $query->where('status',2);
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>1])->get()->sum('ht_total_amount');
                $total_given_amount = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function(Builder $query) use ($status){
                    $query->where('status',1);
                })->get()->sum('given_amount');
                $total_activity_payments = floatval($total_activity_payments) - floatval($total_given_amount);
            }else if($status == 'unpaid'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>0])->get()->sum('ht_total_amount');
            }
        }
        return $total_activity_payments;
    }

    function totalSaleInvoicePayments($status,$start_date=null,$end_date=null){
        $user = Auth::user();
        $total_sale_invoice_payments = 0;
        if(!is_null($start_date) && !is_null($end_date)){
            if($status == 'canceled'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id,'status'=>3])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id])->where('status','<>',3)->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_sale_invoice_payments = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->whereHas('sale_invoice',function(Builder $query) use ($status){
                    $query->where('status',2);
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id,'status'=>1])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ttc_total_amount');
                $total_given_amount = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->whereHas('sale_invoice',function(Builder $query) use ($status){
                    $query->where('status',1);
                })->get()->sum('given_amount');
                $total_sale_invoice_payments = floatval($total_sale_invoice_payments) - floatval($total_given_amount);
            }else if($status == 'unpaid'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id,'status'=>0])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ttc_total_amount');
            }
        }else{
            if($status == 'canceled'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id,'status'=>3])->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id])->where('status','<>',3)->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_sale_invoice_payments = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function(Builder $query) use ($status){
                    $query->where('status',2);
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id,'status'=>1])->get()->sum('ttc_total_amount');
                $total_given_amount = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function(Builder $query) use ($status){
                    $query->where('status',1);
                })->get()->sum('given_amount');
                $total_sale_invoice_payments = floatval($total_sale_invoice_payments) - floatval($total_given_amount);
            }else if($status == 'unpaid'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id,'status'=>0])->get()->sum('ttc_total_amount');
            }
        }
        return $total_sale_invoice_payments;
    }

    function totalPurchaseInvoicePayments($status,$start_date=null,$end_date=null){
        $user = Auth::user();
        $total_purchase_invoice_payments = 0;
        if(!is_null($start_date) && !is_null($end_date)){
            if($status == 'canceled'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>3])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id])->where('status','<>',3)->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_purchase_invoice_payments = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->whereHas('purchase_invoice',function(Builder $query) use ($status){
                    $query->where('status',2);
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>1])->get()->sum('ttc_total_amount');
                $total_given_amount = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->whereHas('purchase_invoice',function(Builder $query) use ($status){
                    $query->where('status',1);
                })->get()->sum('given_amount');
                $total_purchase_invoice_payments = floatval($total_purchase_invoice_payments) - floatval($total_given_amount);
            }else if($status == 'unpaid'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>0])->whereBetween('created_at',[Carbon::parse($start_date)->format('Y-m-d')."%",Carbon::parse($end_date)->format('Y-m-d')."%"])->get()->sum('ttc_total_amount');
            }
        }else{
            if($status == 'canceled'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>3])->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id])->where('status','<>',3)->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_purchase_invoice_payments = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('purchase_invoice',function(Builder $query) use ($status){
                    $query->where('status',2);
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>1])->get()->sum('ttc_total_amount');
                $total_given_amount = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('purchase_invoice',function(Builder $query) use ($status){
                    $query->where('status',1);
                })->get()->sum('given_amount');
                $total_purchase_invoice_payments = floatval($total_purchase_invoice_payments) - floatval($total_given_amount);
            }else if($status == 'unpaid'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>0])->get()->sum('ttc_total_amount');
            }
        }
        
        return $total_purchase_invoice_payments;
    }

}
