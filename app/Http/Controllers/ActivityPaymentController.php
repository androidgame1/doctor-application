<?php

namespace App\Http\Controllers;

use App\Models\Activity_payment;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Requests\ActivityPaymentRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Lang;

class ActivityPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($activity_id="")
    {
        $user = Auth::user();
        if($activity_id){
            $activity = Activity::findOrFail($activity_id);
            $activity_payments = Activity_payment::orderBy('id','desc')->where(['administrator_id'=>$user->id,'activity_id'=>$activity->id])->get();
            $activity->given_total_amount = Helper::givenAmountActivityPayment($activity->id);
            $activity->remaining_total_amount = Helper::remainingAmountActivityPayment($activity->id);
        }else{
            return view('error');
        }
        return view('activity_payments.activity_payments',compact('activity_payments','activity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($activity_id)
    {
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$activity_id])->firstOrFail();
        $activity->remaining_amount = Helper::remainingAmountActivityPayment($activity->id);
        return view('activity_payments.create_activity_payment',compact('activity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityPaymentRequest $request)
    {
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$request->activity_id])->firstOrFail();
        $status = $activity->status;
        $remainig_amount_without_new_given_amount = Helper::remainingAmountActivityPayment($request->activity_id);
        $remainig_amount_with_new_given_amount = Helper::remainingAmountActivityPayment($request->activity_id,$request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_without_new_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_without_new_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/activity_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/activity_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = null;
        }
        $data_activity_payment = [
            'administrator_id'=>$user->id,
            'activity_id'=>$activity->id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($activity_payment = Activity_payment::create($data_activity_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountActivityPayment($activity->id);
            if($activity->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($activity->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($activity->update(['status'=>$status])){
                toastr()->success(Lang::get('messages.the_activity_payment_has_inserted_by_success'));
            }else{
                toastr()->success(Lang::get('messages.the_payment_has_inserted_by_success_but_the_status_of_the_activity_has_not_changed'));
            }
            
        }else{
            toastr()->warning(Lang::get('messages.the_activity_payment_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.activity_payments',$activity->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=['icon'=>'error','activity_payment'=>array()];
        $user = Auth::user();
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $activity_payment->activity = $activity_payment->activity;
        $activity_payment->way_of_payment = $activity_payment->way_of_payment_name;
        $data=['icon'=>'success','activity_payment'=>$activity_payment];
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
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $activity_payment->remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountActivityPayment($activity_payment->activity_id,$activity_payment->given_amount);
        return view('activity_payments.edit_activity_payment',compact('activity_payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityPaymentRequest $request, $id)
    {
        $user = Auth::user();
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$activity_payment->activity_id])->firstOrFail();
        $status = $activity->status;
        $remainig_amount_plus_edited_given_amount = Helper::remainingAmountPlusEditedAmountActivityPayment($request->activity_id,$activity_payment->given_amount);
        $remainig_amount_plus_edited_given_amount_with_new_given_amount = floatval($remainig_amount_plus_edited_given_amount) - floatval($request->given_amount);
        if(!($request->given_amount >=0 && $request->given_amount <= $remainig_amount_plus_edited_given_amount)){
            toastr()->warning('The given amount must be greater that 0 and less than or equal '.$remainig_amount_plus_edited_given_amount);
        }
        if($request->hasfile('justification')){
            $file = $request->file('justification');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/activity_payments/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/activity_payments/file_administrator_".$user->id,$filename);
            $request->justification = $filename;
        }else{
            $request->justification = $activity_payment->justification;
        }
        $data_activity_payment = [
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'given_amount'=>$request->given_amount,
            'remaining_amount'=>$remainig_amount_plus_edited_given_amount_with_new_given_amount,
            'way_of_payment' => $request->way_of_payment,
            'remark' => $request->remark,
            'justification'=>$request->justification,
        ];
        if($activity_payment->update($data_activity_payment)){
            $given_amount_with_new_given_amount = Helper::givenAmountActivityPayment($activity->id);
            if($activity->ttc_total_amount == $given_amount_with_new_given_amount){
                $status = 2;
            }else if($activity->ttc_total_amount>$given_amount_with_new_given_amount){
                $status = 1;
            }
            if($activity->update(['status'=>$status])){
                toastr()->success(Lang::get('messages.the_activity_payment_has_updated_by_success'));
            }else{
                toastr()->success(Lang::get('messages.the_payment_has_updated_by_success_but_the_status_of_the_activity_has_not_changed'));
            }
            
        }else{
            toastr()->warning(Lang::get('messages.the_activity_payment_has_not_updated_by_success'));
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
        $activity_payment = Activity_payment::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $activity = $activity_payment->activity;
        $status = $activity->status;
        if($activity_payment->delete()){
            $remaining_amount = Helper::remainingAmountActivityPayment($activity->id);
            if($activity->ttc_total_amount == $remaining_amount){
                $status = 0;
            }else if($activity->ttc_total_amount>$remaining_amount){
                $status = 1;
            }else if($remaining_amount == 0){
                $status = 2;
            }
            $activity->update(['status'=>$status]);
            toastr()->success(Lang::get('messages.the_activity_payment_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_activity_payment_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
