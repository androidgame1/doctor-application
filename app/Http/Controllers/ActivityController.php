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
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('activities.activities',compact('activities','patients'));
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
                toastr()->success('The activity has inserted by success !');
            }else{
                toastr()->warning('The activity has not inserted by success due a problem in purchase invoice lines insertion !');
            }
        }else{
            toastr()->warning('The activity has not inserted by success !');
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
                toastr()->success('The activity has updated by success !');
            }else{
                toastr()->warning('The activity has not updated by success due a problem in purchase invoice lines modification !');
            }
        }else{
            toastr()->warning('The activity has not updated by success !');
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
            toastr()->success('The activity has deleted by success !');
        }else{
            toastr()->warning('The activity has not deleted by success !');
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
            toastr()->success('The activity has canceled by success !');
        }else{
            toastr()->warning('The activity has not canceled by success !');
        }
        return redirect()->back();
    }
}
