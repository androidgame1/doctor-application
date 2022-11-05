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
                <li class="breadcrumb-item active">{{__('messages.patient')}}</li>
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
                <div>
                    <a href="#patient_appointments" class="btn btn-secondary">{{__('messages.appointments')}}</a>
                    <a href="#patient_quotes" class="btn btn-success">{{__('messages.quotes')}}</a>
                    <a href="#patient_activities" class="btn btn-danger">{{__('messages.activities')}}</a>
                    <a href="#patient_sale_invoices" class="btn btn-warning">{{__('messages.sale_invoices')}}</a>
                </div>
            </div>
        </div>
    </div>        
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="table-show-old-patient" class="table browser no-border">
                    <tbody>
                        <tr class="tr-show">
                            <td><b>{{__('messages.cin')}}</b></td>
                            <td class="text-right"><span class="text-primary" name="cin">{{$patient->cin}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.fullname')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$patient->fullname}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.email')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$patient->email}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.address')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$patient->address}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.phone')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$patient->phone}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.city')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->city}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.birthday')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{\Carbon\Carbon::parse($patient->birthday)->format('d/m/Y')}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.gender')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->gender_value}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.blood_group')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->blood_group}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.weight')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->weight}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.height')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->height}}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12" id="patient_appointments">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{__('messages.appointments')}}</h4>
                    </div>
                    <div class="col-md-12">
                        @include('tables.appointments',['appointments'=>$patient->appointments,'patients'=>$patients,'status'=>$status])
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12" id="patient_prescriptions">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{__('messages.prescriptions')}}</h4>
                    </div>
                    <div class="col-md-12">
                        @include('tables.prescriptions',['prescriptions'=>$patient->prescriptions])
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12" id="patient_quotes">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{__('messages.quotes')}}</h4>
                    </div>
                    <div class="col-md-12">
                        @include('tables.quotes',['quotes'=>$patient->quotes])
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12" id="patient_activities">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{__('messages.activities')}}</h4>
                    </div>
                    <div class="col-md-12">
                        @include('tables.activities',['activities'=>$patient->activities,'total_amount'=>$total_amount_activities,'total_given_amount'=>$total_given_amount_activities,'total_remaining_amount'=>$total_remaining_amount_activities])
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-12" id="patient_sale_invoices">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{__('messages.sale_invoices')}}</h4>
                    </div>
                    <div class="col-md-12">
                        @include('tables.sale_invoices',['sale_invoices'=>$patient->sale_invoices,'total_amount'=>$total_amount_sale_invoices,'total_given_amount'=>$total_given_amount_sale_invoices,'total_remaining_amount'=>$total_remaining_amount_sale_invoices])
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.destroy')
@include('modals.cancel')

@include('modals.appointments.create_appointment')
@include('modals.appointments.edit_appointment')
@include('modals.appointments.show_appointment')

@endsection
@section('javascript')
    @include('javascript.helper')
    @include('javascript.datatable')

    @include('javascript.appointments.edit_appointment')
    @include('javascript.appointments.show_appointment')

    @include('javascript.destroy')
    @include('javascript.cancel')
@endsection
