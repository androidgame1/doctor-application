<?php

namespace App\Http\Controllers;

use App\Models\Act;
use App\Models\Patient;
use App\Models\Quote;
use App\Models\Quote_line;
use Illuminate\Http\Request;
use App\Http\Requests\QuoteRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helper;
use Barryvdh\DomPDF\Facade\Pdf;
use Lang;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $quotes = Quote::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $count_activated_quotes = $quotes->filter(function($value){
            return $value->status == '0';
        })->count();
        $count_canceled_quotes = $quotes->filter(function($value){
            return $value->status == '1';
        })->count();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('quotes.quotes',compact('quotes','patients','count_activated_quotes','count_canceled_quotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $series = Helper::seriesQuote();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view("quotes.create_quote",compact('patients','designations','series'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuoteRequest $request)
    {
        $user = Auth::user();
        $data_quote = [
            'series'=>$request->series,
            'administrator_id'=>$user->id,
            'patient_id'=>$request->patient_id,
            'date'=>$request->date,
            'remark'=>$request->remark,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
        ];
        if($quote = Quote::create($data_quote)){
            $data_quote_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_quote_lines[]=[
                    'administrator_id'=>$user->id,
                    'quote_id'=>$quote->id,
                    'designation'=>$request->designation[$index],
                    'description'=>$request->description[$index],
                    'quantity'=>$request->quantity[$index],
                    'unit_price'=>$request->unit_price[$index],
                    'reduction'=>$request->reduction[$index],
                    'reduction_amount'=>$request->reduction_amount[$index],
                    'ht_amount'=>$request->ht_amount[$index],
                ];
                $index++;
            }
            if(Quote_line::insert($data_quote_lines)){
                toastr()->success(Lang::get('messages.the_quote_has_inserted_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_quote_has_not_inserted_by_success_due_a_problem_in_purchase_invoice_lines_insertion'));
            }
        }else{
            toastr()->warning(Lang::get('messages.the_quote_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.quotes');
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
        $quote = Quote::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('quotes.show_quote',compact('quote'));
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
        $quote = Quote::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('quotes.edit_quote',compact('quote','patients','designations'));
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
        $series = Helper::seriesQuote();
        $quote = Quote::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        $designations = Act::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('quotes.duplicate_quote',compact('quote','patients','designations','series'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuoteRequest $request, $id)
    {
        $user = Auth::user();
        $quote = Quote::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_quote = [
            'date'=>$request->date,
            'remark'=>$request->remark,
            'reduction_total_amount'=>$request->reduction_total_amount,
            'ht_total_amount'=>$request->ht_total_amount,
        ];
        if($quote->update($data_quote)){
            Quote_line::where(['administrator_id'=>$user->id,'quote_id'=>$quote->id])->delete();
            $data_quote_lines=[];
            $index=0;
            foreach ($request->designation as $value) {
                $data_quote_lines[]=[
                    'administrator_id'=>$user->id,
                    'quote_id'=>$quote->id,
                    'designation'=>$request->designation[$index],
                    'description'=>$request->description[$index],
                    'quantity'=>$request->quantity[$index],
                    'unit_price'=>$request->unit_price[$index],
                    'reduction'=>$request->reduction[$index],
                    'reduction_amount'=>$request->reduction_amount[$index],
                    'ht_amount'=>$request->ht_amount[$index],
                ];
                $index++;
            }
            if(Quote_line::insert($data_quote_lines)){
                toastr()->success(Lang::get('messages.the_quote_has_updated_by_success'));
            }else{
                toastr()->warning(Lang::get('messages.the_quote_has_not_updated_by_success_due_a_problem_in_purchase_invoice_lines_modification'));
            }
        }else{
            toastr()->warning(Lang::get('messages.the_quote_has_not_updated_by_success'));
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
        $quote = Quote::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $quote_lines = Quote_line::where('quote_id',$quote->id);
        if($quote_lines->delete() && $quote->delete()){
            toastr()->success(Lang::get('messages.the_quote_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_quote_has_not_deleted_by_success'));
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
        $quote = Quote::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data_quote=[
            'status'=>1
        ];
        if($quote->update($data_quote)){
            toastr()->success(Lang::get('messages.the_quote_has_canceled_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_quote_has_not_canceled_by_success'));
        }
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter($item="")
    {
        $user = Auth::user();
        $quotes = Quote::orderBy('id','desc')->where(['administrator_id'=>$user->id,'status'=>$item])->get();
        $patients = Patient::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('quotes.quotes',compact('quotes','patients'));
    }
    /**
     * PDF the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function pdf($id){
        $user = Auth::user();
        $quote = Quote::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $pdf = Pdf::loadView('quotes.pdf_quote', compact('quote'));
        return $pdf->stream();
    }
}
