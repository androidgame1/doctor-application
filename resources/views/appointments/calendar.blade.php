@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-12 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.calendar')}}</li>
            </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body b-l calender-sidebar">
                            <div class="div-status">
                                @foreach($status as $value)
                                    <span class="badge text-white font-bold" style="background:{{$value->color}}">{{$value->name}}</span>
                                @endforeach
                            </div>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="div-calendar-title"></div>
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
@include('javascript.appointments.fullcalendar')
@endsection
