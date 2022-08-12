@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Patient</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.patients')}}@elseif(auth()->user()->is_secretary){{route('secretary.patients')}}@else javascript:void(0) @endif">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Patient</li>
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
                        <tr>
                            <td><b></b>CIN</td>
                            <td class="text-right"><span class="text-primary" name="cin">{{$patient->cin}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Fullname</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$patient->fullname}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$patient->email}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$patient->address}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Phone</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$patient->phone}}</span></td>
                        </tr>
                        <tr>
                            <td><b>City</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->city}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Birthday</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{\Carbon\Carbon::parse($patient->birthday)->format('Y-m-d')}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Gender</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->gender_value}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Blood group</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->blood_group}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Weight</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$patient->weight}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Height</b></td>
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
