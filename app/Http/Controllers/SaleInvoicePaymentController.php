<?php

namespace App\Http\Controllers;

use App\Models\Sale_invoice_payment;
use App\Models\Sale_invoice;
use Illuminate\Http\Request;
use App\Http\Requests\SaleInvoicePaymentRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;

class SaleInvoicePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sale_invoice_id="")
    {
        $user = Auth::user();
        if($sale_invoice_id){
            $sale_invoice = Sale_invoice::findOrFail($sale_invoice_id);
            $sale_invoice_payments = Sale_invoice_payment::orderBy('id','desc')->where(['administrator_id'=>$user->id,'sale_invoice_id'=>$sale_invoice->id])->get();
            $sale_invoice->given_total_amount = Helper::givenAmountSaleInvoicePayment($sale_invoice->id);
            $sale_invoice->remaining_total_amount = Helper::remainingAmountSaleInvoicePayment($sale_invoice->id);
        }else{
            return view('error');
        }
        return view('sale_invoice_payments.sale_invoice_payments',compact('sale_invoice_payments','sale_invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($sale_invoice_id)
    {
        $user = Auth::user();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$sale_invoice_id])->firstOrFail();
        $sale_invoice->remaining_amount = Helper::remainingAmountSaleInvoicePayment($sale_invoice->id);
        return view('sale_invoice_payments.create_sale_invoice_payment',compact('sale_invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleInvoicePaymentRequest $request)
    {
        $user = Auth::user();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$request->sale_invoice_id])->firstOrFail();
        $status = $sale_invoice->status;
        $remainig_amount_without_new_given_amount = Helper::remainingAmountSaleInvoicePayment($request->sale_invoice_id);
        $remainig_amount_with_new_given_amount = Helper::remainingAmountSaleInvoicePayment($request->sale_invoice_id,$request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_without_new_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_without_new_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/sale_invoice_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/sale_invoice_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = null;
        }
        $data_sale_invoice_payment = [
            'administrator_id'=>$user->id,
            'sale_invoice_id'=>$sale_invoice->id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($sale_invoice_payment = Sale_invoice_payment::create($data_sale_invoice_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountSaleInvoicePayment($sale_invoice->id);
            if($sale_invoice->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($sale_invoice->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($sale_invoice->update(['status'=>$status])){
                toastr()->success('The payment has inserted by success !');
            }else{
                toastr()->success('The payment has inserted by success , but the status of the sale invoice has not changed !');
            }
            
        }else{
            toastr()->warning('The payment has not inserted by success !');
        }
        return redirect()->route('administrator.sale_invoice_payments',$sale_invoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=['icon'=>'error','sale_invoice_payment'=>array()];
        $user = Auth::user();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $sale_invoice_payment->sale_invoice = $sale_invoice_payment->sale_invoice;
        $data=['icon'=>'success','sale_invoice_payment'=>$sale_invoice_payment];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $sale_invoice_payment->remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountSaleInvoicePayment($sale_invoice_payment->sale_invoice_id,$sale_invoice_payment->given_amount);
        return view('sale_invoice_payments.edit_sale_invoice_payment',compact('sale_invoice_payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaleInvoicePaymentRequest $request, $id)
    {
        $user = Auth::user();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$sale_invoice_payment->sale_invoice_id])->firstOrFail();
        $status = $sale_invoice->status;
        $remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountSaleInvoicePayment($request->sale_invoice_id,$sale_invoice_payment->given_amount);
        $remainig_amount_plus_edited_given_amount_with_new_given_amount = floatval($remainig_amount_plus_edited_given_amount) - floatval($request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_plus_edited_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_plus_edited_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/sale_invoice_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/sale_invoice_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = $sale_invoice_payment->justification;
        }
        $data_sale_invoice_payment = [
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_plus_edited_given_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($sale_invoice_payment->update($data_sale_invoice_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountSaleInvoicePayment($sale_invoice->id);
            if($sale_invoice->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($sale_invoice->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($sale_invoice->update(['status'=>$status])){
                toastr()->success('The payment has updated by success !');
            }else{
                toastr()->success('The payment has updated by success , but the status of the sale invoice has not changed !');
            }
            
        }else{
            toastr()->warning('The payment has not updated by success !');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $sale_invoice_payment = Sale_invoice_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $sale_invoice = $sale_invoice_payment->sale_invoice;
        $status = $sale_invoice->status;
        if($sale_invoice_payment->delete()){
            $remaining_amount = Helper::remainingAmountSaleInvoicePayment($sale_invoice->id);
            if($sale_invoice->ttc_total_amount == $remaining_amount){
                $status = 0;
            }else if($sale_invoice->ttc_total_amount>$remaining_amount){
                $status = 1;
            }else if($remaining_amount == 0){
                $status = 2;
            }
            $sale_invoice->update(['status'=>$status]);
            toastr()->success('The payment has deleted by success !');
        }else{
            toastr()->warning('The payment has not deleted by success !');
        }
        return redirect()->back();
    }
}
