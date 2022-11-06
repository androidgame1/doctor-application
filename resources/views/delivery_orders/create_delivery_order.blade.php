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
                        href="@if(auth()->user()->is_administrator){{route('administrator.delivery_orders')}}@else javascript:void(0) @endif">{{__('messages.delivery_orders')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.new_delivery_order')}}</li>
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
                <form method="post" id="form-create-new-delivery-order" action="@if(auth()->user()->is_administrator){{route('administrator.delivery_order.store')}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('post')
                    @csrf
                    <input type="hidden" name="way_storing" value="store">
                    <input type="hidden" name="action" id="action" value="{{Route::current()->getName() == 'administrator.delivery_order.convert_po_to_do' ? 'convert' : 'store'}}">
                    @if(Route::current()->getName() == 'administrator.delivery_order.convert_po_to_do')
                        <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="{{$purchase_order->id}}">
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        @if($purchase_order)
                            <div class="col-md-12">
                                <h3>{{__('messages.purchase_order')}} : <a href="javascript:void(0)" class="text-primary font-bold">{{$purchase_order->series}}</a></span></h3>
                            </div>
                        @endif
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.suppliers')}}<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('supplier_id')?'no-valid':''}}"
                                    type="text" name="supplier_id" required>
                                    <option value="" selected>{{__('messages.select')}}</option>
                                    @foreach($suppliers as $value)
                                        <option value="{{$value->id}}" @if(Route::current()->getName() == 'administrator.delivery_order.convert_po_to_do') {{$purchase_order->supplier->id == $value->id ? 'selected' : ''}} @endif>{{$value->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.series')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('series')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.series')}}" value="{{old('series')}}" name="series" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.date')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('date')?'no-valid':''}}"
                                    type="date" placeholder="{{__('messages.date')}}" name="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.file')}}<span class="text-danger d-none"> * </span></label>
                                <input type="file" class="form-control dropify {{$errors->has('file')?'no-valid':''}}" placeholder="{{__('messages.file')}}" name="file">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.remark')}}<span class="text-danger d-none"> * </span></label>
                                <textarea rows="5" class="form-control {{$errors->has('remark')?'no-valid':''}}" placeholder="{{__('messages.remark')}}" name="remark">{{old('remark')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            @include('includes.adding_rows')
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('messages.save')}}</button>
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
