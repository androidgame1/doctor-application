@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit @if($role=="administrator") administrator @elseif($role == "secretary") secretary @elseif($role == "deliveryman") delivery man @else error @endif</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_superadministrator){{route('superadministrator.home')}}@elseif(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">Home</a>
                </li>
                <li class="breadcrumb-item active">Edit {{$role}}</li>
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
                <form method="post" id="form-edit-user" action="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.update',['role'=>$role,'id'=>$user->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.update',['role'=>$role,'id'=>$user->id])}} @else javascript:void(0) @endif" enctype="multipart/form-data" novalidate>
                    @method('put')
                    @csrf
                    <input type="hidden" name="role" value="{{$role}}">
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">CIN<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('cin')?'form-control-danger':''}}"
                                    type="text" placeholder="CIN" name="cin" value="{{$user->cin}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Fullname<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('fullname')?'form-control-danger':''}}"
                                    type="text" placeholder="Fullname" name="fullname" value="{{$user->fullname}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Email<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}"
                                    type="email" placeholder="Email" name="email" value="{{$user->email}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Address<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('address')?'form-control-danger':''}}"
                                    type="text" placeholder="Address" name="address" value="{{$user->address}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Phone<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('phone')?'form-control-danger':''}}"
                                    type="text" placeholder="Phone" name="phone" value="{{$user->phone}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">City<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('city')?'form-control-danger':''}}"
                                    type="text" placeholder="City" name="city" value="{{$user->city}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Password<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('password')?'form-control-danger':''}}"
                                    type="password" placeholder="Password" name="password">
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Confirm password<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('confirm_password')?'form-control-danger':''}}"
                                    type="password" placeholder="Confirm password" name="confirm_password">
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
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
