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

}
