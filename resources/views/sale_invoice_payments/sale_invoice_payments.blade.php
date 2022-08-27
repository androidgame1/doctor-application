@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.sale_invoice_payments')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.sale_invoice_payments')}}</li>
            </ol>
            @if($sale_invoice->status == '0' || $sale_invoice->status == '1')
                <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice_payment.create',$sale_invoice->id)}}@else javascript:void(0) @endif" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.sale_invoice')}}</a>
            @elseif($sale_invoice->status == '2')
                <a href="javascript:void(0)" class="btn btn-success d-lg-block m-l-15">{{__('messages.payment_completed')}}</a>
            @endif
            
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
                    <div class="col-md-12">
                        <h3>{{__('messages.sale_invoice')}} : <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.show',$sale_invoice->id)}}@else javascript:void(0) @endif" class="btn-show-sale-invoice text-primary font-bold" title="{{__('messages.show')}}">{{$sale_invoice->series}}</a></span></h3>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-datatable">
                                <thead>
                                    <tr>
                                        <th class="d-none">#</th>
                                        <th>{{__('messages.date')}}</th>
                                        <th>{{__('messages.ttc_amount')}}</th>
                                        <th>{{__('messages.given_amount')}}</th>
                                        <th>{{__('messages.remaining_amount')}}</th>
                                        <th>{{__('messages.date_creation')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale_invoice_payments as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                                            <td>{{$value->sale_invoice->ttc_total_amount}} <b>MAD</b></td>
                                            <td>{{$value->given_amount}} <b>MAD</b></td>
                                            <td>{{$value->remaining_amount}} <b>MAD</b></td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn-show-sale-invoice-payment" data-toggle="modal" data-target="#div-show-old-sale-invoice-payment" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice_payment.show',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <!-- <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice_payment.edit',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a> -->
                                                <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice_payment.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_sale_invoice_payment')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.sale_invoice_payment')}} ?" data-toggle="tooltip" title="{{__('messages.delete')}}"> <i class="fa fa-trash text-danger icon-datatable"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><b>{{__('messages.total_given_amount')}}</b></td>
                                        <td colspan="6"><span class="text-success font-bold">{{$sale_invoice->given_total_amount}} <b>MAD</b></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>{{__('messages.total_remaining_amount')}}</b></td>
                                        <td colspan="6"><span class="text-danger font-bold">{{$sale_invoice->remaining_total_amount}} <b>MAD</b></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.sale_invoice_payments.show_sale_invoice_payment')
@include('modals.destroy')
@include('modals.cancel')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.sale_invoice_payments.show_sale_invoice_payment')
@include('javascript.destroy')
@include('javascript.cancel')
@endsection
