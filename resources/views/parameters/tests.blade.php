@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tests</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@else javascript:void(0) @endif">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Tests</li>
            </ol>
            <a href="javascript:void(0)" class="btn btn-info d-none d-lg-block m-l-15"  data-toggle="modal" data-target="#div-create-new-test"><i class="fa fa-plus-circle"></i> New test</a>
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
                                        <th>Date creation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tests as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)}}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.test.show',$value->id)}}@else javascript:void(0) @endif" class="btn-show-test" data-toggle="modal" data-target="#div-show-old-test" data-toggle="tooltip" data-original-title="show"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" data-url-edit="@if(auth()->user()->is_administrator){{route('administrator.test.edit',$value->id)}}@else javascript:void(0) @endif" class="btn-edit-test" data-url-update="@if(auth()->user()->is_administrator){{route('administrator.test.update',$value->id)}}@else javascript:void(0) @endif" data-toggle="modal" data-target="#div-edit-old-test" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.test.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="test" data-message="You want to delete this test." data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
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
@include('modals.tests.create_test')
@include('modals.tests.edit_test')
@include('modals.tests.show_test')
@include('modals.destroy')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.tests.edit_test')
@include('javascript.tests.show_test')
@include('javascript.destroy')
@endsection
