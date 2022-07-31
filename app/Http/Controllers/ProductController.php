<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id','desc')->get();
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
        $data = [
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if(Product::create($data)){
            toastr()->success('The product has inserted by success !');
        }else{
            toastr()->warning('The product has not inserted by success !');
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
        $data=["icon"=>"warning","product"=>array()];
        $product = Product::findOrFail($id);
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
        $data=["icon"=>"warning","product"=>array()];
        $product = Product::findOrFail($id);
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
        $product = Product::findOrFail($id);
        $data = [
            'name'=>$request->name,
            'amount'=>$request->amount,
            'description'=>$request->description,
        ];
        if($product->update($data)){
            toastr()->success('The product has updated by success !');
        }else{
            toastr()->warning('The product has not updated by success !');
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
        $product = Product::findOrFail($id);
        if($product->delete()){
            toastr()->success('The product has deleted by success !');
        }else{
            toastr()->warning('The product has not deleted by success !');
        }
        return redirect()->back();
    }
}
