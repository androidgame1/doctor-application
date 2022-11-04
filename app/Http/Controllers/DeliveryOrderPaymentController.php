<?php

namespace App\Http\Controllers;

use App\Models\Delivery_order_payment;
use App\Models\Delivery_order;
use Illuminate\Http\Request;
use App\Http\Requests\DeliveryOrderPaymentRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Lang;

class DeliveryOrderPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($delivery_order_id="")
    {
        $user = Auth::user();
        if($delivery_order_id){
            $delivery_order = Delivery_order::findOrFail($delivery_order_id);
            $delivery_order_payments = Delivery_order_payment::orderBy('id','desc')->where(['administrator_id'=>$user->id,'delivery_order_id'=>$delivery_order->id])->get();
            $delivery_order->given_total_amount = Helper::givenAmountDeliveryOrderPayment($delivery_order->id);
            $delivery_order->remaining_total_amount = Helper::remainingAmountDeliveryOrderPayment($delivery_order->id);
        }else{
            return view('error');
        }
        return view('delivery_order_payments.delivery_order_payments',compact('delivery_order_payments','delivery_order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($delivery_order_id)
    {
        $user = Auth::user();
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$delivery_order_id])->firstOrFail();
        $delivery_order->remaining_amount = Helper::remainingAmountDeliveryOrderPayment($delivery_order->id);
        return view('delivery_order_payments.create_delivery_order_payment',compact('delivery_order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryOrderPaymentRequest $request)
    {
        $user = Auth::user();
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$request->delivery_order_id])->firstOrFail();
        $status = $delivery_order->status;
        $remainig_amount_without_new_given_amount = Helper::remainingAmountDeliveryOrderPayment($request->delivery_order_id);
        $remainig_amount_with_new_given_amount = Helper::remainingAmountDeliveryOrderPayment($request->delivery_order_id,$request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_without_new_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_without_new_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/delivery_order_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/delivery_order_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = null;
        }
        $data_delivery_order_payment = [
            'administrator_id'=>$user->id,
            'delivery_order_id'=>$delivery_order->id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($delivery_order_payment = Delivery_order_payment::create($data_delivery_order_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountDeliveryOrderPayment($delivery_order->id);
            if($delivery_order->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($delivery_order->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($delivery_order->update(['status'=>$status])){
                toastr()->success(Lang::get('messages.the_delivery_order_payment_has_inserted_by_success'));
            }else{
                toastr()->success(Lang::get('messages.the_payment_has_inserted_by_success_but_the_status_of_the_delivery_order_has_not_changed'));
            }
            
        }else{
            toastr()->warning(Lang::get('messages.the_delivery_order_payment_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.delivery_order_payments',$delivery_order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=['icon'=>'error','delivery_order_payment'=>array()];
        $user = Auth::user();
        $delivery_order_payment = Delivery_order_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $delivery_order_payment->delivery_order = $delivery_order_payment->delivery_order;
        $data=['icon'=>'success','delivery_order_payment'=>$delivery_order_payment];
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
        $delivery_order_payment = Delivery_order_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $delivery_order_payment->remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountDeliveryOrderPayment($delivery_order_payment->delivery_order_id,$delivery_order_payment->given_amount);
        return view('delivery_order_payments.edit_delivery_order_payment',compact('delivery_order_payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryOrderPaymentRequest $request, $id)
    {
        $user = Auth::user();
        $delivery_order_payment = Delivery_order_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$delivery_order_payment->delivery_order_id])->firstOrFail();
        $status = $delivery_order->status;
        $remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountDeliveryOrderPayment($request->delivery_order_id,$delivery_order_payment->given_amount);
        $remainig_amount_plus_edited_given_amount_with_new_given_amount = floatval($remainig_amount_plus_edited_given_amount) - floatval($request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_plus_edited_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_plus_edited_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/delivery_order_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/delivery_order_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = $delivery_order_payment->justification;
        }
        $data_delivery_order_payment = [
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_plus_edited_given_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($delivery_order_payment->update($data_delivery_order_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountDeliveryOrderPayment($delivery_order->id);
            if($delivery_order->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($delivery_order->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($delivery_order->update(['status'=>$status])){
                toastr()->success(Lang::get('messages.the_delivery_order_payment_has_updated_by_success'));
            }else{
                toastr()->success(Lang::get('messages.the_payment_has_updated_by_success_but_the_status_of_the_delivery_order_has_not_changed'));
            }
            
        }else{
            toastr()->warning(Lang::get('messages.the_delivery_order_payment_has_not_updated_by_success'));
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
        $delivery_order_payment = Delivery_order_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $delivery_order = $delivery_order_payment->delivery_order;
        $status = $delivery_order->status;
        if($delivery_order_payment->delete()){
            $remaining_amount = Helper::remainingAmountDeliveryOrderPayment($delivery_order->id);
            if($delivery_order->ttc_total_amount == $remaining_amount){
                $status = 0;
            }else if($delivery_order->ttc_total_amount>$remaining_amount){
                $status = 1;
            }else if($remaining_amount == 0){
                $status = 2;
            }
            $delivery_order->update(['status'=>$status]);
            toastr()->success(Lang::get('messages.the_delivery_order_payment_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_delivery_order_payment_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
