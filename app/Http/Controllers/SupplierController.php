<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Lang;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('suppliers.suppliers',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("suppliers.create_supplier");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'cin'=>$request->cin,
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'city'=>$request->city
        ];
        if(Supplier::create($data)){
            toastr()->success(Lang::get('messages.the_supplier_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_supplier_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.suppliers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $user = Auth::user();
        $supplier = Supplier::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $suppliers = Supplier::where(['administrator_id'=>$user->id])->get();
        //start delivery order
        $delivery_orders = $supplier->delivery_orders;
        $total_amount_delivery_orders = $delivery_orders->where('status','<>','3')->sum('ttc_total_amount');
        $total_given_amount_delivery_orders = Helper::givenAmountDeliveryOrderPayment(null,$supplier->id,$request->start_date,$request->end_date);
        $total_remaining_amount_delivery_orders = Helper::remainingAmountDeliveryOrderPayment(null,$supplier->id,0,$request->start_date,$request->end_date);
        //end delivery orders
        //start sale_invoices
        $purchase_invoices = $supplier->purchase_invoices;
        $total_amount_purchase_invoices = $purchase_invoices->where('status','<>','3')->sum('ttc_total_amount');
        $total_given_amount_purchase_invoices = Helper::givenAmountPurchaseInvoicePayment(null,$supplier->id,$request->start_date,$request->end_date);
        $total_remaining_amount_purchase_invoices = Helper::remainingAmountPurchaseInvoicePayment(null,$supplier->id,0,$request->start_date,$request->end_date);
        //end sale_invoices
        return view('suppliers.show_supplier',compact(
            'supplier',
            'suppliers',
            'delivery_orders',
            'total_amount_delivery_orders',
            'total_given_amount_delivery_orders',
            'total_remaining_amount_delivery_orders',
            'purchase_invoices',
            'total_amount_purchase_invoices',
            'total_given_amount_purchase_invoices',
            'total_remaining_amount_purchase_invoices'
        ));
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
        $supplier = Supplier::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('suppliers.edit_supplier',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        $user = Auth::user();
        $supplier = Supplier::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'cin'=>$request->cin,
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'address'=>$request->address,
            'phone'=>$request->phone,
            'city'=>$request->city
        ];
        if($supplier->update($data)){
            toastr()->success(Lang::get('messages.the_supplier_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_supplier_has_not_updated_by_success'));
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
        $supplier = Supplier::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($supplier->delete()){
            toastr()->success(Lang::get('messages.the_supplier_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_supplier_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
