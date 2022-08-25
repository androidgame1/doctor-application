<?php

namespace App\Http\Controllers;

use App\Models\Act;
use App\Models\Patient;
use App\Models\Sale_invoice;
use App\Models\Sale_invoice_line;
use Illuminate\Http\Request;
use App\Http\Requests\SaleInvoiceRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;

class SaleInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $sale_invoices = Sale_invoice::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('sale_invoices.sale_invoices',compact('sale_invoices','patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $series = Helper::seriesSaleInvoice();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view("sale_invoices.create_sale_invoice",compact('patients','designations','series'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleInvoiceRequest $request)
    {
        $user = Auth::user();
        $data_sale_invoice = [
            'series'=>$request->series,
            'administrator_id'=>$user->id,
            'patient_id'=>$request->patient_id,
            'date'=>$request->date,
            'remark'=>$request->remark,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
            'tva_total_amount'=>$request->tva_total_amount,
            'ttc_total_amount'=>$request->ttc_total_amount,
        ];
        if($sale_invoice = Sale_invoice::create($data_sale_invoice)){
            $data_sale_invoice_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_sale_invoice_lines[]=[
                    'administrator_id'=>$user->id,
                    'sale_invoice_id'=>$sale_invoice->id,
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
            if(Sale_invoice_line::insert($data_sale_invoice_lines)){
                toastr()->success('The sale invoice has inserted by success !');
            }else{
                toastr()->warning('The sale invoice has not inserted by success due a problem in sale invoice lines insertion !');
            }
        }else{
            toastr()->warning('The sale invoice has not inserted by success !');
        }
        return redirect()->route('administrator.sale_invoices');
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
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('sale_invoices.show_sale_invoice',compact('sale_invoice'));
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
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('sale_invoices.edit_sale_invoice',compact('sale_invoice','patients','designations'));
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
        $series = Helper::seriesSaleInvoice();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('sale_invoices.duplicate_sale_invoice',compact('sale_invoice','patients','designations','series'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaleInvoiceRequest $request, $id)
    {
        $user = Auth::user();
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_sale_invoice = [
            'date'=>$request->date,
            'remark'=>$request->remark,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
            'tva_total_amount'=>$request->tva_total_amount,
            'ttc_total_amount'=>$request->ttc_total_amount,
        ];
        if($sale_invoice->update($data_sale_invoice)){
            Sale_invoice_line::where(['administrator_id'=>$user->id,'sale_invoice_id'=>$sale_invoice->id])->delete();
            $data_sale_invoice_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_sale_invoice_lines[]=[
                    'administrator_id'=>$user->id,
                    'sale_invoice_id'=>$sale_invoice->id,
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
            if(Sale_invoice_line::insert($data_sale_invoice_lines)){
                toastr()->success('The sale invoice has updated by success !');
            }else{
                toastr()->warning('The sale invoice has not updated by success due a problem in sale invoice lines modification !');
            }
        }else{
            toastr()->warning('The sale invoice has not updated by success !');
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
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($sale_invoice->delete()){
            toastr()->success('The sale invoice has deleted by success !');
        }else{
            toastr()->warning('The sale invoice has not deleted by success !');
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
        $sale_invoice = Sale_invoice::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_sale_invoice=[
            'status'=>3
        ];
        if($sale_invoice->update($data_sale_invoice)){
            toastr()->success('The sale invoice has canceled by success !');
        }else{
            toastr()->warning('The sale invoice has not canceled by success !');
        }
        return redirect()->back();
    }
}
