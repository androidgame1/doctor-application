<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRequest;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        return view('patients.patients',compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("patients.create_patient");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
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
        $data = [
            'administrator_id'=>$administrator_id,
            'secretariat_id'=>$user->id,
            'cin'=>$request->cin,
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'city'=>$request->city
        ];
        if(Patient::create($data)){
            toastr()->success('The patient has inserted by success !');
        }else{
            toastr()->warning('The patient has not inserted by success !');
        }
        return redirect()->route('secretary.patients');
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
        $patient = Patient::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        return view('patients.show_patient',compact('patient'));
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
        $patient = Patient::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        return view('patients.edit_patient',compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $id)
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
        $patient = Patient::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        $data = [
            'cin'=>$request->cin,
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'city'=>$request->city
        ];
        if($patient->update($data)){
            toastr()->success('The patient has updated by success !');
        }else{
            toastr()->warning('The patient has not updated by success !');
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
        $administrator_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
        }else{
            return view('error');
        }
        $patient = Patient::where(['administrator_id'=>$administrator_id,'id'=>$id])->firstOrFail();
        if($patient->delete()){
            toastr()->success('The patient has deleted by success !');
        }else{
            toastr()->warning('The patient has not deleted by success !');
        }
        return redirect()->back();
    }
}
