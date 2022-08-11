@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Status</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">Home</a>
                </li>
                <li class="breadcrumb-item active">Status</li>
            </ol>
            <a href="javascript:void(0)" class="btn btn-info d-none d-lg-block m-l-15"  data-toggle="modal" data-target="#div-create-new-status"><i class="fa fa-plus-circle"></i> New status</a>
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
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Date creation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($status as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td><span class="span-bar" style="background:{{$value->color}}"></span></td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)}}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.status.show',$value->id)}}@else javascript:void(0) @endif" class="btn-show-status" data-toggle="modal" data-target="#div-show-old-status" data-toggle="tooltip" data-original-title="show"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" data-url-edit="@if(auth()->user()->is_administrator){{route('administrator.status.edit',$value->id)}}@else javascript:void(0) @endif" class="btn-edit-status" data-url-update="@if(auth()->user()->is_administrator){{route('administrator.status.update',$value->id)}}@else javascript:void(0) @endif" data-toggle="modal" data-target="#div-edit-old-status" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                @if(count($value->appointments)<=0)
                                                    <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.status.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="status" data-message="You want to delete this status." data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
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
@include('modals.status.create_status')
@include('modals.status.edit_status')
@include('modals.status.show_status')
@include('modals.destroy')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.status.edit_status')
@include('javascript.status.show_status')
@include('javascript.destroy')
@endsection
