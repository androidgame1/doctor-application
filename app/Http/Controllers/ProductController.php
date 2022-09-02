<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Lang;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $products = Product::orderBy('id','desc')->where('administrator_id',$user->id)->get();
        return view('products.products',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $user = Auth::user();
        $data = [
            'administrator_id'=>$user->id,
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if(Product::create($data)){
            toastr()->success(Lang::get('messages.the_product_has_inserted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_product_has_not_inserted_by_success'));
        }
        return redirect()->route('administrator.products');
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
        $data=["icon"=>"warning","product"=>array()];
        $product = Product::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","product"=>$product];
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
        $data=["icon"=>"warning","product"=>array()];
        $product = Product::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data=["icon"=>"success","product"=>$product];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $user = Auth::user();
        $product = Product::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        $data = [
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if($product->update($data)){
            toastr()->success(Lang::get('messages.the_product_has_updated_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_product_has_not_updated_by_success'));
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
        $product = Product::where(['administrator_id'=>$user->id,'id'=>$id])->firstOrFail();
        if($product->delete()){
            toastr()->success(Lang::get('messages.the_product_has_deleted_by_success'));
        }else{
            toastr()->warning(Lang::get('messages.the_product_has_not_deleted_by_success'));
        }
        return redirect()->back();
    }
}
