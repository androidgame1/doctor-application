<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Type_drug;
use App\Models\Drug;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Requests\PrescriptionRequest;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Lang;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $prescriptions = Prescription::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('prescriptions.prescriptions',compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $patients = Patient::where('administrator_id',$user->id)->get();
        $type_drugs = Type_drug::where('administrator_id',$user->id)->get();
        $drugs = Drug::where('administrator_id',$user->id)->get();
        $tests = Test::where('administrator_id',$user->id)->get();
        return view('prescriptions.create_prescription',compact('patients','drugs','tests','type_drugs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrescriptionRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'patient_id'=>$request->patient_id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'note'=>$request->note,
        ];
        if(Prescription::create($data)){
            toastr()->success(Lang::get('messages.the_prescription_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_prescription_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.prescriptions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $patients = Patient::where('administrator_id',$user->id)->get();
        $type_drugs = Type_drug::where('administrator_id',$user->id)->get();
        $drugs = Drug::where('administrator_id',$user->id)->get();
        $tests = Test::where('administrator_id',$user->id)->get();
        $prescription = Prescription::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('prescriptions.edit_prescription',compact('prescription','patients','drugs','tests','type_drugs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrescriptionRequest $request, $id)
    {
        $user = Auth::user();
        $prescriptions = Prescription::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'patient_id'=>$request->patient_id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'note'=>$request->note,
        ];
        if($prescriptions->update($data)){
            toastr()->success(Lang::get('messages.the_prescription_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_prescription_has_not_updated_by_success'));
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
        $prescriptions = Prescription::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($prescriptions->delete()){
            toastr()->success(Lang::get('messages.the_prescription_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_prescription_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
    /**
     * PDF the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function pdf($id){
        $user = Auth::user();
        $prescription = Prescription::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $pdf = Pdf::loadView('prescriptions.pdf_prescription', compact('prescription'));
        return $pdf->stream();
    }
}
