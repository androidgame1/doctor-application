@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-12 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_superadministrator){{route('superadministrator.home')}}@elseif(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.profile')}}</li>
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
                <form method="post" id="form-profile-update" action="@if(auth()->user()->is_superadministrator){{route('superadministrator.profile.update')}}@elseif(auth()->user()->is_administrator){{route('administrator.profile.update')}}@elseif(auth()->user()->is_secretary){{route('secretary.profile.update')}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
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
                                <div class="div-img-user">
                                    <img src="{{asset(auth()->user()->image)}}"
                                        onerror="this.src=`{{asset('assets/images/users/default-user.png')}}`"
                                        class="img-user" alt="">
                                        <span class="fa fa-upload btn-upload-file" onclick="upload('#file-profile')"></span>
                                        <span class="fa fa-trash btn-cancel-file" onclick="cancelImage('.img-user','.img-path-profile')"></span>
                                </div>
                                <input class="form-control {{$errors->has('image')?'form-control-danger':''}} d-none"
                                    type="file" accept="image/*" name="image" id="file-profile" onchange="choseFile(this,'.img-user')">
                                <input type="hidden" name="image_path" class="img-path-profile" value="{{auth()->user()->image}}">
                                </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.fullname')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('fullname')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.fullname')}}" name="fullname"
                                    value="{{auth()->user()->fullname}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.email')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}"
                                    type="email" placeholder="{{__('messages.email')}}" name="email" value="{{auth()->user()->email}}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.address')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('address')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.address')}}" name="address" value="{{auth()->user()->address}}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.phone')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('phone')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.phone')}}" name="phone" value="{{auth()->user()->phone}}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.city')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('city')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.city')}}" name="city" value="{{auth()->user()->city}}"
                                    required>
                            </div>
                        </div>
                        @if(auth()->user()->is_administrator)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-group">{{__('messages.logo')}}<span class="text-danger d-none"> * </span></label>
                                    <input type="file" class="form-control dropify {{$errors->has('logo')?'form-control-danger':''}}"  data-default-file="{{auth()->user()->logo ? asset(auth()->user()->logo) : ''}}" placeholder="{{__('messages.logo')}}" name="logo">
                                </div>
                            </div>
                        @endif
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
    @include('javascript.helper')
@endsection
