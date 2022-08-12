<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Requests\TestRequest;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $tests = Test::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('parameters.tests',compact('tests'));
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
    public function store(TestRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'name'=>$request->name,
            'description'=>$request->description,
        ];
        if(Test::create($data)){
            toastr()->success('The test has inserted by success !');
        }else{
            toastr()->warning('The test has not inserted by success !');
        }
        return redirect()->route('administrator.tests');
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
        $data=["icon"=>"warning","tests"=>array()];
        $tests = Test::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","tests"=>$tests];
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
        $data=["icon"=>"warning","tests"=>array()];
        $tests = Test::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","tests"=>$tests];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestRequest $request, $id)
    {
        $user = Auth::user();
        $tests = Test::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'name'=>$request->name,
            'description'=>$request->description,
        ];
        if($tests->update($data)){
            toastr()->success('The test has updated by success !');
        }else{
            toastr()->warning('The test has not updated by success !');
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
        $tests = Test::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($tests->delete()){
            toastr()->success('The test has deleted by success !');
        }else{
            toastr()->warning('The test has not deleted by success !');
        }
        return redirect()->back();
    }
}
