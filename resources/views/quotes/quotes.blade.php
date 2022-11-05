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
                <li class="breadcrumb-item active">{{__('messages.quotes')}}</li>
            </ol>
    </div>
    <div class="col-md-6 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <a href="@if(auth()->user()->is_administrator){{route('administrator.quote.create')}}@else javascript:void(0) @endif" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.quote')}}</a>
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

@elseif(auth()->user()->is_administrator && (in_array(Route::current()->getName(),['administrator.quotes','administrator.quotes.dates.filter'])))
    @include('includes.search_between_two_dates',['route'=>route('administrator.quotes.dates.filter')])      
    <div class="row">
        <div class="col-12">
            <div class="card-group">
                <div class="card">
                    <a href="{{route('administrator.quotes.filter','0')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-success"></i></h3>
                                            <p class="text-muted">{{__('messages.activated')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-success">{{$count_activated_quotes}}</h2>
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
                    <a href="{{route('administrator.quotes.filter','1')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-file-text text-danger"></i></h3>
                                            <p class="text-muted">{{__('messages.canceled')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-danger">{{$count_canceled_quotes}}</h2>
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
                        @include('tables.quotes',$quotes)
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
