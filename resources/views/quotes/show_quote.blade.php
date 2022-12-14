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
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.quotes')}}@else javascript:void(0) @endif">{{__('messages.quotes')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.quote')}}</li>
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
                            <td class="text-right"><a href = "@if(auth()->user()->is_administrator) {{route('administrator.quote.show',$quote->id)}} @else javascript:void(0) @endif" class="text-primary" name="cin">{{$quote->series}}</a></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.patient')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$quote->patient->fullname}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_reduction')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$quote->reduction_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_mount_of_ht')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$quote->ht_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_tva')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$quote->tva_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_ttc')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$quote->ttc_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.date')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{\Carbon\Carbon::parse($quote->date)->format('d/m/Y')}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.remarque')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$quote->remark}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.payment_status')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{!!$quote->payment_status_state!!}</span></td>
                        </tr>
                        {{--<!-- <tr class="tr-show">
                            <td colspan="2" class="text-center" name="edit-status" >
                                <a href="@if(auth()->user()->is_administrator){{route('administrator.quote.convert_qt_to_act',$quote->id)}} @else javascript:void(0) @endif" class="btn btn-success"><i class="fa fa-file"></i> {{__('messages.convert_to_activity')}}</a>
                                <a href="@if(auth()->user()->is_administrator){{route('administrator.quote.convert_qt_to_sl_inv',$quote->id)}} @else javascript:void(0) @endif" class="btn btn-warning"><i class="fa fa-file"></i> {{__('messages.convert_to_sale_invoice')}}</a>
                            </td>
                        </tr> -->--}}
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
