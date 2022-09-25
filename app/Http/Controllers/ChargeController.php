<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\User;
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
    public function index($item="")
    {
        $user = Auth::user();
        $charges = Charge::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $secretary=null;
        if($item){
            $secretary = User::where(['administrator_id'=>$user->id,'role'=>2,'id'=>$item])->firstOrFail();
            $charges = Charge::orderBy('id','desc')->where(['administrator_id'=>$user->id,'secretary_id'=>$item])->get();
        }
        return view('charges.charges',compact('charges','secretary'));
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
        $data_charge = [
            'administrator_id'=>$user->id,
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if($request->secretary_id){
            $data_charge['secretary_id'] = $request->secretary_id;
        }
        if(Charge::create($data_charge)){
            toastr()->success(Lang::get('messages.the_charge_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_charge_has_not_inserted_by_success'));
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
