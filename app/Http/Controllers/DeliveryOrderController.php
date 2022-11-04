<?php

namespace App\Http\Controllers;

use App\Models\Delivery_order;
use App\Models\Delivery_order_line;
use App\Models\Purchase_order;
use App\Models\Supplier;
use App\Models\Act;
use Illuminate\Http\Request;
use App\Http\Requests\DeliveryOrderRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Lang;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$purchase_order_id="")
    {
        $user = Auth::user();
        $purchase_order = null;
        $delivery_orders = Delivery_order::orderBy('id','desc')->where(['administrator_id'=>$user->id]);
        $supplier = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        if($request->isMethod('post') && !is_null($request->start_date) && !is_null($request->end_date)){
            $delivery_orders = Delivery_order::orderBy('id','desc')->where('administrator_id',$user->id)
            ->whereDate('created_at','>=',Carbon::parse($request->start_date)->format('Y-m-d')."%")
            ->whereDate('created_at','<=',Carbon::parse($request->end_date)->format('Y-m-d')."%");
        }
        if($purchase_order_id){
            $purchase_order = Purchase_order::orderBy('id','desc')->where(['administrator_id'=>$user->id,'id'=>$purchase_order_id])->firstOrFail();
            $delivery_orders = $delivery_orders->where('purchase_order_id',$purchase_order_id);
        }
        $delivery_orders = $delivery_orders->get();
        $count_unpaid_delivery_orders = $delivery_orders->filter(function($value){
            return $value->status == '0';
        })->count();
        $count_partiel_delivery_orders = $delivery_orders->filter(function($value){
            return $value->status == '1';
        })->count();
        $count_paid_delivery_orders = $delivery_orders->filter(function($value){
            return $value->status == '2';
        })->count();
        $count_canceled_delivery_orders = $delivery_orders->filter(function($value){
            return $value->status == '3';
        })->count();
        $canceled_payments = Helper::totalDeliveryOrderPayments('canceled',$request->start_date,$request->end_date);
        $activated_payments = Helper::totalDeliveryOrderPayments('activated',$request->start_date,$request->end_date);
        $paid_payments = Helper::totalDeliveryOrderPayments('paid',$request->start_date,$request->end_date);
        $unpaid_payments = Helper::totalDeliveryOrderPayments('unpaid',$request->start_date,$request->end_date);
        $total_amount = $delivery_orders->where('status','<>','3')->sum('ttc_total_amount');
        $total_given_amount = Helper::givenAmountDeliveryOrderPayment(null,$purchase_order_id,null,$request->start_date,$request->end_date);
        $total_remaining_amount = Helper::remainingAmountDeliveryOrderPayment(null,$purchase_order_id,null,0,$request->start_date,$request->end_date);
        return view('delivery_orders.delivery_orders',compact('delivery_orders','purchase_order','count_unpaid_delivery_orders','count_partiel_delivery_orders','count_paid_delivery_orders','count_canceled_delivery_orders','canceled_payments','activated_payments','paid_payments','unpaid_payments','total_amount','total_given_amount','total_remaining_amount'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($item="")
    {
        $user = Auth::user();
        $delivery_orders = Delivery_order::orderBy('id','desc')->where(['administrator_id'=>$user->id,'status'=>$item])->get();
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('sale_invoices.sale_invoices',compact('delivery_orders','patients'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $purchase_order = null;
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view("delivery_orders.create_delivery_order",compact('suppliers','designations','purchase_order'));
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
            if($request->way_storing == 'duplicate'){
                $request->file = $request->old_file;
            }else{
                $request->file = null;
            } 
        }
        $data_delivery_order = [
            'series'=>$request->series,
            'administrator_id'=>$user->id,
            'supplier_id'=>$request->supplier_id,
            'date'=>\Carbon\Carbon::parse($request->date)->format('Y-m-d'),
            'remark' => $request->remark,
            'file'=>$request->file,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
            'tva_total_amount'=>$request->tva_total_amount,
            'ttc_total_amount'=>$request->ttc_total_amount,
        ];
        if($request->action == 'convert'){
            $data_delivery_order['purchase_order_id'] = $request->purchase_order_id;    
        }
        if($delivery_order = Delivery_order::create($data_delivery_order)){
            $data_delivery_order_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_delivery_order_lines[]=[
                    'administrator_id'=>$user->id,
                    'delivery_order_id'=>$delivery_order->id,
                    'designation'=>$request->designation[$index],
                    'description'=>$request->description[$index],
                    'quantity'=>$request->quantity[$index],
                    'unit_price'=>$request->unit_price[$index],
                    'reduction'=>$request->reduction[$index],
                    'reduction_amount'=>$request->reduction_amount[$index],
                    'ht_amount'=>$request->ht_amount[$index],
                    'tva'=>$request->tva[$index],
                    'tva_amount'=>$request->tva_amount[$index],
                    'ttc_amount'=>$request->ttc_amount[$index],
                ];
                $index++;
            }
            if(Delivery_order_line::insert($data_delivery_order_lines)){
                toastr()->success(Lang::get('messages.the_delivery_order_has_inserted_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_delivery_order_has_not_inserted_by_success_due_a_problem_in_delivery_order_lines_insertion'));
            }
        }else{
            toastr()->warning(Lang::get('messages.the_delivery_order_has_not_inserted_by_success'));
        }
        if($request->action == 'convert'){
            return redirect()->route('administrator.delivery_orders.purchase_order',$request->purchase_order_id);
        }else{
            return redirect()->route('administrator.delivery_orders');
        }
        
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
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('delivery_orders.show_delivery_order',compact('delivery_order'));
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
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('delivery_orders.edit_delivery_order',compact('delivery_order','suppliers','designations'));
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        $user = Auth::user();
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('delivery_orders.duplicate_delivery_order',compact('delivery_order','suppliers','designations'));
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
            'date'=>$request->date,
            'remark' => $request->remark,
            'file'=>$request->file,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
            'tva_total_amount'=>$request->tva_total_amount,
            'ttc_total_amount'=>$request->ttc_total_amount,
        ];
        if($delivery_order->update($data_delivery_order)){
            Delivery_order_line::where(['administrator_id'=>$user->id,'delivery_order_id'=>$delivery_order->id])->delete();
            $data_delivery_order_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_delivery_order_lines[]=[
                    'administrator_id'=>$user->id,
                    'delivery_order_id'=>$delivery_order->id,
                    'designation'=>$request->designation[$index],
                    'description'=>$request->description[$index],
                    'quantity'=>$request->quantity[$index],
                    'unit_price'=>$request->unit_price[$index],
                    'reduction'=>$request->reduction[$index],
                    'reduction_amount'=>$request->reduction_amount[$index],
                    'ht_amount'=>$request->ht_amount[$index],
                    'tva'=>$request->tva[$index],
                    'tva_amount'=>$request->tva_amount[$index],
                    'ttc_amount'=>$request->ttc_amount[$index],
                ];
                $index++;
            }
            if(Delivery_order_line::insert($data_delivery_order_lines)){
                toastr()->success(Lang::get('messages.the_delivery_order_has_updated_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_delivery_order_has_not_updated_by_success_due_a_problem_in_delivery_order_lines_modification'));
            }
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
    /**
     * cancel the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $user = Auth::user();
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_delivery_order=[
            'status'=>3
        ];
        if($delivery_order->update($data_delivery_order)){
            toastr()->success(Lang::get('messages.the_delivery_order_has_canceled_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_delivery_order_has_not_canceled_by_success'));
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
        $delivery_order = Delivery_order::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $pdf = Pdf::loadView('delivery_orders.pdf_delivery_order', compact('delivery_order'));
        return $pdf->stream();
    }
}
