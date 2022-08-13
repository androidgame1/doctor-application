@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.change_password')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_superadministrator){{route('superadministrator.home')}}@elseif(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.change_password')}}</li>
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
                <form method="post" id="form-password-update" action="@if(auth()->user()->is_superadministrator){{route('superadministrator.password.update')}}@elseif(auth()->user()->is_administrator){{route('administrator.password.update')}}@elseif(auth()->user()->is_secretary){{route('secretary.password.update')}} @else javascript:void(0) @endif" class="needs-validation" novalidate>
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group ">
                                @include('messages.messages')
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.old_password')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('old_password')?'form-control-danger':''}}"
                                    type="password" placeholder="{{__('messages.old_password')}}" name="old_password" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.new_password')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('new_password')?'form-control-danger':''}}"
                                    type="password" placeholder="{{__('messages.new_password')}}" name="new_password" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.confirm_password')}}<span class="text-danger"> * </span></label>
                                <input
                                    class="form-control {{$errors->has('confirm_password')?'form-control-danger':''}}"
                                    type="password" placeholder="{{__('messages.confirm_password')}}" name="confirm_password" required>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> {{__('messages.modify')}}</button>
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
@endsection
