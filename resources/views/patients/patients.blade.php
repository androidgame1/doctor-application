@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Patients</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">Home</a>
                </li>
                <li class="breadcrumb-item active">Patients</li>
            </ol>
            <a href="@if(auth()->user()->is_administrator){{route('administrator.patient.create')}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.create')}}@else javascript:void(0) @endif" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> New patient</a>
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
                <div class="row">
                    <div class="col-md-12">
                        @include('messages.messages')
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-datatable">
                                <thead>
                                    <tr>
                                        <th class="d-none">#</th>
                                        <th>CIN</th>
                                        <th>Fullname</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>City</th>
                                        <th>Date creation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patients as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td><a href="javascript:void(0)" class="btn-show-patient" data-toggle="modal" data-target="#div-show-old-patient" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.patient.show',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.show',$value->id)}}@else javascript:void(0) @endif">{{$value->cin}}</a></td>
                                            <td>{{$value->fullname}}</td>
                                            <td>{{$value->email}}</td>
                                            <td>{{$value->address}}</td>
                                            <td>{{$value->phone}}</td>
                                            <td>{{$value->city}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)}}</td>
                                            <td>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.patient.show',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.show',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" data-original-title="show"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.patient.edit',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.edit',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.patient.destroy',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="patient" data-message="You want to delete this patient." data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.destroy')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.destroy')
@endsection
