<?php

namespace App\Http\Controllers;

use App\Models\Type_drug;
use Illuminate\Http\Request;
use App\Http\Requests\TypeDrugRequest;
use Illuminate\Support\Facades\Auth;

class TypeDrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $type_drugs = Type_drug::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('parameters.type_drugs',compact('type_drugs'));
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
    public function store(TypeDrugRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'name'=>$request->name,
            'measruing_unit'=>$request->measruing_unit,
        ];
        if(Type_drug::create($data)){
            toastr()->success('The type of drug has inserted by success !');
        }else{
            toastr()->warning('The type of drug has not inserted by success !');
        }
        return redirect()->route('administrator.type_drugs');
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
        $data=["icon"=>"warning","type_drugs"=>array()];
        $type_drug = Type_drug::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","type_drug"=>$type_drug];
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
        $data=["icon"=>"warning","type_drugs"=>array()];
        $type_drug = Type_drug::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","type_drug"=>$type_drug];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeDrugRequest $request, $id)
    {
        $user = Auth::user();
        $type_drugs = Type_drug::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'name'=>$request->name,
            'color'=>$request->color,
        ];
        if($type_drugs->update($data)){
            toastr()->success('The type of drug has updated by success !');
        }else{
            toastr()->warning('The type of drug has not updated by success !');
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
        $type_drugs = Type_drug::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($type_drugs->delete()){
            toastr()->success('The type of drug has deleted by success !');
        }else{
            toastr()->warning('The type of drug has not deleted by success !');
        }
        return redirect()->back();
    }
}
