@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Purchase invoice</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoices')}}@else javascript:void(0) @endif">Home</a>
                </li>
                <li class="breadcrumb-item active">Purchase invoice</li>
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
                            <td><b>Series</b></td>
                            <td class="text-right"><a href = "@if(auth()->user()->is_administrator) {{route('administrator.purchase_invoice.show',$purchase_invoice->id)}} @else javascript:void(0) @endif" class="text-primary" name="cin">{{$purchase_invoice->series}}</a></td>
                        </tr>
                        <tr>
                            <td><b>Supplier</b></td>
                            <td class="text-right"><span class="text-gray" name="fullname">{{$purchase_invoice->supplier->fullname}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Total amount of reduction</b></td>
                            <td class="text-right"><span class="text-gray" name="email">{{$purchase_invoice->reduction_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>Total mount of HT</b></td>
                            <td class="text-right"><span class="text-gray" name="address">{{$purchase_invoice->ht_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>Total amount of TVA</b></td>
                            <td class="text-right"><span class="text-gray" name="phone">{{$purchase_invoice->tva_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>Total amount of TTC</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$purchase_invoice->ttc_total_amount}}</span> <b>MAD</b></td>
                        </tr>
                        <tr>
                            <td><b>Date</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{\Carbon\Carbon::parse($purchase_invoice->date)->format('Y-m-d')}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Remarque</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{{$purchase_invoice->remark}}</span></td>
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td class="text-right"><span class="text-gray" name="city">{!!$purchase_invoice->status_state!!}</span></td>
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
