@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Purchase invoices</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoices')}}@else javascript:void(0) @endif">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Purchase invoices</li>
            </ol>
            <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.create')}}@else javascript:void(0) @endif" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> New purchase invoice</a>
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
                <div class="row">
                    <div class="col-md-12">
                        @include('messages.messages')
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-datatable">
                                <thead>
                                    <tr>
                                        <th class="d-none">#</th>
                                        <th>Series</th>
                                        <th>Supplier</th>
                                        <th>Date</th>
                                        <th>Reduction amount</th>
                                        <th>HT amount</th>
                                        <th>TVA amount</th>
                                        <th>TTC amount</th>
                                        <th>Status</th>
                                        <th>Date creation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase_invoices as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td><a href="javascript:void(0)" class="btn-show-purchase-invoice" data-toggle="modal" data-target="#div-show-old-patient" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.show',$value->id)}}@else javascript:void(0) @endif">{{$value->series}}</a></td>
                                            <td>{{$value->supplier->fullname}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->date)->format('Y-m-d')}}</td>
                                            <td>{{$value->reduction_total_amount}} <b>MAD</b></td>
                                            <td>{{$value->ht_total_amount}} <b>MAD</b></td>
                                            <td>{{$value->tva_total_amount}} <b>MAD</b></td>
                                            <td>{{$value->ttc_total_amount}} <b>MAD</b></td>
                                            <td>{!!$value->status_state!!}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)}}</td>
                                            <td>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.show',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" data-original-title="show"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.edit',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.duplicate',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" data-original-title="Duplicate"> <i class="fa fa-files-o text-warning m-r-10 icon-datatable"></i> </a>
                                                @if($value->status == '0')
                                                    <a href="javascript:void(0)" class="btn-cancel-item" data-toggle="modal" data-target="#div-cancel-old-item" data-url-cancel="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.cancel',$value->id)}}@else javascript:void(0) @endif" data-title="Purchase invoice" data-message="You want to cancel this purchase invoice." data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-ban text-danger icon-datatable"></i> </a>
                                                @endif
                                                {{--<!-- <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="Purchase invoice" data-message="You want to delete this purchase invoice." data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger icon-datatable"></i> </a> -->--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.destroy')
@include('modals.cancel')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.destroy')

@endsection
