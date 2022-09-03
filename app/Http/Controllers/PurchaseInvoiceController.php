<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase_invoice;
use App\Models\Purchase_invoice_line;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseInvoiceRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Barryvdh\DomPDF\Facade\Pdf;
use Lang;

class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $purchase_invoices = Purchase_invoice::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('purchase_invoices.purchase_invoices',compact('purchase_invoices','suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $series = Helper::seriesPurchaseInvoice();
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Product::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view("purchase_invoices.create_purchase_invoice",compact('suppliers','designations','series'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseInvoiceRequest $request)
    {
        $user = Auth::user();
        $data_purchase_invoice = [
            'series'=>$request->series,
            'administrator_id'=>$user->id,
            'supplier_id'=>$request->supplier_id,
            'date'=>$request->date,
            'remark'=>$request->remark,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
            'tva_total_amount'=>$request->tva_total_amount,
            'ttc_total_amount'=>$request->ttc_total_amount,
        ];
        if($purchase_invoice = Purchase_invoice::create($data_purchase_invoice)){
            $data_purchase_invoice_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_purchase_invoice_lines[]=[
                    'administrator_id'=>$user->id,
                    'purchase_invoice_id'=>$purchase_invoice->id,
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
            if(Purchase_invoice_line::insert($data_purchase_invoice_lines)){
                toastr()->success(Lang::get('messages.the_purchase_invoice_has_inserted_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_purchase_invoice_has_not_inserted_by_success_due_a_problem_in_purchase_invoice_lines_insertion'));
            }
        }else{
            toastr()->warning(Lang::get('messages.the_purchase_invoice_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.purchase_invoices');
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
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('purchase_invoices.show_purchase_invoice',compact('purchase_invoice'));
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
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Product::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('purchase_invoices.edit_purchase_invoice',compact('purchase_invoice','suppliers','designations'));
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
        $series = Helper::seriesPurchaseInvoice();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $suppliers = Supplier::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Product::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('purchase_invoices.duplicate_purchase_invoice',compact('purchase_invoice','suppliers','designations','series'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseInvoiceRequest $request, $id)
    {
        $user = Auth::user();
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_purchase_invoice = [
            'date'=>$request->date,
            'remark'=>$request->remark,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
            'tva_total_amount'=>$request->tva_total_amount,
            'ttc_total_amount'=>$request->ttc_total_amount,
        ];
        if($purchase_invoice->update($data_purchase_invoice)){
            Purchase_invoice_line::where(['administrator_id'=>$user->id,'purchase_invoice_id'=>$purchase_invoice->id])->delete();
            $data_purchase_invoice_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_purchase_invoice_lines[]=[
                    'administrator_id'=>$user->id,
                    'purchase_invoice_id'=>$purchase_invoice->id,
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
            if(Purchase_invoice_line::insert($data_purchase_invoice_lines)){
                toastr()->success(Lang::get('messages.the_purchase_invoice_has_updated_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_purchase_invoice_has_not_updated_by_success_due_a_problem_in_purchase_invoice_lines_modification'));
            }
        }else{
            toastr()->warning(Lang::get('messages.the_purchase_invoice_has_not_updated_by_success'));
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
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($purchase_invoice->delete()){
            toastr()->success(Lang::get('messages.the_purchase_invoice_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_purchase_invoice_has_not_deleted_by_success'));
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
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_purchase_invoice=[
            'status'=>3
        ];
        if($purchase_invoice->update($data_purchase_invoice)){
            toastr()->success(Lang::get('messages.the_purchase_invoice_has_canceled_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_purchase_invoice_has_not_canceled_by_success'));
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
        $purchase_invoice = Purchase_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $pdf = Pdf::loadView('purchase_invoices.pdf_purchase_invoice', compact('purchase_invoice'));
        return $pdf->stream();
    }
}
