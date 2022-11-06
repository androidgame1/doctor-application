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
                        href="@if(auth()->user()->is_administrator){{route('administrator.delivery_order_payments',$delivery_order->id)}}@else javascript:void(0) @endif">{{__('messages.delivery_order_payments')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.edit_delivery_order_payment')}}</li>
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
                <form method="post" id="form-create-new-purchase-invoice-payment" action="@if(auth()->user()->is_administrator){{route('administrator.delivery_order_payment.update',$delivery_order_payment->id)}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('put')
                    @csrf
                    <input type="hidden" name="delivery_order_id" value="{{$delivery_order_payment->delivery_order_id}}">
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        @include('delivery_order_payments.payment_to')
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.date')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('date')?'no-valid':''}}"
                                    type="date" placeholder="{{__('messages.date')}}" name="date" value="{{\Carbon\Carbon::parse($delivery_order_payment->date)->format('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.way_of_payment')}}<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('way_of_payment')?'no-valid':''}}"
                                    type="text" name="way_of_payment" required>
                                    <option value="" selected>{{__('messages.select')}}</option>
                                    <option value="cash" {{$delivery_order_payment->way_of_payment == 'cash' ? 'selected' : ''}}>{{__('messages.cash')}}</option>
                                    <option value="check" {{$delivery_order_payment->way_of_payment == 'check' ? 'selected' : ''}}>{{__('messages.check')}}</option>
                                    <option value="credit_card" {{$delivery_order_payment->way_of_payment == 'credit_card' ? 'selected' : ''}}>{{__('messages.credit_card')}}</option>
                                    <option value="debit_card" {{$delivery_order_payment->way_of_payment == 'debit_card' ? 'selected' : ''}}>{{__('messages.debit_card')}}</option>
                                    <option value="others" {{$delivery_order_payment->way_of_payment == 'others' ? 'selected' : ''}}>{{__('messages.others')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.amount')}}<span class="text-danger"> * </span></label>
                                <input type="number" value="{{$delivery_order_payment->given_amount}}" min="0.1" max="{{$delivery_order_payment->remainig_amount_plus_edited_given_amount}}" step="0.01" class="form-control {{$errors->has('given_amount')?'no-valid':''}}" placeholder="{{__('messages.given_amount')}}" name="given_amount" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.justification')}}<span class="text-danger d-none"> * </span></label>
                                <input type="file" class="form-control dropify {{$errors->has('justification')?'no-valid':''}}" data-default-file="{{$delivery_order_payment->justification ? asset($delivery_order_payment->justification) : ''}}" placeholder="{{__('messages.justification')}}" name="justification">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.remark')}}<span class="text-danger d-none"> * </span></label>
                                <textarea rows="5" class="form-control {{$errors->has('remark')?'no-valid':''}}" placeholder="{{__('messages.remark')}}" name="remark">{{$delivery_order_payment->remark}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> {{__('messages.modify')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
    @include('javascript.helper')
@endsection
