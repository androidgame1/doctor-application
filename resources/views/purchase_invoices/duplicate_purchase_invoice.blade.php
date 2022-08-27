@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.duplicate_purchase_invoice')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.duplicate_purchase_invoice')}}</li>
            </ol>
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
                <form method="post" id="form-duplicate-purchase-invoice" action="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.store')}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.suppliers')}}<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('supplier_id')?'form-control-danger':''}}"
                                    type="text" name="supplier_id" required>
                                    <option value="" selected>{{__('messages.select')}}</option>
                                    @foreach($suppliers as $value)
                                        <option value="{{$value->id}}" {{$value->id == $purchase_invoice->supplier_id ? 'selected' : ''}}>{{$value->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.series')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('series')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.series')}}" value="{{$series}}" name="series" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.date')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('date')?'form-control-danger':''}}"
                                    type="date" placeholder="{{__('messages.date')}}" name="date" value="{{\Carbon\Carbon::parse($purchase_invoice->date)->format('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.remark')}}<span class="text-danger d-none"> * </span></label>
                                <textarea rows="4" class="form-control {{$errors->has('remark')?'form-control-danger':''}}" placeholder="{{__('messages.remark')}}" name="remark">{{$purchase_invoice->remark}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            @include('includes.adding_rows')
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-files-o"></i> {{__('messages.duplicate')}}</button>
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
    @include('javascript.adding_rows')
@endsection
