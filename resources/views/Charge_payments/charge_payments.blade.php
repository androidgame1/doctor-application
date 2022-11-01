@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.charge_payments')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.charge_payments')}}</li>
            </ol>
            @if($charge->status == '0' || $charge->status == '1')
                <a href="@if(auth()->user()->is_administrator){{route('administrator.charge_payment.create',$charge->id)}}@else javascript:void(0) @endif" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.charge')}}</a>
            @elseif($charge->status == '2')
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
                        <h3>{{__('messages.charge')}} N° : <a href="javascript:void(0)" class="btn-show-charge text-primary font-bold" title="{{__('messages.show')}}">{{$charge->id}}</a></span></h3>
                        <h3>{{__('messages.name')}} : <a href="javascript:void(0)">{{$charge->name}}</a></span></h3>
                        @if($charge->secretary)
                            <h3>{{__('messages.secretary')}} : <a href="javascript:void(0)">{{$charge->secretary->fullname}}</a></span></h3>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-datatable">
                                <thead>
                                    <tr>
                                        <th class="d-none">#</th>
                                        <th>{{__('messages.date')}}</th>
                                        <th>{{__('messages.given_amount')}}</th>
                                        <th>{{__('messages.remaining_amount')}}</th>
                                        <th>{{__('messages.way_of_payment')}}</th>
                                        <th>{{__('messages.date_creation')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($charge_payments as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                                            <td>{{$value->given_amount}} <b>MAD</b></td>
                                            <td>{{$value->remaining_amount}} <b>MAD</b></td>
                                            <td>{{$value->way_of_payment_name}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn-show-charge-payment" data-toggle="modal" data-target="#div-show-old-charge-payment" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.charge_payment.show',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <!-- <a href="@if(auth()->user()->is_administrator){{route('administrator.charge_payment.edit',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a> -->
                                                <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.charge_payment.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_charge_payment')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.charge_payment')}} ?" title="{{__('messages.delete')}}"> <i class="fa fa-trash text-danger icon-datatable"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><b>{{__('messages.total_amount')}}</b></td>
                                        <td colspan="6"><span class="font-bold">{{$charge->amount}} <b>MAD</b></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>{{__('messages.total_given_amount')}}</b></td>
                                        <td colspan="6"><span class="text-success font-bold">{{$charge->given_total_amount}} <b>MAD</b></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>{{__('messages.total_remaining_amount')}}</b></td>
                                        <td colspan="6"><span class="text-danger font-bold">{{$charge->remaining_total_amount}} <b>MAD</b></span></td>
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
@include('modals.charge_payments.show_charge_payment')
@include('modals.destroy')
@include('modals.cancel')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.charge_payments.show_charge_payment')
@include('javascript.destroy')
@include('javascript.cancel')
@endsection
