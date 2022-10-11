<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Supplier;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Act;
use App\Models\Prescription;
use App\Models\Activity;
use App\Models\Purchase_invoice;
use App\Models\Sale_invoice;
use App\Models\Purchase_order;
use App\Models\Delivery_order;
use App\Models\Quote;
use App\Models\Charge;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Http\Helper;
use Barryvdh\DomPDF\Facade\Pdf;
use Session;
use App;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->isMethod('post') && !is_null($request->start_date) && !is_null($request->end_date)){
            if(Auth::user()->is_superadministrator){
                $administrators = User::where('role','administrator')->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $activated_administrators =$administrators = User::where(['role'=>'administrator','isvalidate'=>0])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $deactivated_administrators = $administrators = User::where(['role'=>'administrator','isvalidate'=>0])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                return view('home',compact('administrators','activated_administrators','deactivated_administrators'));
            }else if(Auth::user()->is_administrator){
                $user = Auth::user();
                $count_secretaries = User::where(['administrator_id'=>$user->id,'role'=>'secretary'])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_suppliers = Supplier::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_patients = Patient::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_products = Product::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_acts = Act::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_prescriptions = Prescription::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_activities = Activity::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_purchase_invoices = Purchase_invoice::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_sale_invoices = Sale_invoice::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_purchase_orders = Purchase_order::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_delivery_orders = Delivery_order::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_quotes = Quote::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_charges = Charge::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                $count_appointments = Appointment::where(['administrator_id'=>$user->id])->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->count();
                return view('home',compact('count_secretaries','count_suppliers','count_patients','count_products','count_acts','count_prescriptions','count_activities','count_purchase_invoices','count_sale_invoices','count_purchase_orders','count_delivery_orders','count_quotes','count_charges','count_appointments'));
            }else if(Auth::user()->is_secretary){
                return view('home');
            }else{
                return view('error');
            }
        }else{
            if(Auth::user()->is_superadministrator){
                $administrators = User::where('role','administrator')->count();
                $activated_administrators = User::where(['role'=>'administrator','isvalidate'=>1])->count();
                $deactivated_administrators =  User::where(['role'=>'administrator','isvalidate'=>0])->count();
                return view('home',compact('administrators','activated_administrators','deactivated_administrators'));
            }else if(Auth::user()->is_administrator){
                $user = Auth::user();
                $count_secretaries = User::where(['administrator_id'=>$user->id,'role'=>'secretary'])->count();
                $count_suppliers = Supplier::where(['administrator_id'=>$user->id])->count();
                $count_patients = Patient::where(['administrator_id'=>$user->id])->count();
                $count_products = Product::where(['administrator_id'=>$user->id])->count();
                $count_acts = Act::where(['administrator_id'=>$user->id])->count();
                $count_prescriptions = Prescription::where(['administrator_id'=>$user->id])->count();
                $count_activities = Activity::where(['administrator_id'=>$user->id])->count();
                $count_purchase_invoices = Purchase_invoice::where(['administrator_id'=>$user->id])->count();
                $count_sale_invoices = Sale_invoice::where(['administrator_id'=>$user->id])->count();
                $count_purchase_orders = Purchase_order::where(['administrator_id'=>$user->id])->count();
                $count_delivery_orders = Delivery_order::where(['administrator_id'=>$user->id])->count();
                $count_quotes = Quote::where(['administrator_id'=>$user->id])->count();
                $count_charges = Charge::where(['administrator_id'=>$user->id])->count();
                $count_appointments = Appointment::where(['administrator_id'=>$user->id])->count();
                return view('home',compact('count_secretaries','count_suppliers','count_patients','count_products','count_acts','count_prescriptions','count_activities','count_purchase_invoices','count_sale_invoices','count_purchase_orders','count_delivery_orders','count_quotes','count_charges','count_appointments'));
            }else if(Auth::user()->is_secretary){
                return view('home');
            }else{
                return view('error');
            }
        }
    }
     /**
     * Change language.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changeLanguage($lang_code){
        App::setLocale($lang_code);
        Session::put('lang_code',$lang_code);
        return redirect()->back();
    }
    /**
     * PDF the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function report(Request $request){
        $user = Auth::user();
        if(Auth::user()->is_administrator){
            $activities = Activity::orderBy('id','desc')->where('administrator_id',$user->id)->get();
            $sale_invoices = Sale_invoice::orderBy('id','desc')->where('administrator_id',$user->id)->get();
            $purchase_invoices = Purchase_invoice::orderBy('id','desc')->where('administrator_id',$user->id)->get();
            $charges = Charge::orderBy('id','desc')->where('administrator_id',$user->id);
            if($request->isMethod('post') && !is_null($request->start_date) && !is_null($request->end_date)){
                $activities = Activity::orderBy('id','desc')->where('administrator_id',$user->id)->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->get();
                $sale_invoices = Sale_invoice::orderBy('id','desc')->where('administrator_id',$user->id)->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->get();
                $purchase_invoices = Purchase_invoice::orderBy('id','desc')->where('administrator_id',$user->id)->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"])->get();
                $charges = Charge::orderBy('id','desc')->where('administrator_id',$user->id)->whereBetween('created_at',[Carbon::parse($request->start_date)->format('Y-m-d')."%",Carbon::parse($request->end_date)->format('Y-m-d')."%"]);
            }
            $activities_canceled_payments = Helper::totalActivityPayments('canceled',$request->start_date,$request->end_date);
            $activities_activated_payments = Helper::totalActivityPayments('activated',$request->start_date,$request->end_date);
            $activities_paid_payments = Helper::totalActivityPayments('paid',$request->start_date,$request->end_date);
            $activities_partiel_payments = Helper::totalActivityPayments('partiel',$request->start_date,$request->end_date);
            $activities_unpaid_payments = Helper::totalActivityPayments('unpaid',$request->start_date,$request->end_date);
            
            $sale_invoices_canceled_payments = Helper::totalSaleInvoicePayments('canceled',$request->start_date,$request->end_date);
            $sale_invoices_activated_payments = Helper::totalSaleInvoicePayments('activated',$request->start_date,$request->end_date);
            $sale_invoices_paid_payments = Helper::totalSaleInvoicePayments('paid',$request->start_date,$request->end_date);
            $sale_invoices_partiel_payments = Helper::totalSaleInvoicePayments('partiel',$request->start_date,$request->end_date);
            $sale_invoices_unpaid_payments = Helper::totalSaleInvoicePayments('unpaid',$request->start_date,$request->end_date);
            
            $purchase_invoices_canceled_payments = Helper::totalPurchaseInvoicePayments('canceled',$request->start_date,$request->end_date);
            $purchase_invoices_activated_payments = Helper::totalPurchaseInvoicePayments('activated',$request->start_date,$request->end_date);
            $purchase_invoices_paid_payments = Helper::totalPurchaseInvoicePayments('paid',$request->start_date,$request->end_date);
            $purchase_invoices_partiel_payments = Helper::totalPurchaseInvoicePayments('partiel',$request->start_date,$request->end_date);
            $purchase_invoices_unpaid_payments = Helper::totalPurchaseInvoicePayments('unpaid',$request->start_date,$request->end_date);
            
            $charge_payments = $charges->sum('amount');
        }else{
            return view('error');
        }
        $pdf = Pdf::loadView('report', compact(
            'activities',
            'activities_canceled_payments',
            'activities_activated_payments',
            'activities_paid_payments',
            'activities_partiel_payments',
            'activities_unpaid_payments',
            'sale_invoices',
            'sale_invoices_canceled_payments',
            'sale_invoices_activated_payments',
            'sale_invoices_paid_payments',
            'sale_invoices_partiel_payments',
            'sale_invoices_unpaid_payments',
            'purchase_invoices',
            'purchase_invoices_canceled_payments',
            'purchase_invoices_activated_payments',
            'purchase_invoices_paid_payments',
            'purchase_invoices_partiel_payments',
            'purchase_invoices_unpaid_payments',
            'charge_payments',
        ));
        return $pdf->stream();
    }
}
