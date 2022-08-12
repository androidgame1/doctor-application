<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use App\Http\Requests\DrugRequest;
use Illuminate\Support\Facades\Auth;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $drugs = Drug::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('parameters.drugs',compact('drugs'));
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
    public function store(DrugRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'trade_name'=>$request->trade_name,
            'generic_name'=>$request->generic_name,
            'description'=>$request->description,
        ];
        if(Drug::create($data)){
            toastr()->success('The drug has inserted by success !');
        }else{
            toastr()->warning('The drug has not inserted by success !');
        }
        return redirect()->route('administrator.drugs');
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
        $data=["icon"=>"warning","drugs"=>array()];
        $drugs = Drug::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","drugs"=>$drugs];
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
        $data=["icon"=>"warning","drugs"=>array()];
        $drugs = Drug::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","drugs"=>$drugs];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DrugRequest $request, $id)
    {
        $user = Auth::user();
        $drugs = Drug::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'trade_name'=>$request->trade_name,
            'generic_name'=>$request->generic_name,
            'description'=>$request->description,
        ];
        if($drugs->update($data)){
            toastr()->success('The drug has updated by success !');
        }else{
            toastr()->warning('The drug has not updated by success !');
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
        $drugs = Drug::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($drugs->delete()){
            toastr()->success('The drug has deleted by success !');
        }else{
            toastr()->warning('The drug has not deleted by success !');
        }
        return redirect()->back();
    }
}
