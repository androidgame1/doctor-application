@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.delivery_orders')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.delivery_orders')}}</li>
            </ol>
            <a href="@if(auth()->user()->is_administrator)@if(Route::current()->getName()=='administrator.delivery_orders.purchase_order'){{route('administrator.delivery_order.convert_po_to_do',$purchase_order->id)}} @else {{route('administrator.delivery_order.create')}} @endif @else javascript:void(0) @endif" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.delivery_order')}}</a>
            
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('messages.messages')
                    </div>
                    @if($purchase_order)
                        <div class="col-md-12">
                            <h3>{{__('messages.purchase_order')}} : <a href="javascript:void(0)" class="text-primary font-bold">{{$purchase_order->series}}</a></span></h3>
                        </div>
                    @endif
                    <div class="col-md-12">
                        @include('tables.delivery_orders',$delivery_orders)
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.delivery_orders.show_delivery_order')
@include('modals.destroy')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.delivery_orders.show_delivery_order')
@include('javascript.destroy')
@endsection
