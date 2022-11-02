<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\PatientRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Lang;

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
        $secretary_id = "";
        if($user->is_administrator){
            $administrator_id=$user->id;
            $secretary_id =null;
        }else if($user->is_secretary){
            $administrator_id=$user->administrator_id;
            $secretary_id = $user->id;
        }else{
            return view('error');
        }
        $data = [
            'administrator_id'=>$administrator_id,
            'secretary_id'=>$secretary_id,
            'cin'=>$request->cin,
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'city'=>$request->city,
            'birthday'=>\Carbon\Carbon::parse($request->birthdate)->format('Y-m-d'),
            'gender'=>$request->gender,
            'blood_group'=>$request->blood_group,
            'weight'=>$request->weight,
            'height'=>$request->height,
        ];
        if(Patient::create($data)){
            toastr()->success(Lang::get('messages.the_patient_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_patient_has_not_inserted_by_success'));
        }
        if($user->is_administrator){
            return redirect()->route('administrator.patients');
        }else if($user->is_secretary){
            return redirect()->route('secretary.patients');
        }else{
            return view('error');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
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
        $patients = Patient::where(['administrator_id'=>$administrator_id])->get();
        $status = Status::where(['administrator_id'=>$administrator_id])->get();
        //start activities
        $activities = $patient->activities;
        $total_amount_activities = $activities->where('status','<>','3')->sum('ttc_total_amount');
        $total_given_amount_activities = Helper::givenAmountActivityPayment(null,$patient->id,$request->start_date,$request->end_date);
        $total_remaining_amount_activities = Helper::remainingAmountActivityPayment(null,$patient->id,0,$request->start_date,$request->end_date);
        //end activities
        //start sale_invoices
        $sale_invoices = $patient->sale_invoices;
        $total_amount_sale_invoices = $sale_invoices->where('status','<>','3')->sum('ttc_total_amount');
        $total_given_amount_sale_invoices = Helper::givenAmountSaleInvoicePayment(null,$patient->id,$request->start_date,$request->end_date);
        $total_remaining_amount_sale_invoices = Helper::remainingAmountSaleInvoicePayment(null,$patient->id,0,$request->start_date,$request->end_date);
        //end sale_invoices
        return view('patients.show_patient',compact(
            'patient',
            'patients',
            'status',
            'activities',
            'total_amount_activities',
            'total_given_amount_activities',
            'total_remaining_amount_activities',
            'total_amount_sale_invoices',
            'total_given_amount_sale_invoices',
            'total_remaining_amount_sale_invoices'
        ));
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
            'city'=>$request->city,
            'birthday'=>\Carbon\Carbon::parse($request->birthdate)->format('Y-m-d'),
            'gender'=>$request->gender,
            'blood_group'=>$request->blood_group,
            'weight'=>$request->weight,
            'height'=>$request->height,
        ];
        if($patient->update($data)){
            toastr()->success(Lang::get('messages.the_patient_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_patient_has_not_updated_by_success'));
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
            toastr()->success(Lang::get('messages.the_patient_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_patient_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
