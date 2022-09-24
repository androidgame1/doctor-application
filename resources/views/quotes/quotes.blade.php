@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.quotes')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.quotes')}}</li>
            </ol>
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

@elseif(auth()->user()->is_administrator && Route::current()->getName() == 'administrator.quotes')
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
                                        <th>{{__('messages.status')}}</th>
                                        <th>{{__('messages.date_creation')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotes as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td><a href="javascript:void(0)" class="btn-show-quote" data-toggle="modal" data-target="#div-show-old-quote" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.quote.show',$value->id)}}@else javascript:void(0) @endif"  title="{{__('messages.show')}}">{{$value->series}}</a></td>
                                            <td>{{$value->patient->fullname}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                                            <td>{{$value->reduction_total_amount}} <b>MAD</b></td>
                                            <td>{{$value->ht_total_amount}} <b>MAD</b></td>
                                            <td>{!!$value->status_state!!}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.quote.show',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.quote.edit',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.quote.duplicate',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" title="{{__('messages.duplicate')}}"> <i class="fa fa-files-o text-warning m-r-10 icon-datatable"></i> </a>
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.quote.pdf',$value->id)}}@else javascript:void(0) @endif" data-toggle="tooltip" title="{{__('messages.pdf')}}" target="_blank"> <i class="fa fa-file text-primary m-r-10 icon-datatable"></i> </a>
                                                @if($value->status == '0')
                                                    <a href="javascript:void(0)" class="btn-cancel-item" data-toggle="modal" data-target="#div-cancel-old-item" data-url-cancel="@if(auth()->user()->is_administrator){{route('administrator.quote.cancel',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.cancel_quote')}}" data-message="{{__('messages.do_you_want_to_cancel_this')}} {{__('messages.quote')}} ?" data-toggle="tooltip" title="{{__('messages.cancel')}}"> <i class="fa fa-ban text-danger icon-datatable"></i> </a>
                                                @elseif($value->status == '1')
                                                    <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.quote.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_quote')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.quote')}} ?" data-toggle="tooltip" title="{{__('messages.delete')}}"> <i class="fa fa-trash text-danger icon-datatable"></i> </a>
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
