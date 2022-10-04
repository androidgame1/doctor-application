@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.charges')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.charges')}}</li>
            </ol>
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
        @include('includes.search_between_two_dates',['route'=>'administrator.charges.dates.filter'])
    @else
        @include('includes.search_between_two_dates',['route'=>'administrator.charges.secretary.dates.filter','param1'=>$secretary->id])
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card-group">
                <div class="card">
                    <a href="{{route('administrator.charges')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-money text-gray"></i></h3>
                                            <p class="text-muted">{{__('messages.total_charges')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-gray">{{count($charges)}}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-gray" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                            <p class="text-muted">{{__('messages.payments')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-success">{{$charge_payments}} MAD</h2>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-datatable">
                                <thead>
                                    <tr>
                                        <th class="d-none">#</th>
                                        <th>{{__('messages.name')}}</th>
                                        <th>{{__('messages.amount')}}</th>
                                        <th>{{__('messages.date_creation')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($charges as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->amount}} <b>MAD</b></td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.charge.show',$value->id)}}@else javascript:void(0) @endif" class="btn-show-charge" data-toggle="modal" data-target="#div-show-old-charge" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" data-url-edit="@if(auth()->user()->is_administrator){{route('administrator.charge.edit',$value->id)}}@else javascript:void(0) @endif" class="btn-edit-charge" data-url-update="@if(auth()->user()->is_administrator){{route('administrator.charge.update',$value->id)}}@else javascript:void(0) @endif" data-toggle="modal" data-target="#div-edit-old-charge" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.charge.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_charge')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.charge')}} ?" title="{{__('messages.delete')}}"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
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
