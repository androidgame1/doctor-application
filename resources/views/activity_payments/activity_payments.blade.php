@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-6 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.activity_payments')}}</li>
            </ol>
    </div>
    <div class="col-md-6 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            @if($activity->status == '0' || $activity->status == '1')
                <a href="@if(auth()->user()->is_administrator){{route('administrator.activity_payment.create',$activity->id)}}@else javascript:void(0) @endif" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.activity')}}</a>
            @elseif($activity->status == '2')
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
                    @include('activity_payments.payment_to')
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
                                    @foreach($activity_payments as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                                            <td>{{$value->given_amount}} <b>MAD</b></td>
                                            <td>{{$value->remaining_amount}} <b>MAD</b></td>
                                            <td>{{$value->way_of_payment_name}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn-show-activity-payment" data-toggle="modal" data-target="#div-show-old-activity-payment" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.activity_payment.show',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <!-- <a href="@if(auth()->user()->is_administrator){{route('administrator.activity_payment.edit',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a> -->
                                                <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.activity_payment.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_activity_payment')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.activity_payment')}} ?" title="{{__('messages.delete')}}"> <i class="fa fa-trash text-danger icon-datatable"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><b>{{__('messages.total_amount')}}</b></td>
                                        <td colspan="5"><span class="font-bold">{{$activity->ttc_total_amount}} <b>MAD</b></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>{{__('messages.total_given_amount')}}</b></td>
                                        <td colspan="5"><span class="text-success font-bold">{{$activity->given_total_amount}} <b>MAD</b></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>{{__('messages.total_remaining_amount')}}</b></td>
                                        <td colspan="5"><span class="text-danger font-bold">{{$activity->remaining_total_amount}} <b>MAD</b></span></td>
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
@include('modals.activity_payments.show_activity_payment')
@include('modals.destroy')
@include('modals.cancel')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.activity_payments.show_activity_payment')
@include('javascript.destroy')
@include('javascript.cancel')
@endsection
