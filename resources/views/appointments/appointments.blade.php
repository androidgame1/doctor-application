@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-12 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.appointments')}}</li>
            </ol>
    </div>
    <div class="col-md-12 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <a href="javascript:void(0)" class="btn btn-info d-none d-lg-block m-l-15"  data-toggle="modal" data-target="#div-create-new-appointment"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.appointment')}}</a>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
@if(auth()->user()->is_administrator)
@include('includes.search_between_two_dates',['route'=>'administrator.appointments.dates.filter','param1'=>'appointments']) 
<div class="row">
        <div class="col-12">
            <div class="card-group">
                @foreach($counts_appintment_status as $count_appintment_status)
                    <div class="card">
                        <a href="javascript:void(0)">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h3><i class="fa fa-calendar-o" style="color:{{$count_appintment_status->color}}"></i></h3>
                                                <p class="text-muted">{{$count_appintment_status->name}}</p>
                                            </div>
                                            <div class="ml-auto">
                                                <h2 class="counter" style="color:{{$count_appintment_status->color}}">{{$count_appintment_status->count_appointments}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 100%; height: 6px;background:{{$count_appintment_status->color}}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div> 
        </div>
    </div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('messages.messages')
                    </div>
                    <div class="col-md-12">
                        @include('tables.appointments',$appointments)
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.appointments.create_appointment')
@include('modals.appointments.edit_appointment')
@include('modals.appointments.show_appointment')
@include('modals.destroy')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.appointments.edit_appointment')
@include('javascript.appointments.show_appointment')
@include('javascript.destroy')
@endsection
