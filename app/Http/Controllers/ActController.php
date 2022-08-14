<?php

namespace App\Http\Controllers;

use App\Models\Act;
use Illuminate\Http\Request;
use App\Http\Requests\ActRequest;
use Illuminate\Support\Facades\Auth;

class ActController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $acts = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('acts.acts',compact('acts'));
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
    public function store(ActRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if(Act::create($data)){
            toastr()->success('The act has inserted by success !');
        }else{
            toastr()->warning('The act has not inserted by success !');
        }
        return redirect()->route('administrator.acts');
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
        $data=["icon"=>"warning","act"=>array()];
        $act = Act::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","act"=>$act];
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
        $data=["icon"=>"warning","act"=>array()];
        $act = Act::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","act"=>$act];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActRequest $request, $id)
    {
        $user = Auth::user();
        $act = Act::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if($act->update($data)){
            toastr()->success('The act has updated by success !');
        }else{
            toastr()->warning('The act has not updated by success !');
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
        $act = Act::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($act->delete()){
            toastr()->success('The act has deleted by success !');
        }else{
            toastr()->warning('The act has not deleted by success !');
        }
        return redirect()->back();
    }
}

