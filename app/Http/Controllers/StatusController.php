<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\StatusRequest;
use Illuminate\Support\Facades\Auth;
use Lang;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $status = Status::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('settings.status',compact('status'));
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
    public function store(StatusRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'name'=>$request->name,
            'color'=>$request->color,
        ];
        if(Status::create($data)){
            toastr()->success(Lang::get('messages.the_status_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_status_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.status');
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
        $data=["icon"=>"warning","status"=>array()];
        $status = Status::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","status"=>$status];
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
        $data=["icon"=>"warning","status"=>array()];
        $status = Status::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","status"=>$status];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StatusRequest $request, $id)
    {
        $user = Auth::user();
        $status = Status::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'name'=>$request->name,
            'color'=>$request->color,
        ];
        if($status->update($data)){
            toastr()->success(Lang::get('messages.the_status_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_status_has_not_updated_by_success'));
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
        $status = Status::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($status->delete()){
            toastr()->success(Lang::get('messages.the_status_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_status_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
