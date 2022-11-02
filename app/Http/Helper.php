<?php

namespace App\Http;

use App\Models\Purchase_invoice;
use App\Models\Purchase_invoice_payment;
use App\Models\Sale_invoice;
use App\Models\Sale_invoice_payment;
use App\Models\Activity;
use App\Models\Activity_payment;
use App\Models\Quote;
use App\Models\Charge;
use App\Models\Charge_payment;
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

    

    function remainingAmountActivityPayment($activity_id=null,$patient_id=null,$given_amount=0,$start_date=null,$end_date=null){
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id])->where('status','<>','3');
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function($query) use ($start_date,$end_date){
                $query->where('status','<>','3');
        });
        if(!is_null($start_date) && !is_null($end_date)){
            $activity = Activity::where(['administrator_id'=>$user->id])->where('status','<>','3')->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
            $activity_payment = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function($query) use ($start_date,$end_date){
                $query->where('status','<>','3')->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
            });
        }
        if($activity_id){
            $activity = $activity->where('id',$activity_id);
            $activity_payment = $activity_payment->where('activity_id',$activity_id);
        }
        if($patient_id){
            $activity = $activity->where('patient_id',$patient_id);
            $activity_payment = $activity_payment->whereHas('activity',function($query) use ($patient_id){
                $query->where('patient_id',$patient_id);
            });
        }
        $activity = $activity->get();
        $activity_payment = $activity_payment->get();
        $remaining_amount = floatval($activity->sum('ttc_total_amount')) - floatval($activity_payment->sum('given_amount')) - floatval($given_amount);
        return $remaining_amount;
    }

    function remainingAmountPlusEditedAmountActivityPayment($activity_id=null,$patient_id=null,$given_amount=0){
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id])->get();
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id])->get();
        if($activity_id){
            $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$activity_id])->get();
            $activity_payment = Activity_payment::where(['administrator_id'=>$user->id,'activity_id'=>$activity_id])->get();
        }
        $remaining_amount = floatval($activity->sum('ttc_total_amount')) - floatval($activity_payment->sum('given_amount')) + floatval($given_amount);
        return $remaining_amount;
    }

    function givenAmountActivityPayment($activity_id=null,$patient_id=null,$start_date=null,$end_date=null){
        $user = Auth::user();
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function($query) use ($start_date,$end_date){
            $query->where('status','<>','3');
        });
        if(!is_null($start_date) && !is_null($end_date)){
            $activity_payment = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function($query) use ($start_date,$end_date){
                $query->where('status','<>','3')->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
            });
        }
        if($activity_id){
            $activity_payment = $activity_payment->where('activity_id',$activity_id);
        }
        if($patient_id){
            $activity_payment = $activity_payment->whereHas('activity',function($query) use ($patient_id){
                $query->where('patient_id',$patient_id);
            });
        }
        $activity_payment = $activity_payment->get();
        $given_amount = floatval($activity_payment->sum('given_amount'));
        return $given_amount;
    }





    function remainingAmountSaleInvoicePayment($sale_invoice_id=null,$patient_id=null,$given_amount=0,$start_date=null,$end_date=null){
        $user = Auth::user();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id])->where('status','<>','3');
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function($query) use ($start_date,$end_date){
                $query->where('status','<>','3');
            });
        if(!is_null($start_date) && !is_null($end_date)){
            $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id])->where('status','<>','3')->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
            $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function($query) use ($start_date,$end_date){
                $query->where('status','<>','3')->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
            });
        }
        if($sale_invoice_id){
            $sale_invoice = $sale_invoice->where('id',$sale_invoice_id);
            $sale_invoice_payment = $sale_invoice_payment->where('sale_invoice_id',$sale_invoice_id);
        }
        if($patient_id){
            $sale_invoice = $sale_invoice->where('patient_id',$patient_id);
            $sale_invoice_payment = $sale_invoice_payment->whereHas('sale_invoice',function($query) use ($patient_id){
                $query->where('patient_id',$patient_id);
            });
        }
        $sale_invoice = $sale_invoice->get();
        $sale_invoice_payment = $sale_invoice_payment->get();
        $remaining_amount = floatval($sale_invoice->sum('ttc_total_amount')) - floatval($sale_invoice_payment->sum('given_amount')) - floatval($given_amount);
        return $remaining_amount;
    }

    function remainingAmountPlusEditedAmountSaleInvoicePayment($sale_invoice_id=null,$given_amount=0){
        $user = Auth::user();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id])->get();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id])->get();
        if($sale_invoice_id){
            $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$sale_invoice_id])->get();
            $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id,'sale_invoice_id'=>$sale_invoice_id])->get();
        }
        $remaining_amount = floatval($sale_invoice->sum('ttc_total_amount')) - floatval($sale_invoice_payment->sum('given_amount')) + floatval($given_amount);
        return $remaining_amount;
    }

    function givenAmountSaleInvoicePayment($sale_invoice_id=null,$patient_id=null,$start_date=null,$end_date=null){
        $user = Auth::user();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function($query) use ($start_date,$end_date){
            $query->where('status','<>','3');
        });
        if(!is_null($start_date) && !is_null($end_date)){
            $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function($query) use ($start_date,$end_date){
                $query->where('status','<>','3')->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
            });
        }
        if($sale_invoice_id){
            $sale_invoice_payment = $sale_invoice_payment->where('sale_invoice_id',$sale_invoice_id);
        }
        if($patient_id){
            $sale_invoice_payment = $sale_invoice_payment->whereHas('sale_invoice',function($query) use ($patient_id){
                $query->where('patient_id',$patient_id);
            });
        }
        $sale_invoice_payment = $sale_invoice_payment->get();
        $given_amount = floatval($sale_invoice_payment->sum('given_amount'));
        return $given_amount;
    }

    function remainingAmountPurchaseInvoicePayment($purchase_invoice_id=null,$given_amount=0){
        $user = Auth::user();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id])->get();
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->get();
        if($purchase_invoice_id){
            $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$purchase_invoice_id])->get();
            $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'purchase_invoice_id'=>$purchase_invoice_id])->get();
        }
        
        $remaining_amount = floatval($purchase_invoice->sum('ttc_total_amount')) - floatval($purchase_invoice_payment->sum('given_amount')) - floatval($given_amount);
        return $remaining_amount;
    }

    function remainingAmountPlusEditedAmountPurchaseInvoicePayment($purchase_invoice_id=null,$given_amount=0){
        $user = Auth::user();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id])->get();
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->get();
        if($purchase_invoice_id){
            $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$purchase_invoice_id])->get();
            $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'purchase_invoice_id'=>$purchase_invoice_id])->get();
        }
        $remaining_amount = floatval($purchase_invoice->sum('ttc_total_amount')) - floatval($purchase_invoice_payment->sum('given_amount')) + floatval($given_amount);
        return $remaining_amount;
    }

    function givenAmountPurchaseInvoicePayment($purchase_invoice_id=null){
        $user = Auth::user();
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->get();
        if($purchase_invoice_id){
            $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'purchase_invoice_id'=>$purchase_invoice_id])->get();
        }
        $given_amount = floatval($purchase_invoice_payment->sum('given_amount'));
        return $given_amount;
    }

    function remainingAmountChargePayment($charge_id=null,$secretary_id=null,$given_amount=0,$start_date=null,$end_date=null){
        $user = Auth::user();
        $charge = Charge::where(['administrator_id'=>$user->id]);
        $charge_payment = Charge_payment::where(['administrator_id'=>$user->id]);
        if(!is_null($start_date) && !is_null($end_date)){
            $charge = Charge::where(['administrator_id'=>$user->id])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
            $charge_payment = Charge_payment::where(['administrator_id'=>$user->id])->whereHas('charge',function($query) use ($start_date,$end_date){
                $query->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
            });
        }
        if($secretary_id){
            $charge = $charge->where('secretary_id',$secretary_id);
            $charge_payment =  $charge_payment->whereHas('charge',function($query) use ($secretary_id){
                $query->where('secretary_id',$secretary_id);
            });
        }
        if($charge_id){
            $charge = $charge->where('id',$charge_id);
            $charge_payment = $charge_payment->where('charge_id',$charge_id);
        }
        $charge = $charge->get();
        $charge_payment =  $charge_payment->get();
        $remaining_amount = floatval($charge->sum('amount')) - floatval($charge_payment->sum('given_amount')) - floatval($given_amount);
        return $remaining_amount;
    }

    function remainingAmountPlusEditedAmountChargePayment($charge_id=null,$given_amount=0){
        $user = Auth::user();
        $charge = Charge::where(['administrator_id'=>$user->id])->get();
        $charge_payment = Charge_payment::where(['administrator_id'=>$user->id])->get();
        if($charge_id){
            $charge = Charge::where(['administrator_id'=>$user->id,'id'=>$charge_id])->get();
            $charge_payment = Charge_payment::where(['administrator_id'=>$user->id,'charge_id'=>$charge_id])->get();
        }
        $remaining_amount = floatval($charge->sum('amount')) - floatval($charge_payment->sum('given_amount')) + floatval($given_amount);
        return $remaining_amount;
    }

    function givenAmountchargePayment($charge_id=null,$secretary_id=null,$start_date=null,$end_date=null){
        $user = Auth::user();
        $charge_payment = Charge_payment::where(['administrator_id'=>$user->id]);
        if(!is_null($start_date) && !is_null($end_date)){
            $charge_payment = Charge_payment::where(['administrator_id'=>$user->id])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
        }
        if($secretary_id){
            $charge_payment = $charge_payment->whereHas('charge',function($query) use ($secretary_id){
                $query->where('secretary_id',$secretary_id);
            });
        }
        if($charge_id){
            $charge_payment = $charge_payment->where('charge_id',$charge_id);
        }
        $charge_payment = $charge_payment->get();
        $given_amount = floatval($charge_payment->sum('given_amount'));
        return $given_amount;
    }

    function totalActivityPayments($status,$start_date=null,$end_date=null){
        $user = Auth::user();
        $total_activity_payments = 0;
        if(!is_null($start_date) && !is_null($end_date)){
            if($status == 'canceled'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>3])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id])->where('status','<>',3)->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_activity_payments = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function(Builder $query) use ($status,$start_date,$end_date){
                    $query->whereIn('status',[1,2])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                    ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                })->get()->sum('given_amount');
            }else if($status == 'unpaid'){
                $total_activity_payments = Activity::where('administrator_id',$user->id)->whereIn('status',[0,1])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
                $total_given_amount = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function(Builder $query) use ($status,$start_date,$end_date){
                    $query->whereIn('status',[0,1])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                    ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                })->get()->sum('given_amount');
                $total_activity_payments = floatval($total_activity_payments) - floatval($total_given_amount);
            }
        }else{
            if($status == 'canceled'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>3])->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id])->where('status','<>',3)->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_activity_payments = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function(Builder $query) use ($status){
                    $query->whereIn('status',[1,2]);
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_activity_payments = Activity::where('administrator_id',$user->id)->whereIn('status',[0,1])->get()->sum('ttc_total_amount');
                $total_given_amount = Activity_payment::where(['administrator_id'=>$user->id])->whereHas('activity',function(Builder $query) use ($status){
                    $query->whereIn('status',[0,1]);
                })->get()->sum('given_amount');
                $total_activity_payments = floatval($total_activity_payments) - floatval($total_given_amount);
            }else if($status == 'unpaid'){
                $total_activity_payments = Activity::where(['administrator_id'=>$user->id,'status'=>0])->get()->sum('ttc_total_amount');
            }
        }
        return $total_activity_payments;
    }

    function totalSaleInvoicePayments($status,$start_date=null,$end_date=null){
        $user = Auth::user();
        $total_sale_invoice_payments = 0;
        if(!is_null($start_date) && !is_null($end_date)){
            if($status == 'canceled'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id,'status'=>3])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id])->where('status','<>',3)->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_sale_invoice_payments = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function(Builder $query) use ($status,$start_date,$end_date){
                    $query->whereIn('status',[1,2])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                    ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                })->get()->sum('given_amount');
            }else if($status == 'unpaid'){
                $total_sale_invoice_payments = Sale_invoice::where('administrator_id',$user->id)->whereIn('status',[0,1])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
                $total_given_amount = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function(Builder $query) use ($status,$start_date,$end_date){
                    $query->whereIn('status',[0,1])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                    ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                })->get()->sum('given_amount');
                $total_sale_invoice_payments = floatval($total_sale_invoice_payments) - floatval($total_given_amount);
            }
        }else{
            if($status == 'canceled'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id,'status'=>3])->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_sale_invoice_payments = Sale_invoice::where(['administrator_id'=>$user->id])->where('status','<>',3)->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_sale_invoice_payments = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function(Builder $query) use ($status){
                    $query->whereIn('status',[1,2]);
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_sale_invoice_payments = Sale_invoice::where('administrator_id',$user->id)->whereIn('status',[0,1])->get()->sum('ttc_total_amount');
                $total_given_amount = Sale_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('sale_invoice',function(Builder $query) use ($status){
                    $query->whereIn('status',[0,1]);
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
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>3])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
            }else if($status == 'activated'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id])->where('status','<>',3)->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
            }else if($status == 'paid'){
                $total_purchase_invoice_payments = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('purchase_invoice',function(Builder $query) use ($status){
                    $query->where('status',2)->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                    ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                })->get()->sum('given_amount');
            }else if($status == 'partiel'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>1])->get()->sum('ttc_total_amount');
                $total_given_amount = Purchase_invoice_payment::where(['administrator_id'=>$user->id])->whereHas('purchase_invoice',function(Builder $query) use ($status){
                    $query->where('status',1)->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                    ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                })->get()->sum('given_amount');
                $total_purchase_invoice_payments = floatval($total_purchase_invoice_payments) - floatval($total_given_amount);
            }else if($status == 'unpaid'){
                $total_purchase_invoice_payments = Purchase_invoice::where(['administrator_id'=>$user->id,'status'=>0])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%")->get()->sum('ttc_total_amount');
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

    function totalChargePayments($status,$secretary_id=null,$start_date=null,$end_date=null){
        $user = Auth::user();
        $total_charge_payments = 0;
        if(!is_null($start_date) && !is_null($end_date)){
            if($status == 'canceled'){
                $total_charge_payments = Charge::where(['administrator_id'=>$user->id,'status'=>3])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                if($secretary_id){
                    $total_charge_payments->where('secretary_id',$secretary_id);
                }
                $total_charge_payments = $total_charge_payments->get()->sum('amount');
            }else if($status == 'activated'){
                $total_charge_payments = Charge::where(['administrator_id'=>$user->id])->where('status','<>',3)->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                if($secretary_id){
                    $total_charge_payments->where('secretary_id',$secretary_id);
                }
                $total_charge_payments = $total_charge_payments->get()->sum('amount');
            }else if($status == 'paid'){
                $total_charge_payments = Charge_payment::where(['administrator_id'=>$user->id])->whereHas('charge',function(Builder $query) use ($status,$secretary_id,$start_date,$end_date){
                     if($secretary_id){
                        $query->where('secretary_id',$secretary_id);
                    }
                    $query->where('status',2)->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                    ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                })->get()->sum('given_amount');
            }else if($status == 'paid'){
                $total_charge_payments = Charge::where('administrator_id',$user->id)->whereIn('status',[0,1])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                if($secretary_id){
                    $total_charge_payments->where('secretary_id',$secretary_id);
                }
                $total_charge_payments = $total_charge_payments->get()->sum('amount');
                $total_given_amount = Charge_payment::where(['administrator_id'=>$user->id])->whereHas('charge',function(Builder $query) use ($status,$secretary_id,$start_date,$end_date){
                        if($secretary_id){
                            $query->where('secretary_id',$secretary_id);
                        }
                        $query->whereIn('status',[0,1])->whereDate('created_at','>=',Carbon::parse($start_date)->format('Y-m-d')."%")
                        ->whereDate('created_at','<=',Carbon::parse($end_date)->format('Y-m-d')."%");
                    })->get()->sum('given_amount');
                $total_charge_payments = floatval($total_charge_payments) - floatval($total_given_amount);
            }
        }else{
            if($status == 'canceled'){
                $total_charge_payments = Charge::where(['administrator_id'=>$user->id,'status'=>3]);
                if($secretary_id){
                    $total_charge_payments->where('secretary_id',$secretary_id);
                }
                $total_charge_payments = $total_charge_payments->get()->sum('amount');
            }else if($status == 'activated'){
                $total_charge_payments = Charge::where(['administrator_id'=>$user->id])->where('status','<>',3);
                if($secretary_id){
                    $total_charge_payments->where('secretary_id',$secretary_id);
                }
                $total_charge_payments = $total_charge_payments->get()->sum('amount');
            }else if($status == 'paid'){
                $total_charge_payments = Charge_payment::where(['administrator_id'=>$user->id])->whereHas('charge',function(Builder $query) use ($status,$secretary_id){
                    if($secretary_id){
                        $query->where('secretary_id',$secretary_id);
                    }
                    $query->whereIn('status',[1,2]);
                })->get()->sum('given_amount');
            }else if($status == 'unpaid'){
                $total_charge_payments = Charge::where('administrator_id',$user->id)->whereIn('status',[0,1]);
                if($secretary_id){
                    $total_charge_payments->where('secretary_id',$secretary_id);
                }
                $total_charge_payments = $total_charge_payments->get()->sum('amount');
                $total_given_amount = Charge_payment::where(['administrator_id'=>$user->id])->whereHas('charge',function(Builder $query) use ($status,$secretary_id){
                    if($secretary_id){
                        $query->where('secretary_id',$secretary_id);
                    }
                    $query->whereIn('status',[0,1]);
                })->get()->sum('given_amount');
               
                $total_charge_payments = floatval($total_charge_payments) - floatval($total_given_amount);
            }
        }
        return $total_charge_payments;
    }

}
