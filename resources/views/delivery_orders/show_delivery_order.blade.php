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
                        href="@if(auth()->user()->is_administrator){{route('administrator.delivery_orders')}}@else javascript:void(0) @endif">{{__('messages.delivery_orders')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.delivery_order')}}</li>
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
                <table id="table-show-old-supplier" class="table browser no-border">
                    <tbody>
                        <tr class="tr-show">
                            <td><b>{{__('messages.series')}}</b></td>
                            <td class="text-right"><a href = "@if(auth()->user()->is_administrator) {{route('administrator.delivery_order.show',$delivery_order->id)}} @else javascript:void(0) @endif" class="text-primary" name="cin">{{$delivery_order->series}}</a></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.purchase_order')}}</b></td>
                            <td class="text-right"><a href = "javascript:void(0)" class="text-primary" name="cin">{{$delivery_order->purchase_order->series ?? ''}}</a></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.supplier')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$delivery_order->supplier->fullname}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_reduction')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$delivery_order->reduction_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_mount_of_ht')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$delivery_order->ht_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_tva')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$delivery_order->tva_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.total_amount_of_ttc')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$delivery_order->ttc_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.paid_amount')}}</b></td>
                            <td class="text-right"><span class="text-success font-bold" name="city">{{$delivery_order->paid_amount}} <b>MAD</b></span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.remaining_amount')}}</b></td>
                            <td class="text-right"><span class="text-danger font-bold" name="city">{{$delivery_order->remaining_amount}} <b>MAD</b></span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.date')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{\Carbon\Carbon::parse($delivery_order->date)->format('d/m/Y')}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.remarque')}}</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$delivery_order->remark}}</span></td>
                        </tr>
                        <tr class="tr-show">
                            <td><b>{{__('messages.payment_status')}}</b></td>
                            <td class="text-right">{!!$delivery_order->payment_status_state!!}</td>
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
