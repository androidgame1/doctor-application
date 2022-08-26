@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.acts')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.acts')}}</li>
            </ol>
            <a href="javascript:void(0)" class="btn btn-info d-none d-lg-block m-l-15"  data-toggle="modal" data-target="#div-create-new-act"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.act')}}</a>
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
                                        <th>{{__('messages.name')}}</th>
                                        <th>{{__('messages.amount')}}</th>
                                        <th>{{__('messages.date_creation')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($acts as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->amount}} <b>MAD</b></td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.act.show',$value->id)}}@else javascript:void(0) @endif" class="btn-show-act" data-toggle="modal" data-target="#div-show-old-act" data-toggle="tooltip" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" data-url-edit="@if(auth()->user()->is_administrator){{route('administrator.act.edit',$value->id)}}@else javascript:void(0) @endif" class="btn-edit-act" data-url-update="@if(auth()->user()->is_administrator){{route('administrator.act.update',$value->id)}}@else javascript:void(0) @endif" data-toggle="modal" data-target="#div-edit-old-act" data-toggle="tooltip" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.act.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.act')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.act')}} ?" data-toggle="tooltip" title="{{__('messages.desctroy')}}"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
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
@include('modals.acts.create_act')
@include('modals.acts.edit_act')
@include('modals.acts.show_act')
@include('modals.destroy')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.acts.edit_act')
@include('javascript.acts.show_act')
@include('javascript.destroy')
@endsection
