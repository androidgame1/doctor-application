@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.patient')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.patient')}}</li>
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
</div>
@endsection
@section('javascript')
    @include('javascript.helper')
@endsection
