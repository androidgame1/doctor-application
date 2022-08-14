@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.new')}} {{__('messages.prescription')}} </h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.new')}} {{__('messages.prescription')}}</li>
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
                <form method="post" id="form-create-new-prescription" action="@if(auth()->user()->is_administrator){{route('administrator.prescription.store')}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.patient')}}<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('patient_id')?'form-control-danger':''}}"
                                    type="text" name="patient_id" required>
                                    <option value="" selected>{{__('messages.select')}}</option>
                                    @foreach($patients as $value)
                                        <option value="{{$value->id}}">{{$value->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.date')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('date')?'form-control-danger':''}}"
                                    type="date" placeholder="{{__('messages.date')}}" name="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.drug')}}<span class="text-danger"> * </span></label><br>
                                <a href="javascripti:void(0)" data-toggle="modal" data-target="#div-add-new-drug" class="btn btn-info"><i class="fa fa-plus"></i> {{__('messages.add')}} {{__('messages.drag')}}</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.test')}}<span class="text-danger"> * </span></label><br>
                                <a href="javascripti:void(0)" data-toggle="modal" data-target="#div-add-new-test" class="btn btn-warning"><i class="fa fa-plus"></i> {{__('messages.add')}} {{__('messages.test')}}</a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.note')}}<span class="text-danger"> * </span></label>
                                <textarea name="note" class="form-control {{$errors->has('note')?'form-control-danger':''}} note-editor" id="note" required></textarea>
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
@include('modals.drugs.add_drug')
@include('modals.tests.add_test')
@endsection
@section('javascript')
    @include('javascript.helper')
    @include('javascript.drugs.add_drug')
    @include('javascript.tests.add_test')
@endsection
