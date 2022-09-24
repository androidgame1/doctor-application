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
use Session;
use App;

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
    public function index()
    {
        if(Auth::user()->is_superadministrator){
            $administrators = User::where('role','administrator')->count();
            $activated_administrators = $administrators->filter(function($value){
                return $value->isvalidate == '1';
            })->count();
            $deactivated_administrators = $administrators->filter(function($value){
                $value->isvalidate == '0';
            })->count();
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
}
