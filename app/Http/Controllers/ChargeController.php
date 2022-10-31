<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ChargeRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Lang;
use Carbon\Carbon;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$item="")
    {
        // dd($request->all());
        $user = Auth::user();
        $charges = Charge::orderBy('id','desc')->where('administrator_id',$user->id);
        $secretary=null;
        if($item){
            $secretary = User::where(['administrator_id'=>$user->id,'role'=>2,'id'=>$item])->firstOrFail();
            $charges = Charge::orderBy('id','desc')->where(['administrator_id'=>$user->id,'secretary_id'=>$item]);
        }
        if($request->isMethod('post') && !is_null($request->start_date) && !is_null($request->end_date)){
            $charges = Charge::orderBy('id','desc')->where('administrator_id',$user->id)
            ->whereDate('created_at','>=',Carbon::parse($request->start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($request->end_date)->format('Y-m-d')."%");
            if($item){
                $secretary = User::where(['administrator_id'=>$user->id,'role'=>2,'id'=>$item])->firstOrFail();
                $charges = Charge::orderBy('id','desc')->where(['administrator_id'=>$user->id,'secretary_id'=>$item])
                ->whereDate('created_at','>=',Carbon::parse($request->start_date)->format('Y-m-d')."%")
                ->whereDate('created_at','<=',Carbon::parse($request->end_date)->format('Y-m-d')."%");
            }
        }
        $charges = $charges->get();
        $count_charges = $charges->count();
        $charge_payments = $charges->sum('amount');
        $count_unpaid_charges = $charges->filter(function($value){
            return $value->status == '0';
        })->count();
        $count_partiel_charges = $charges->filter(function($value){
            return $value->status == '1';
        })->count();
        $count_paid_charges = $charges->filter(function($value){
            return $value->status == '2';
        })->count();
        $count_canceled_charges = $charges->filter(function($value){
            return $value->status == '3';
        })->count();
        $canceled_payments = Helper::totalChargePayments('canceled',$item,$request->start_date,$request->end_date);
        $activated_payments = Helper::totalChargePayments('activated',$item,$request->start_date,$request->end_date);
        $paid_payments = Helper::totalChargePayments('paid',$item,$request->start_date,$request->end_date);
        $unpaid_payments = Helper::totalChargePayments('unpaid',$item,$request->start_date,$request->end_date);
        $total_amount = $charges->sum('amount');
        $total_given_amount = Helper::givenAmountChargePayment(null,$item,$request->start_date,$request->end_date);
        $total_remaining_amount = Helper::remainingAmountChargePayment(null,$item,0,$request->start_date,$request->end_date);
        return view('charges.charges',compact('charges','secretary','count_unpaid_charges','count_partiel_charges','count_paid_charges','count_canceled_charges','canceled_payments','activated_payments','paid_payments','unpaid_payments','total_amount','total_given_amount','total_remaining_amount'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($item="",$secretary_id="")
    {
        $user = Auth::user();
        $charges = Charge::orderBy('id','desc')->where(['administrator_id'=>$user->id,'status'=>$item])->get();
        $secretary=null;
        if($secretary_id){
            $secretary = User::where(['administrator_id'=>$user->id,'role'=>2,'id'=>$item])->firstOrFail();
            $charges = Charge::orderBy('id','desc')->where(['administrator_id'=>$user->id,'secretary_id'=>$secretary_id]);
        }
        if($item){
            $charges = $charges->filter(function($value) use ($item){
                return $value->status == $item;
            });
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
        $charge->total_given_amount = $charge->total_given_amount;
        $charge->total_remaining_amount = $charge->total_remaining_amount;
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
        $charge->total_given_amount = $charge->total_given_amount;
        $charge->total_remaining_amount = $charge->total_remaining_amount;
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
