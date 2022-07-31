@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{$user->rolesingularname}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_superadministrator){{route('superadministrator.home')}}@elseif(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">Home</a>
                </li>
                <li class="breadcrumb-item active">{{$user->rolesingularname}}</li>
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
            <div class="table-responsive">
                <table id="table-show-old-user" class="table browser m-0 no-border">
                    <tbody>
                        <tr>
                            <td><b></b>CIN</td>
                            <td class="text-right"><span class="text-primary" name="cin">{{$user->cin}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Fullname</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$user->fullname}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$user->email}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$user->address}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Phone</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$user->phone}}</span></td>
                        </tr>
                        <tr>
                            <td><b>City</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$user->city}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td class="text-right"><span class="text-gray" name="status">{!!$user->status!!}</span></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center" name="edit-status" ><a href="@if(auth()->user()->is_administrator){{route('administrator.user.status.update',['role'=>$role,'id'=>$user->id])}}@elseif(auth()->user()->is_superadministrator){{route('superadministrator.user.status.update',['role'=>$role,'id'=>$user->id])}} @else javascript:void(0) @endif" class="btn {{$user->editstatus['class']}}">{{$user->editstatus['value']}}</a></td>
                        </tr>
                    </tbody>
                    </table>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
    @include('javascript.helper')
@endsection
