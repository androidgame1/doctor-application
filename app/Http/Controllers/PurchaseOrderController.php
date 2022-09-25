<?php

namespace App\Http\Controllers;

use App\Models\Purchase_order;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseOrderRequest;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Lang;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $purchase_orders = Purchase_order::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('purchase_orders.purchase_orders',compact('purchase_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $suppliers = Supplier::where('administrator_id',$user->id)->get();
        return view('purchase_orders.create_purchase_order',compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'supplier_id'=>$request->supplier_id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'note'=>$request->note,
        ];
        if(Purchase_order::create($data)){
            toastr()->success(Lang::get('messages.the_purchase_order_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_purchase_order_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.purchase_orders');
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
        $suppliers = Supplier::where('administrator_id',$user->id)->get();
        $purchase_order = Purchase_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('purchase_orders.edit_purchase_order',compact('purchase_order','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrderRequest $request, $id)
    {
        $user = Auth::user();
        $purchase_orders = Purchase_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'supplier_id'=>$request->supplier_id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'note'=>$request->note,
        ];
        if($purchase_orders->update($data)){
            toastr()->success(Lang::get('messages.the_purchase_order_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_purchase_order_has_not_updated_by_success'));
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
        $purchase_orders = Purchase_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($purchase_orders->delete()){
            toastr()->success(Lang::get('messages.the_purchase_order_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_purchase_order_has_not_deleted_by_success'));
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
        $purchase_order = Purchase_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $pdf = Pdf::loadView('purchase_orders.pdf_purchase_order', compact('purchase_order'));
        return $pdf->stream();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function convert_po_to_do($purchase_order_id)
    {
        $user = Auth::user();
        $suppliers = Supplier::where('administrator_id',$user->id)->get();
        return view('delivery_orders.create_delivery_order',compact('suppliers','purchase_order_id'));
    }

}
