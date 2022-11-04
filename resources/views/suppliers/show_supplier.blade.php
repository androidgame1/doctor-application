@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-12 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.supplier')}}</li>
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
                <table id="table-show-old-supplier" class="table browser m-0 no-border">
                    <tbody>
                        <tr class="tr-show">
                            <td><b>{{__('messages.cin')}}</b></td>
                            <td class="text-right"><span class="text-primary" name="cin">{{$supplier->cin}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.fullname')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$supplier->fullname}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.email')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$supplier->email}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.address')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$supplier->address}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.phone')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$supplier->phone}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.city')}}</b></td>
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
