@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-12 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretray) {{route('secretary.home')}} @else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.patients')}}@elseif(auth()->user()->is_secretray) {{route('secretary.patients')}} @else javascript:void(0) @endif">{{__('messages.patients')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.new_patient')}}</li>
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
                <form method="post" id="form-create-new-patient" action="@if(auth()->user()->is_administrator){{route('administrator.patient.store')}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.store')}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.cin')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('cin')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.cin')}}" name="cin" value="{{old('cin')}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.fullname')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('fullname')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.fullname')}}" name="fullname"  value="{{old('fullname')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.email')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}"
                                    type="email" placeholder="{{__('messages.email')}}" value="{{old('email')}}" name="email">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.address')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('address')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.address')}}" name="address" value="{{old('address')}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.phone')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('phone')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.phone')}}" name="phone" value="{{old('phone')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.city')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('city')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.city')}}" value="{{old('city')}}" name="city">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.birthday')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('birthday')?'form-control-danger':''}}"
                                    type="date" placeholder="yyyy-mm-dd" name="birthday" value="{{old('birthday')}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.gender')}}<span class="text-danger d-none"> * </span></label>
                                <select class="form-control {{$errors->has('gender')?'form-control-danger':''}}" name="gender">
                                    <option value="">{{__('messages.select')}}</option>
                                    <option value="0" {{old('gender') == '0' ? 'selected' : ''}}>Male</option>
                                    <option value="1" {{old('gender') == '1' ? 'selected' : ''}}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.blood_group')}}<span class="text-danger d-none"> * </span></label>
                                <select class="form-control {{$errors->has('blood_group')?'form-control-danger':''}}" name="blood_group">
                                    <option value="">{{__('messages.select')}}</option>
                                    <option value="A+" {{old('blood_group') == 'A+' ? 'selected' : '')}}>A+</option>
                                    <option value="A-" {{old('blood_group') == 'A-' ? 'selected' : '')}}>A-</option>
                                    <option value="B+" {{old('blood_group') == 'B+' ? 'selected' : '')}}>B+</option>
                                    <option value="B-" {{old('blood_group') == 'B-' ? 'selected' : '')}}>B-</option>
                                    <option value="AB+" {{old('blood_group') == 'AB+' ? 'selected' : '')}}>AB+</option>
                                    <option value="AB-" {{old('blood_group') == 'AB-' ? 'selected' : '')}}>AB-</option>
                                    <option value="O+" {{old('blood_group') == 'O+' ? 'selected' : '')}}>O+</option>
                                    <option value="O-" {{old('blood_group') == 'O-' ? 'selected' : '')}}>O-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.weight')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('weight')?'form-control-danger':''}}"
                                    type="number" min="0" step="0.01" value="0" placeholder="{{__('messages.weight')}}" name="weight" value="{{old('weight')}}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.height')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('height')?'form-control-danger':''}}"
                                    type="number" min="0" step="0.01" value="0" placeholder="{{__('messages.height')}}" name="height" value="{{old('height')}}">
                            </div>
                        </div>
                        <div class="col-12">
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
@endsection
