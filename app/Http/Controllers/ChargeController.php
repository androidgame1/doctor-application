<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;
use App\Http\Requests\ChargeRequest;
use Illuminate\Support\Facades\Auth;
use Lang;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $charges = Charge::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('charges.charges',compact('charges'));
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
    public function store(ChargeRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if(Charge::create($data)){
            toastr()->success(Lang::get('messages.the_charge_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_charge_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.charges');
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
        $data=["icon"=>"warning","charge"=>array()];
        $charge = Charge::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","charge"=>$charge];
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
        $data=["icon"=>"warning","charge"=>array()];
        $charge = Charge::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","charge"=>$charge];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChargeRequest $request, $id)
    {
        $user = Auth::user();
        $charge = Charge::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if($charge->update($data)){
            toastr()->success(Lang::get('messages.the_charge_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_charge_has_not_updated_by_success'));
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
        $charge = Charge::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($charge->delete()){
            toastr()->success(Lang::get('messages.the_charge_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_charge_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
