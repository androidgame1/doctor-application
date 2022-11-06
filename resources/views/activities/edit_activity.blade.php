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
                    href="@if(auth()->user()->is_administrator){{route('administrator.activities')}}@else javascript:void(0) @endif">{{__('messages.activities')}}</a>
            </li>
            <li class="breadcrumb-item active">{{__('messages.edit_activity')}}</li>
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
                <form method="post" id="form-edit-activity" action="@if(auth()->user()->is_administrator){{route('administrator.activity.update',$activity->id)}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.patient')}}<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('patient_id')?'no-valid':''}}"
                                    type="text" name="patient_id" required>
                                    <option value="" selected>{{__('messages.select')}}</option>
                                    @foreach($patients as $value)
                                        <option value="{{$value->id}}" {{$value->id == $activity->patient_id ? 'selected' : ''}}>{{$value->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.series')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('series')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.series')}}" value="{{$activity->series}}" name="series" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.date')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('date')?'no-valid':''}}"
                                    type="date" placeholder="{{__('messages.date')}}" name="date" value="{{\Carbon\Carbon::parse($activity->date)->format('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.remark')}}<span class="text-danger d-none"> * </span></label>
                                <textarea rows="4" class="form-control {{$errors->has('remark')?'no-valid':''}}" placeholder="{{__('messages.remark')}}" name="remark">{{$activity->remark}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            @include('includes.adding_rows')
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
    @include('javascript.adding_rows')
@endsection
