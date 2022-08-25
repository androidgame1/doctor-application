@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.sale_invoice')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.sale_invoice')}}</li>
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
                            <td class="text-right"><a href = "@if(auth()->user()->is_administrator) {{route('administrator.sale_invoice.show',$sale_invoice->id)}} @else javascript:void(0) @endif" class="text-primary" name="cin">{{$sale_invoice->series}}</a></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.patient')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$sale_invoice->patient->fullname}}</span></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.total_amount_of_reduction')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$sale_invoice->reduction_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.total_mount_of_ht')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$sale_invoice->ht_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.total_amount_of_tva')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$sale_invoice->tva_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.total_amount_of_ttc')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$sale_invoice->ttc_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.date')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{\Carbon\Carbon::parse($sale_invoice->date)->format('Y-m-d')}}</span></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.remarque')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$sale_invoice->remark}}</span></td>
                        </tr>
                        <tr>
                            <td><b>{{__('messages.status')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{!!$sale_invoice->status_state!!}</span></td>
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