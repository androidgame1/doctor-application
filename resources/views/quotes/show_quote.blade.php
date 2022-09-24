@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.quote')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.quote')}}</li>
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
                            <td><b>{{__('messages.series')}}</b></td>
                            <td class="text-right"><a href = "@if(auth()->user()->is_administrator) {{route('administrator.quote.show',$quote->id)}} @else javascript:void(0) @endif" class="text-primary" name="cin">{{$quote->series}}</a></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.patient')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$quote->patient->fullname}}</span></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.total_amount_of_reduction')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$quote->reduction_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.total_mount_of_ht')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$quote->ht_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.date')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{\Carbon\Carbon::parse($quote->date)->format('d/m/Y')}}</span></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.remarque')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$quote->remark}}</span></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.status')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{!!$quote->status_state!!}</span></td>
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
