@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-12 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.suppliers')}}@else javascript:void(0) @endif">{{__('messages.suppliers')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.supplier')}}</li>
            </ol>
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
                <div>
                    <a href="#supplier_purchase_orders" class="btn btn-secondary">{{__('messages.purchase_orders')}}</a>
                    <a href="#supplier_delivery_orders" class="btn btn-success">{{__('messages.delivery_orders')}}</a>
                    <a href="#supplier_purchase_invoices" class="btn btn-danger">{{__('messages.purchase_invoices')}}</a>
                </div>
            </div>
        </div>
    </div>  
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="table-show-old-supplier" class="table browser m-0 no-border">
                    <tbody>
                        <tr class="tr-show">
                            <td><b>{{__('messages.cin')}}</b></td>
                            <td class="text-right"><span class="text-primary" name="cin">{{$supplier->cin}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.fullname')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$supplier->fullname}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.email')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$supplier->email}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.address')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$supplier->address}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.phone')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$supplier->phone}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.city')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$supplier->city}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12" id="supplier_purchase_orders">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{__('messages.purchase_orders')}}</h4>
                    </div>
                    <div class="col-md-12">
                        @include('tables.purchase_orders',['purchase_orders'=>$supplier->purchase_orders,'suppliers'=>$suppliers])
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12" id="supplier_delivery_orders">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{__('messages.delivery_orders')}}</h4>
                    </div>
                    <div class="col-md-12">
                        @include('tables.delivery_orders',['delivery_orders'=>$supplier->delivery_orders,'total_amount'=>$total_amount_delivery_orders,'total_given_amount'=>$total_given_amount_delivery_orders,'total_remaining_amount'=>$total_remaining_amount_delivery_orders])
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12" id="supplier_purchase_invoices">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{__('messages.purchase_invoices')}}</h4>
                    </div>
                    <div class="col-md-12">
                        @include('tables.purchase_invoices',['purchase_invoices'=>$supplier->purchase_invoices,'total_amount'=>$total_amount_purchase_invoices,'total_given_amount'=>$total_given_amount_purchase_invoices,'total_remaining_amount'=>$total_remaining_amount_purchase_invoices])
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.destroy')
@include('modals.cancel')
@endsection
@section('javascript')
    @include('javascript.helper')
    @include('javascript.datatable')

    @include('javascript.destroy')
    @include('javascript.cancel')
@endsection
