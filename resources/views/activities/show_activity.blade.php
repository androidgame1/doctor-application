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
            <li class="breadcrumb-item active">{{__('messages.activity')}}</li>
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
                <table id="table-show-old-patient" class="table browser no-border">
                    <tbody>
                        <tr class="tr-show">
                            <td><b>{{__('messages.series')}}</b></td>
                            <td class="text-right"><a href = "@if(auth()->user()->is_administrator) {{route('administrator.activity.show',$activity->id)}} @else javascript:void(0) @endif" class="text-primary" name="cin">{{$activity->series}}</a></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.patient')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$activity->patient->fullname}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_reduction')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$activity->reduction_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_mount_of_ht')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$activity->ht_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_tva')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$activity->tva_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_ttc')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$activity->ttc_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.date')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{\Carbon\Carbon::parse($activity->date)->format('d/m/Y')}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.remarque')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$activity->remark}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.status')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{!!$activity->status_state!!}</span></td>
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
