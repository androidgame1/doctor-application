@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit patient</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_secretary){{route('secretary.patients')}}@else javascript:void(0) @endif">Home</a>
                </li>
                <li class="breadcrumb-item active">Edit patient</li>
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
                <form method="post" id="form-edit-patient" action="@if(auth()->user()->is_administrator){{route('administrator.patient.update',$patient->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.update',$patient->id)}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">CIN<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('cin')?'form-control-danger':''}}"
                                    type="text" placeholder="CIN" name="cin" value="{{$patient->cin}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Fullname<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('fullname')?'form-control-danger':''}}"
                                    type="text" placeholder="Fullname" name="fullname" value="{{$patient->fullname}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Email<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}"
                                    type="email" placeholder="Email" name="email"  value="{{$patient->email}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Address<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('address')?'form-control-danger':''}}"
                                    type="text" placeholder="Address" name="address" value="{{$patient->address}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Phone<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('phone')?'form-control-danger':''}}"
                                    type="text" placeholder="Phone" name="phone" value="{{$patient->phone}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">City<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('city')?'form-control-danger':''}}"
                                    type="text" placeholder="city" name="city" value="{{$patient->city}}" >
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Birthday<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('birthday')?'form-control-danger':''}}"
                                    type="date" placeholder="yyyy-mm-dd" name="birthday" value="{{\Carbon\Carbon::parse($patient->birthday)->format('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Gender<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('gender')?'form-control-danger':''}}" name="gender" required>
                                    <option value="">Select</option>
                                    <option value="0" {{$patient->gender == '0' ? 'selected' : ''}}>Male</option>
                                    <option value="1" {{$patient->gender == '1' ? 'selected' : ''}}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Blood group<span class="text-danger d-none"> * </span></label>
                                <select class="form-control {{$errors->has('blood_group')?'form-control-danger':''}}" name="blood_group" >
                                    <option value="">Select</option>
                                    <option value="A+" {{$patient->blood_group == 'A+' ? 'selected' : ''}}>A+</option>
                                    <option value="A-" {{$patient->blood_group == 'A-' ? 'selected' : ''}}>A-</option>
                                    <option value="B+" {{$patient->blood_group == 'B+' ? 'selected' : ''}}>B+</option>
                                    <option value="B-" {{$patient->blood_group == 'B-' ? 'selected' : ''}}>B-</option>
                                    <option value="AB+" {{$patient->blood_group == 'AB+' ? 'selected' : ''}}>AB+</option>
                                    <option value="AB-" {{$patient->blood_group == 'AB-' ? 'selected' : ''}}>AB-</option>
                                    <option value="O+" {{$patient->blood_group == 'O+' ? 'selected' : ''}}>O+</option>
                                    <option value="O-" {{$patient->blood_group == 'O-' ? 'selected' : ''}}>O-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Weight<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('weight')?'form-control-danger':''}}"
                                    type="number" min="0" value="0" placeholder="Weight" name="weight" value="{{$patient->weight}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Height<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('height')?'form-control-danger':''}}"
                                    type="number" min="0" value="0" placeholder="Height" name="height" value="{{$patient->height}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Modifier</button>
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
