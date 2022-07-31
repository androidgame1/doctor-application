@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Profile</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_superadministrator){{route('superadministrator.home')}}@elseif(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">Home</a>
                </li>
                <li class="breadcrumb-item active">Profile</li>
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
                <form method="post" id="form-profile-update"
                    action="@if(auth()->user()->is_superadministrator){{route('superadministrator.profile.update')}}@elseif(auth()->user()->is_administrator){{route('administrator.profile.update')}}@elseif(auth()->user()->is_secretary){{route('secretary.profile.update')}} @else javascript:void(0) @endif"
                    enctype="multipart/form-data" novalidate>
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12 cl-12">
                            <div class="form-group ">
                                @include('messages.messages')
                            </div>
                        </div>
                        <div class="col-md-12 cl-12">
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
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Fullname<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('fullname')?'form-control-danger':''}}"
                                    type="text" placeholder="Fullname" name="fullname"
                                    value="{{auth()->user()->fullname}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Email<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}"
                                    type="email" placeholder="Email" name="email" value="{{auth()->user()->email}}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Address<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('address')?'form-control-danger':''}}"
                                    type="text" placeholder="Address" name="address" value="{{auth()->user()->address}}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Phone<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('phone')?'form-control-danger':''}}"
                                    type="text" placeholder="Phone" name="phone" value="{{auth()->user()->phone}}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">City<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('city')?'form-control-danger':''}}"
                                    type="text" placeholder="city" name="city" value="{{auth()->user()->city}}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-12 cl-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> Modify</button>
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
