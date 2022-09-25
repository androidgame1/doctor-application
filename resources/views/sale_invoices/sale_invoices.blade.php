@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.sale_invoices')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.sale_invoices')}}</li>
            </ol>
            <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.create')}}@else javascript:void(0) @endif" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.sale_invoice')}}</a>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
@if(auth()->user()->id_superadministrator)

@elseif(auth()->user()->is_administrator && Route::current()->getName() == 'administrator.sale_invoices')
    <div class="row">
        <div class="col-12">
            <div class="card-group">
                <div class="card">
                    <a href="{{route('administrator.sale_invoices.filter','0')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-danger"></i></h3>
                                            <p class="text-muted">{{__('messages.unpaid')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-danger">{{$count_unpaid_sale_invoices}}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Column -->
                <div class="card">
                    <a href="{{route('administrator.sale_invoices.filter','1')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-warning"></i></h3>
                                            <p class="text-muted">{{__('messages.partiel')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-warning">{{$count_partiel_sale_invoices}}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card">
                    <a href="{{route('administrator.sale_invoices.filter','2')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-success"></i></h3>
                                            <p class="text-muted">{{__('messages.paid')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-success">{{$count_paid_sale_invoices}}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Column -->
                <div class="card">
                    <a href="{{route('administrator.sale_invoices.filter','3')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-danger"></i></h3>
                                            <p class="text-muted">{{__('messages.canceled')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-danger">{{$count_canceled_sale_invoices}}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div> 
        </div>
        <div class="col-12">
            <div class="card-group">
                <!-- Column -->
                <div class="card">
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-money text-activated"></i></h3>
                                            <p class="text-muted">{{__('messages.activated')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-activated">{{$activated_payments}} MAD</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-activated" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Column -->
                <div class="card">
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-money text-danger"></i></h3>
                                            <p class="text-muted">{{__('messages.canceled')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-danger">{{$canceled_payments}} MAD</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-money text-danger"></i></h3>
                                            <p class="text-muted">{{__('messages.unpaid')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-danger">{{$unpaid_payments}} MAD</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div> 
        </div>
        <div class="col-12">
            <div class="card-group">
                <!-- Column -->
                <div class="card">
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-money text-warning"></i></h3>
                                            <p class="text-muted">{{__('messages.partiel')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-warning">{{$partiel_payments}} MAD</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Column -->
                <div class="card">
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-money text-success"></i></h3>
                                            <p class="text-muted">{{__('messages.paid')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-success">{{$paid_payments}} MAD</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
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
                                        <th>{{__('messages.series')}}</th>
                                        <th>{{__('messages.patient')}}</th>
                                        <th>{{__('messages.date')}}</th>
                                        <th>{{__('messages.reduction_amount')}}</th>
                                        <th>{{__('messages.ht_amount')}}</th>
                                        <th>{{__('messages.tva_amount')}}</th>
                                        <th>{{__('messages.ttc_amount')}}</th>
                                        <th>{{__('messages.status')}}</th>
                                        <th>{{__('messages.date_creation')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale_invoices as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td><a href="javascript:void(0)" class="btn-show-sale-invoice" data-toggle="modal" data-target="#div-show-old-patient" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.show',$value->id)}}@else javascript:void(0) @endif"  title="{{__('messages.show')}}">{{$value->series}}</a></td>
                                            <td>{{$value->patient->fullname}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                                            <td>{{$value->reduction_total_amount}} <b>MAD</b></td>
                                            <td>{{$value->ht_total_amount}} <b>MAD</b></td>
                                            <td>{{$value->tva_total_amount}} <b>MAD</b></td>
                                            <td>{{$value->ttc_total_amount}} <b>MAD</b></td>
                                            <td>{!!$value->status_state!!}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.show',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.edit',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.duplicate',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.duplicate')}}"> <i class="fa fa-files-o text-warning m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.pdf',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.pdf')}}" target="_blank"> <i class="fa fa-file text-primary m-r-10 icon-datatable"></i> </a>
                                                @if($value->status == '0')
                                                    <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice_payment.create',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.create')}}"> <i class="fa fa-money text-purple m-r-10 icon-datatable"></i> </a>
                                                    <a href="javascript:void(0)" class="btn-cancel-item" data-toggle="modal" data-target="#div-cancel-old-item" data-url-cancel="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.cancel',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.cancel_sale_invoice')}}" data-message="{{__('messages.do_you_want_to_cancel_this')}} {{__('messages.sale_invoice')}} ?" title="{{__('messages.cancel')}}"> <i class="fa fa-ban text-danger icon-datatable"></i> </a>
                                                @elseif($value->status == '1')
                                                    <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice_payment.create',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.create')}}"> <i class="fa fa-money text-brown m-r-10 icon-datatable"></i> </a>
                                                @elseif($value->status == '2')
                                                    <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice_payments',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.sale_invoice_payments')}}"> <i class="fa fa-money text-gray m-r-10 icon-datatable"></i> </a>
                                                @endif
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
@include('javascript.cancel')
@endsection
