@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-6 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.charges')}}</li>
            </ol>
    </div>
    <div class="col-md-6 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <a href="javascript:void(0)" class="btn btn-info d-none d-lg-block m-l-15"  data-toggle="modal" data-target="#div-create-new-charge"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.charge')}}</a>
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

@elseif(auth()->user()->is_administrator && (in_array(Route::current()->getName(),['administrator.charges','administrator.charges.dates.filter','administrator.charges.secretary','administrator.charges.secretary.dates.filter']))  )
    @if(in_array(Route::current()->getName(),['administrator.charges','administrator.charges.dates.filter']))
        @include('includes.search_between_two_dates',['route'=>route('administrator.charges.dates.filter')])
    @else
        @include('includes.search_between_two_dates',['route'=>route('administrator.charges.secretary.dates.filter',$secretary->id)])
    @endif
    <div class="row">
    <div class="col-12">
            <div class="card-group">
                <div class="card">
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-danger"></i></h3>
                                            <p class="text-muted">{{__('messages.unpaid')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-danger">{{$count_unpaid_charges}}</h2>
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
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-warning"></i></h3>
                                            <p class="text-muted">{{__('messages.partiel')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-warning">{{$count_partiel_charges}}</h2>
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
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-success"></i></h3>
                                            <p class="text-muted">{{__('messages.paid')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-success">{{$count_paid_charges}}</h2>
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
                <!-- <div class="card">
                    <a href="javascript:void(0)">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-danger"></i></h3>
                                            <p class="text-muted">{{__('messages.canceled')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-danger">{{$count_canceled_charges}}</h2>
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
                </div> -->
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
                <!-- <div class="card">
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
                </div> -->
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
                    @if($secretary)
                        <div class="col-md-12">
                            <h3>{{__('messages.secretary')}} : <span class="text-primary">{{$secretary->fullname}}</span></a></span></h3>
                        </div>
                    @endif
                    <div class="col-md-12">
                        @include('tables.charges',$charges)
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('modals.charges.create_charge')
@include('modals.charges.edit_charge')
@include('modals.charges.show_charge')
@include('modals.destroy')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.charges.edit_charge')
@include('javascript.charges.show_charge')
@include('javascript.destroy')
@endsection
