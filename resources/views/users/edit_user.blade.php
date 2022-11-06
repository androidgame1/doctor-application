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
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_superadministrator){{route('superadministrator.users',$role)}}@elseif(auth()->user()->is_administrator){{route('administrator.users',$role)}}@else javascript:void(0) @endif">@if($role=="administrator") {{__('messages.administrators')}} @elseif($role == "secretary") {{__('messages.secretaries')}} @endif</a>
                </li>
                <li class="breadcrumb-item active">@if($role=="administrator") {{__('messages.edit_administrator')}} @elseif($role == "secretary") {{__('messages.edit_secretary')}} @endif</li>
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
                <form method="post" id="form-edit-user" action="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.update',['role'=>$role,'id'=>$user->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.update',['role'=>$role,'id'=>$user->id])}} @else javascript:void(0) @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('put')
                    @csrf
                    <input type="hidden" name="role" value="{{$role}}">
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.cin')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('cin')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.cin')}}" name="cin" value="{{$user->cin}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.fullname')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('fullname')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.fullname')}}" name="fullname" value="{{$user->fullname}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.email')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('email')?'no-valid':''}}"
                                    type="email" placeholder="{{__('messages.email')}}" name="email" value="{{$user->email}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.address')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('address')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.address')}}" name="address" value="{{$user->address}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.phone')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('phone')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.phone')}}" name="phone" value="{{$user->phone}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.city')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('city')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.city')}}" name="city" value="{{$user->city}}" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.password')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('password')?'no-valid':''}}"
                                    type="password" placeholder="{{__('messages.password')}}" name="password">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.confirm_password')}}<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('confirm_password')?'no-valid':''}}"
                                    type="password" placeholder="{{__('messages.confirm_password')}}" name="confirm_password">
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
@endsection
