<?php

namespace App\Http\Controllers;

use App\Models\Purchase_invoice_payment;
use App\Models\Purchase_invoice;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseInvoicePaymentRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;

class PurchaseInvoicePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($purchase_invoice_id="")
    {
        $user = Auth::user();
        if($purchase_invoice_id){
            $purchase_invoice = Purchase_invoice::findOrFail($purchase_invoice_id);
            $purchase_invoice_payments = Purchase_invoice_payment::orderBy('id','desc')->where(['administrator_id'=>$user->id,'purchase_invoice_id'=>$purchase_invoice->id])->get();
            $purchase_invoice->given_total_amount = Helper::givenAmountPurchaseInvoicePayment($purchase_invoice->id);
            $purchase_invoice->remaining_total_amount = Helper::remainingAmountPurchaseInvoicePayment($purchase_invoice->id);
        }else{
            return view('error');
        }
        return view('purchase_invoice_payments.purchase_invoice_payments',compact('purchase_invoice_payments','purchase_invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($purchase_invoice_id)
    {
        $user = Auth::user();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$purchase_invoice_id])->firstOrFail();
        $purchase_invoice->remaining_amount = Helper::remainingAmountPurchaseInvoicePayment($purchase_invoice->id);
        return view('purchase_invoice_payments.create_purchase_invoice_payment',compact('purchase_invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseInvoicePaymentRequest $request)
    {
        $user = Auth::user();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$request->purchase_invoice_id])->firstOrFail();
        $status = $purchase_invoice->status;
        $remainig_amount_without_new_given_amount = Helper::remainingAmountPurchaseInvoicePayment($request->purchase_invoice_id);
        $remainig_amount_with_new_given_amount = Helper::remainingAmountPurchaseInvoicePayment($request->purchase_invoice_id,$request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_without_new_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_without_new_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/purchase_invoice_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/purchase_invoice_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = null;
        }
        $data_purchase_invoice_payment = [
            'administrator_id'=>$user->id,
            'purchase_invoice_id'=>$purchase_invoice->id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($purchase_invoice_payment = Purchase_invoice_payment::create($data_purchase_invoice_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountPurchaseInvoicePayment($purchase_invoice->id);
            if($purchase_invoice->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($purchase_invoice->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($purchase_invoice->update(['status'=>$status])){
                toastr()->success('The payment has inserted by success !');
            }else{
                toastr()->success('The payment has inserted by success , but the status of the purchase invoice has not changed !');
            }
            
        }else{
            toastr()->warning('The payment has not inserted by success !');
        }
        return redirect()->route('administrator.purchase_invoice_payments',$purchase_invoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=['icon'=>'error','purchase_invoice_payment'=>array()];
        $user = Auth::user();
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $purchase_invoice_payment->purchase_invoice = $purchase_invoice_payment->purchase_invoice;
        $data=['icon'=>'success','purchase_invoice_payment'=>$purchase_invoice_payment];
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
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $purchase_invoice_payment->remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountPurchaseInvoicePayment($purchase_invoice_payment->purchase_invoice_id,$purchase_invoice_payment->given_amount);
        return view('purchase_invoice_payments.edit_purchase_invoice_payment',compact('purchase_invoice_payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseInvoicePaymentRequest $request, $id)
    {
        $user = Auth::user();
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$purchase_invoice_payment->purchase_invoice_id])->firstOrFail();
        $status = $purchase_invoice->status;
        $remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountPurchaseInvoicePayment($request->purchase_invoice_id,$purchase_invoice_payment->given_amount);
        $remainig_amount_plus_edited_given_amount_with_new_given_amount = floatval($remainig_amount_plus_edited_given_amount) - floatval($request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_plus_edited_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_plus_edited_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/purchase_invoice_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/purchase_invoice_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = $purchase_invoice_payment->justification;
        }
        $data_purchase_invoice_payment = [
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_plus_edited_given_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($purchase_invoice_payment->update($data_purchase_invoice_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountPurchaseInvoicePayment($purchase_invoice->id);
            if($purchase_invoice->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($purchase_invoice->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($purchase_invoice->update(['status'=>$status])){
                toastr()->success('The payment has updated by success !');
            }else{
                toastr()->success('The payment has updated by success , but the status of the purchase invoice has not changed !');
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
        $purchase_invoice_payment = Purchase_invoice_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $purchase_invoice = $purchase_invoice_payment->purchase_invoice;
        $status = $purchase_invoice->status;
        if($purchase_invoice_payment->delete()){
            $remaining_amount = Helper::remainingAmountPurchaseInvoicePayment($purchase_invoice->id);
            if($purchase_invoice->ttc_total_amount == $remaining_amount){
                $status = 0;
            }else if($purchase_invoice->ttc_total_amount>$remaining_amount){
                $status = 1;
            }else if($remaining_amount == 0){
                $status = 2;
            }
            $purchase_invoice->update(['status'=>$status]);
            toastr()->success('The payment has deleted by success !');
        }else{
            toastr()->warning('The payment has not deleted by success !');
        }
        return redirect()->back();
    }
}
