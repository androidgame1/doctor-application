@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">@if($role == 'administrator') {{__('messages.administrators')}} @elseif($role == 'secretary') {{__('messages.secretaries')}} @endif</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_superadministrator){{route('superadministrator.home')}}@elseif(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">@if($role == 'administrator') {{__('messages.administrators')}} @elseif($role == 'secretary') {{__('messages.secretaries')}} @endif</li>
            </ol>
            <a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.create',$role)}}@elseif(auth()->user()->is_administrator){{route('administrator.user.create',$role)}}@else javascript:void(0) @endif"
                class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} @if($role == 'administrator') {{__('messages.administrator')}} @elseif($role == 'secretary') {{__('messages.secretary')}} @endif</a>
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
                                        <th>{{__('messages.cin')}}</th>
                                        <th>{{__('messages.fullname')}}</th>
                                        <th>{{__('messages.email')}}</th>
                                        <th>{{__('messages.address')}}</th>
                                        <th>{{__('messages.phone')}}</th>
                                        <th>{{__('messages.city')}}</th>
                                        <th>{{__('messages.status')}}</th>
                                        <th>{{__('messages.date_creation')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $value)
                                    <tr>
                                        <td class="d-none">{{$value->id}}</td>
                                        <td><a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.show',['role'=>$role,'id'=>$value->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.show',['role'=>$role,'id'=>$value->id])}}@else javascript:void(0) @endif" data-original-title="{{__('messages.show')}}">{{$value->cin}}</a>
                                        </td>
                                        <td>{{$value->fullname}}</td>
                                        <td>{{$value->email}}</td>
                                        <td>{{$value->address}}</td>
                                        <td>{{$value->phone}}</td>
                                        <td>{{$value->city}}</td>
                                        <td>{!! $value->status !!}</td>
                                        <td>{{\Carbon\Carbon::parse($value->created_at)}}</td>
                                        <td>
                                            <a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.show',['role'=>$role,'id'=>$value->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.show',['role'=>$role,'id'=>$value->id])}}@else javascript:void(0) @endif"
                                                data-toggle="tooltip" data-original-title="{{__('messages.show')}}"> <i
                                                    class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                            <a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.edit',['role'=>$role,'id'=>$value->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.edit',['role'=>$role,'id'=>$value->id])}}@else javascript:void(0) @endif"
                                             data-toggle="tooltip" data-original-title="{{__('messages.edit')}}"> <i
                                                    class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                            <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal"
                                                data-target="#div-destroy-old-item"
                                                data-url-destroy="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.destroy',['role'=>$role,'id'=>$value->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.destroy',['role'=>$role,'id'=>$value->id])}}@else javascript:void(0) @endif"
                                                data-title = "@if($role == 'administrator') {{__('messages.administrator')}} @elseif($role == 'secretary') {{__('messages.secretary')}} @endif"
                                                data-message="{{__('messages.do_you_want_to_delete_this')}} @if($role == 'administrator') {{__('messages.administrator')}} @elseif($role == 'secretary') {{__('messages.secretary')}} @endif ?"
                                                data-toggle="tooltip" data-original-title="{{__('messages.destroy')}}"> <i
                                                    class="fa fa-close text-danger icon-datatable"></i> </a>
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
@endsection
@section('javascript')

@include('javascript.datatable')
@include('javascript.helper')
@include('javascript.destroy')
@endsection
