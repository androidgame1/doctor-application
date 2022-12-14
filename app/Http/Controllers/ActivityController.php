<?php

namespace App\Http\Controllers;

use App\Models\Act;
use App\Models\Patient;
use App\Models\Activity;
use App\Models\Activity_line;
use Illuminate\Http\Request;
use App\Http\Requests\ActivityRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Barryvdh\DomPDF\Facade\Pdf;
use Lang;
use Carbon\Carbon;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $activities = Activity::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        if($request->isMethod('post') && !is_null($request->start_date) && !is_null($request->end_date)){
            $activities = Activity::orderBy('id','desc')->where('administrator_id',$user->id)
            ->whereDate('created_at','>=',Carbon::parse($request->start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($request->end_date)->format('Y-m-d')."%")
            ->get();
        }
        $count_unpaid_activities = $activities->filter(function($value){
            return $value->status == '0';
        })->count();
        $count_partiel_activities = $activities->filter(function($value){
            return $value->status == '1';
        })->count();
        $count_paid_activities = $activities->filter(function($value){
            return $value->status == '2';
        })->count();
        $count_canceled_activities = $activities->filter(function($value){
            return $value->status == '3';
        })->count();
        $canceled_payments = Helper::totalActivityPayments('canceled',$request->start_date,$request->end_date);
        $activated_payments = Helper::totalActivityPayments('activated',$request->start_date,$request->end_date);
        $paid_payments = Helper::totalActivityPayments('paid',$request->start_date,$request->end_date);
        $unpaid_payments = Helper::totalActivityPayments('unpaid',$request->start_date,$request->end_date);
        $total_amount = $activities->where('status','<>','3')->sum('ttc_total_amount');
        $total_given_amount = Helper::givenAmountActivityPayment(null,null,$request->start_date,$request->end_date);
        $total_remaining_amount = Helper::remainingAmountActivityPayment(null,null,0,$request->start_date,$request->end_date);
        return view('activities.activities',compact('activities','patients','count_unpaid_activities','count_partiel_activities','count_paid_activities','count_canceled_activities','canceled_payments','activated_payments','paid_payments','unpaid_payments','total_amount','total_given_amount','total_remaining_amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $series = Helper::seriesActivity();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view("activities.create_activity",compact('patients','designations','series'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        $user = Auth::user();
        $data_activity = [
            'series'=>$request->series,
            'administrator_id'=>$user->id,
            'patient_id'=>$request->patient_id,
            'date'=>$request->date,
            'remark'=>$request->remark,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
            'tva_total_amount'=>$request->tva_total_amount,
            'ttc_total_amount'=>$request->ttc_total_amount,
        ];
        if($request->quote_id){
            $data_activity['quote_id'] = $request->quote_id;    
        }
        if($activity = Activity::create($data_activity)){
            $data_activity_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_activity_lines[]=[
                    'administrator_id'=>$user->id,
                    'activity_id'=>$activity->id,
                    'designation'=>$request->designation[$index],
                    'description'=>$request->description[$index],
                    'quantity'=>$request->quantity[$index],
                    'unit_price'=>$request->unit_price[$index],
                    'reduction'=>$request->reduction[$index],
                    'reduction_amount'=>$request->reduction_amount[$index],
                    'ht_amount'=>$request->ht_amount[$index],
                    'tva'=>$request->tva[$index],
                    'tva_amount'=>$request->tva_amount[$index],
                    'ttc_amount'=>$request->ttc_amount[$index],
                ];
                $index++;
            }
            if(Activity_line::insert($data_activity_lines)){
                toastr()->success(Lang::get('messages.the_activity_has_inserted_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_activity_has_not_inserted_by_success_due_a_problem_in_purchase_invoice_lines_insertion'));
            }
        }else{
            toastr()->warning(Lang::get('messages.the_activity_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.activities');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('activities.show_activity',compact('activity'));
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
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('activities.edit_activity',compact('activity','patients','designations'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        $user = Auth::user();
        $series = Helper::seriesActivity();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('activities.duplicate_activity',compact('activity','patients','designations','series'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, $id)
    {
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_activity = [
            'date'=>$request->date,
            'remark'=>$request->remark,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
            'tva_total_amount'=>$request->tva_total_amount,
            'ttc_total_amount'=>$request->ttc_total_amount,
        ];
        if($activity->update($data_activity)){
            Activity_line::where(['administrator_id'=>$user->id,'activity_id'=>$activity->id])->delete();
            $data_activity_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_activity_lines[]=[
                    'administrator_id'=>$user->id,
                    'activity_id'=>$activity->id,
                    'designation'=>$request->designation[$index],
                    'description'=>$request->description[$index],
                    'quantity'=>$request->quantity[$index],
                    'unit_price'=>$request->unit_price[$index],
                    'reduction'=>$request->reduction[$index],
                    'reduction_amount'=>$request->reduction_amount[$index],
                    'ht_amount'=>$request->ht_amount[$index],
                    'tva'=>$request->tva[$index],
                    'tva_amount'=>$request->tva_amount[$index],
                    'ttc_amount'=>$request->ttc_amount[$index],
                ];
                $index++;
            }
            if(Activity_line::insert($data_activity_lines)){
                toastr()->success(Lang::get('messages.the_activity_has_updated_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_activity_has_not_updated_by_success_due_a_problem_in_purchase_invoice_lines_modification'));
            }
        }else{
            toastr()->warning(Lang::get('messages.the_activity_has_not_updated_by_success'));
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
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $activity_lines = Activity_line::where('activity_id',$activity->id);
        if($activity_lines->delete() && $activity->delete()){
            toastr()->success(Lang::get('messages.the_activity_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_activity_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
    /**
     * cancel the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_activity=[
            'status'=>3
        ];
        if($activity->update($data_activity)){
            toastr()->success(Lang::get('messages.the_activity_has_canceled_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_activity_has_not_canceled_by_success'));
        }
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($item="")
    {
        $user = Auth::user();
        $activities = Activity::orderBy('id','desc')->where(['administrator_id'=>$user->id,'status'=>$item])->get();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('activities.activities',compact('activities','patients'));
    }
    /**
     * PDF the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function pdf($id){
        $user = Auth::user();
        $activity = Activity::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $pdf = Pdf::loadView('activities.pdf_activity', compact('activity'));
        return $pdf->stream();
    }
}
