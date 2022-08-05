<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\Auth;

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
            toastr()->success('The supplier has inserted by success !');
        }else{
            toastr()->warning('The supplier has not inserted by success !');
        }
        return redirect()->route('administrator.suppliers');
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
        $supplier = Supplier::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        return view('suppliers.show_supplier',compact('supplier'));
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
            toastr()->success('The supplier has updated by success !');
        }else{
            toastr()->warning('The supplier has not updated by success !');
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
            toastr()->success('The supplier has deleted by success !');
        }else{
            toastr()->warning('The supplier has not deleted by success !');
        }
        return redirect()->back();
    }
}
