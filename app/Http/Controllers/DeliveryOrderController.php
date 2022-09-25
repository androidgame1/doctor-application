<?php

namespace App\Http\Controllers;

use App\Models\Delivery_order;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\DeliveryOrderRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Lang;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($item="")
    {
        $user = Auth::user();
        $delivery_orders = Delivery_order::where(['administrator_id'=>$user->id])->get();
        if($item){
            $delivery_orders = Delivery_order::where(['administrator_id'=>$user->id,'purchase_order_id'=>$item])->get();
        }
        return view('delivery_orders.delivery_orders',compact('delivery_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $suppliers = Supplier::where(['administrator_id'=>$user->id])->get();
        return view('delivery_orders.create_delivery_order',compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryOrderRequest $request)
    {
        $user = Auth::user();
        if($request->hasfile('file')){
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/delivery_orders/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/delivery_orders/file_administrator_".$user->id,$filename);
            $request->file = $filename;
        }else{
            $request->file = null;
        }
        $data_delivery_order = [
            'series'=>$request->series,
            'administrator_id'=>$user->id,
            'supplier_id'=>$request->supplier_id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'remark' => $request->remark,
            'file'=>$request->file,
        ];
        if($request->action == 'convert'){
            $data_delivery_order['purchase_order_id'] = $request->purchase_order_id;
            $data_delivery_order['status'] = 1;    
        }
        if(Delivery_order::create($data_delivery_order)){
            toastr()->success(Lang::get('messages.the_delivery_order_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_delivery_order_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.delivery_orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=['icon'=>'error','delivery_order'=>array()];
        $user = Auth::user();
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$id])->with('supplier')->firstOrFail();
        $data=['icon'=>'success','delivery_order'=>$delivery_order];
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
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $suppliers = Supplier::where(['administrator_id'=>$user->id])->get();
        return view('delivery_orders.edit_delivery_order',compact('delivery_order','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryOrderRequest $request, $id)
    {
        $user = Auth::user();
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($request->hasfile('file')){
            $file = $request->file('file');
            $extention = $file->getClientOriginalExtension();
            $filename = "uploads/administrator/delivery_orders/file_administrator_".$user->id."/".time().'.'.$extention;
            $file->move("uploads/administrator/delivery_orders/file_administrator_".$user->id,$filename);
            $request->file = $filename;
        }else{
            $request->file = $delivery_order->file;
        }
        $data_delivery_order = [
            'series'=>$request->series,
            'supplier_id'=>$request->supplier_id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'remark' => $request->remark,
            'file'=>$request->file,
        ];
        if($delivery_order->update($data_delivery_order)){
            toastr()->success(Lang::get('messages.the_delivery_order_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_delivery_order_has_not_updated_by_success'));
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
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($delivery_order->delete()){
            toastr()->success(Lang::get('messages.the_delivery_order_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_delivery_order_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
