<?php

namespace App\Http\Controllers;

use App\Models\Charge_payment;
use App\Models\Charge;
use Illuminate\Http\Request;
use App\Http\Requests\ChargePaymentRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Lang;

class ChargePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($charge_id="")
    {
        $user = Auth::user();
        if($charge_id){
            $charge = Charge::findOrFail($charge_id);
            $charge_payments = Charge_payment::orderBy('id','desc')->where(['administrator_id'=>$user->id,'charge_id'=>$charge->id])->get();
            $charge->given_total_amount = Helper::givenAmountChargePayment($charge->id);
            $charge->remaining_total_amount = Helper::remainingAmountChargePayment($charge->id);
        }else{
            return view('error');
        }
        return view('charge_payments.charge_payments',compact('charge_payments','charge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($charge_id)
    {
        $user = Auth::user();
        $charge = Charge::where(['administrator_id'=>$user->id,'id'=>$charge_id])->firstOrFail();
        $charge->remaining_amount = Helper::remainingAmountChargePayment($charge->id);
        return view('charge_payments.create_charge_payment',compact('charge'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChargePaymentRequest $request)
    {
        $user = Auth::user();
        $charge = Charge::where(['administrator_id'=>$user->id,'id'=>$request->charge_id])->firstOrFail();
        $status = $charge->status;
        $remainig_amount_without_new_given_amount = Helper::remainingAmountChargePayment($request->charge_id);
        $remainig_amount_with_new_given_amount = Helper::remainingAmountChargePayment($request->charge_id,$request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_without_new_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_without_new_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/charge_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/charge_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = null;
        }
        $data_charge_payment = [
            'administrator_id'=>$user->id,
            'charge_id'=>$charge->id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($charge_payment = Charge_payment::create($data_charge_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountChargePayment($charge->id);
            if($charge->amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($charge->amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($charge->update(['status'=>$status])){
                toastr()->success(Lang::get('messages.the_charge_payment_has_inserted_by_success'));
            }else{
                toastr()->success(Lang::get('messages.the_payment_has_inserted_by_success_but_the_status_of_the_charge_has_not_changed'));
            }
            
        }else{
            toastr()->warning(Lang::get('messages.the_charge_payment_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.charge_payments',$charge->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=['icon'=>'error','charge_payment'=>array()];
        $user = Auth::user();
        $charge_payment = Charge_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $charge_payment->charge = $charge_payment->charge;
        $charge_payment->way_of_payment = $charge_payment->way_of_payment_name;
        $data=['icon'=>'success','charge_payment'=>$charge_payment];
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
        $charge_payment = Charge_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $charge_payment->remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountSaleInvoicePayment($charge_payment->charge_id,$charge_payment->given_amount);
        return view('charge_payments.edit_charge_payment',compact('charge_payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChargePaymentRequest $request, $id)
    {
        $user = Auth::user();
        $charge_payment = Charge_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $charge = Charge::where(['administrator_id'=>$user->id,'id'=>$charge_payment->charge_id])->firstOrFail();
        $status = $charge->status;
        $remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountSaleInvoicePayment($request->charge_id,$charge_payment->given_amount);
        $remainig_amount_plus_edited_given_amount_with_new_given_amount = floatval($remainig_amount_plus_edited_given_amount) - floatval($request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_plus_edited_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_plus_edited_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/charge_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/charge_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = $charge_payment->justification;
        }
        $data_charge_payment = [
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_plus_edited_given_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($charge_payment->update($data_charge_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountChargePayment($charge->id);
            if($charge->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($charge->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($charge->update(['status'=>$status])){
                toastr()->success(Lang::get('messages.the_charge_payment_has_updated_by_success'));
            }else{
                toastr()->success(Lang::get('messages.the_payment_has_updated_by_success_but_the_status_of_the_charge_has_not_changed'));
            }
            
        }else{
            toastr()->warning(Lang::get('messages.the_charge_payment_has_not_updated_by_success'));
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
        $charge_payment = Charge_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $charge = $charge_payment->charge;
        $status = $charge->status;
        if($charge_payment->delete()){
            $remaining_amount = Helper::remainingAmountChargePayment($charge->id);
            if($charge->ttc_total_amount == $remaining_amount){
                $status = 0;
            }else if($charge->ttc_total_amount>$remaining_amount){
                $status = 1;
            }else if($remaining_amount == 0){
                $status = 2;
            }
            $charge->update(['status'=>$status]);
            toastr()->success(Lang::get('messages.the_charge_payment_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_charge_payment_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
