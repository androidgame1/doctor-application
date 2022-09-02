<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Status;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Support\Facades\Auth;
use Lang;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($from)
    {
        $user = Auth::user();
        $administrator_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
        }else{
            return view('error');
        }

        $appointments = Appointment::orderBy('id','desc')->where('administrator_id',$administrator_id)->get();
        foreach ($appointments as $value) {
            $value->patient = $value->patient;
            $value->status_state = $value->status_state;
            $value->status = $value->status;
        }
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$administrator_id)->get();
        $status = Status::orderBy('id','desc')->where('administrator_id',$administrator_id)->get();
        if($from == "appointments"){
            return view('appointments.appointments',compact('appointments','patients','status'));
        }else if($from == "calendar"){
            $data=['icon'=>'success','appointments'=>$appointments,'patients'=>$patients,'status'=>$status];
            return response()->json($data);
        }else{
            return view('error');
        }
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        $user = Auth::user();
        $administrator_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
        }else{
            return view('error');
        }
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$administrator_id)->get();
        $status = Status::orderBy('id','desc')->where('administrator_id',$administrator_id)->get();
        return view('appointments.calendar',compact('patients','status'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentRequest $request)
    {
        $user = Auth::user();
        $administrator_id = "";
        $secretary_id = null;
        if($user->is_administrator){
            $administrator_id=$user->id;
            $secretary_id = null;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
            $secretary_id = $user->id;
        }else{
            return view('error');
        }
        $data = [
            'administrator_id'=>$administrator_id,
            'secretary_id'=>$secretary_id,
            'patient_id'=>$request->patient_id,
            'status_id'=>$request->status_id,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'remark'=>$request->remark,
        ];
        if(Appointment::create($data)){
            toastr()->success(Lang::get('messages.the_appointment_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_appointment_has_not_inserted_by_success'));
        }
        return redirect()->back();
        
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
        $administrator_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
        }else{
            return view('error');
        }
        $data=["icon"=>"warning","appointment"=>array()];
        $appointment = Appointment::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        $appointment->patient = $appointment->patient;
        $appointment->status_state = $appointment->status_state;
        $data=["icon"=>"success","appointment"=>$appointment];
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
        $administrator_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
        }else{
            return view('error');
        }
        $data=["icon"=>"warning","appointment"=>array()];
        $appointment = Appointment::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        $appointment->patient = $appointment->patient;
        $appointment->status_state = $appointment->status_state;
        $data=["icon"=>"success","appointment"=>$appointment];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentRequest $request, $id)
    {
        $user = Auth::user();
        $administrator_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
        }else{
            return view('error');
        }
        $appointment = Appointment::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        $data = [
            'patient_id'=>$request->patient_id,
            'status_id'=>$request->status_id,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'remark'=>$request->remark,
        ];
        if($appointment->update($data)){
            toastr()->success(Lang::get('messages.the_appointment_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_appointment_has_not_updated_by_success'));
        }
        return redirect()->back();
    }
 /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dropOrResize(Request $request, $id)
    {
        $user = Auth::user();
        $administrator_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
        }else{
            $data=['icon'=>'error','message'=>'There is a problem in server !'];
        }
        $appointment = Appointment::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        $data = [
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
        ];
        if($appointment->update($data)){
            toastr()->success(Lang::get('messages.the_appointment_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_appointment_has_not_updated_by_success'));
        }
        return response()->json($data);
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
        $administrator_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
        }else{
            return view('error');
        }
        $appointment = Appointment::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        if($appointment->delete()){
            toastr()->success(Lang::get('messages.the_appointment_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_appointment_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
