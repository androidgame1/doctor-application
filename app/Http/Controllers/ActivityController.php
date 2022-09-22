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
use Lang;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $activities = Activity::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $count_activated_activities = $activities->filter(function($value){
            return $value->status == 0;
        })->count();
        $count_canceled_activities = $activities->filter(function($value){
            return $value->status == 1;
        })->count();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('activities.activities',compact('activities','patients','count_activated_activities','count_canceled_activities'));
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
        ];
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
            'status'=>1
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
}
