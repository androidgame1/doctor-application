@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Supplier</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.suppliers')}}@else javascript:void(0) @endif">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Supplier</li>
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
                <table id="table-show-old-supplier" class="table browser m-t-30 no-border">
                    <tbody>
                        <tr>
                            <td><b></b>CIN</td>
                            <td class="text-right"><span class="text-primary" name="cin">{{$supplier->cin}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Fullname</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$supplier->fullname}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$supplier->email}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$supplier->address}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Phone</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$supplier->phone}}</span></td>
                        </tr>
                        <tr>
                            <td><b>City</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$supplier->city}}</span></td>
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
