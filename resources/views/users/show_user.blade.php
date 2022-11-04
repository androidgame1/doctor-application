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
                <li class="breadcrumb-item active">{{$user->rolesingularname}}</li>
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
    @if(auth()->user()->is_administrator && $user->role == '2')
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <a href="#secretary_patients" class="btn btn-secondary btn-appointments-target">{{__('messages.patients')}}</a>
                        <a href="#secretary_appointments" class="btn btn-success btn-quotes-target">{{__('messages.appointments')}}</a>
                        <a href="#secretary_charges" class="btn btn-danger btn-activities-target">{{__('messages.charges')}}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <div class="table-responsive">
                <table id="table-show-old-user" class="table browser m-0 no-border">
                    <tbody>
                        <tr class="tr-show">
                            <td><b>{{__('messages.cin')}}</b></td>
                            <td class="text-right"><span class="text-primary" name="cin">{{$user->cin}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.fullname')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$user->fullname}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.email')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$user->email}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.address')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$user->address}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.phone')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$user->phone}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.city')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$user->city}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.status')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="status">{!!$user->status!!}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td colspan="2" class="text-center" name="edit-status" ><a href="@if(auth()->user()->is_administrator){{route('administrator.user.status.update',['role'=>$role,'id'=>$user->id])}}@elseif(auth()->user()->is_superadministrator){{route('superadministrator.user.status.update',['role'=>$role,'id'=>$user->id])}} @else javascript:void(0) @endif" class="btn {{$user->editstatus['class']}}">{{$user->editstatus['value']}}</a></td>
                        </tr>
                    </tbody>
                    </table>
            </div>
            </div>
        </div>
    </div>
    @if(auth()->user()->is_administrator && $user->role == '2')
        <div class="col-12" id="secretary_patients">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{__('messages.patients')}}</h4>
                        </div>
                        <div class="col-md-12">
                            @include('tables.patients',['patients'=>$user->patientsSecretary])
                        </div>
                    </div>

                </div>
        </div>
        <div class="col-12" id="secretary_appointments">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{__('messages.appointments')}}</h4>
                        </div>
                        <div class="col-md-12">
                            @include('tables.appointments',['appointments'=>$user->appointmentsSecretary,'patients'=>$patients,'status'=>$status])
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12" id="secretary_charges">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>{{__('messages.charges')}}</h4>
                        </div>
                        <div class="col-md-12">
                            @include('tables.charges',['charges'=>$user->chargesSecretary,'total_amount'=>$total_amount_charges,'total_given_amount'=>$total_given_amount_charges,'total_remaining_amount'=>$total_remaining_amount_charges])
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
@include('modals.destroy')
@include('modals.cancel')

@include('modals.appointments.create_appointment')
@include('modals.appointments.edit_appointment')
@include('modals.appointments.show_appointment')

@include('modals.charges.create_charge',['secretary'=>$user])
@include('modals.charges.edit_charge',['secretary'=>$user])
@include('modals.charges.show_charge',['secretary'=>$user])
@endsection
@section('javascript')
    @include('javascript.helper')
    @include('javascript.datatable')

    @include('javascript.appointments.edit_appointment')
    @include('javascript.appointments.show_appointment')

    @include('javascript.charges.edit_charge')
    @include('javascript.charges.show_charge')

    @include('javascript.destroy')
    @include('javascript.cancel')
@endsection
