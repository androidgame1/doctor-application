@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">New patient</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_secretary){{route('secretary.patients')}}@else javascript:void(0) @endif">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">New patient</li>
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
                <form method="post" id="form-create-new-patient" action="@if(auth()->user()->is_administrator){{route('administrator.patient.store')}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.store')}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">CIN<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('cin')?'form-control-danger':''}}"
                                    type="text" placeholder="CIN" name="cin" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Fullname<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('fullname')?'form-control-danger':''}}"
                                    type="text" placeholder="Fullname" name="fullname" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Email<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}"
                                    type="email" placeholder="Email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Address<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('address')?'form-control-danger':''}}"
                                    type="text" placeholder="Address" name="address">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Phone<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('phone')?'form-control-danger':''}}"
                                    type="text" placeholder="Phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">City<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('city')?'form-control-danger':''}}"
                                    type="text" placeholder="city" name="city">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Birthday<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('birthday')?'form-control-danger':''}}"
                                    type="date" placeholder="yyyy-mm-dd" name="birthday" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Gender<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('gender')?'form-control-danger':''}}" name="gender" required>
                                    <option value="">Select</option>
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Blood group<span class="text-danger d-none"> * </span></label>
                                <select class="form-control {{$errors->has('blood_group')?'form-control-danger':''}}" name="blood_group">
                                    <option value="">Select</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Weight<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('weight')?'form-control-danger':''}}"
                                    type="number" min="0" value="0" placeholder="Weight" name="weight">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Height<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('height')?'form-control-danger':''}}"
                                    type="number" min="0" value="0" placeholder="Height" name="height">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
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
