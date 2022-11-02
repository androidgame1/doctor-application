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
@if(auth()->user()->is_administrator && Route::current()->getName() == 'administrator.users' && $role="secretary")
    <div class="row">
        <div class="col-12">
            <div class="card-group">
                <div class="card">
                    <a href="{{route('administrator.users.filter',['role'=>$role,'validation'=>0])}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-users text-warning"></i></h3>
                                            <p class="text-muted">{{__('messages.no_validated')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-warning">{{$count_no_validated_users}}</h2>
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
                    <a href="{{route('administrator.users.filter',['role'=>$role,'validation'=>1])}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-users text-danger"></i></h3>
                                            <p class="text-muted">{{__('messages.no_activated')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-danger">{{$count_no_activated_users}}</h2>
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
                    <a href="{{route('administrator.users.filter',['role'=>$role,'validation'=>2])}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-users text-success"></i></h3>
                                            <p class="text-muted">{{__('messages.activated')}}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <h2 class="counter text-success">{{$count_activated_users}}</h2>
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
                                        <td><a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.show',['role'=>$role,'id'=>$value->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.show',['role'=>$role,'id'=>$value->id])}}@else javascript:void(0) @endif" title="{{__('messages.show')}}">{{$value->cin}}</a>
                                        </td>
                                        <td>{{$value->fullname}}</td>
                                        <td>{{$value->email}}</td>
                                        <td>{{$value->address}}</td>
                                        <td>{{$value->phone}}</td>
                                        <td>{{$value->city}}</td>
                                        <td>{!! $value->status !!}</td>
                                        <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                        <td>
                                            <a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.show',['role'=>$role,'id'=>$value->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.show',['role'=>$role,'id'=>$value->id])}}@else javascript:void(0) @endif"
                                             title="{{__('messages.show')}}"> <i
                                                    class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                            <a href="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.edit',['role'=>$role,'id'=>$value->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.edit',['role'=>$role,'id'=>$value->id])}}@else javascript:void(0) @endif"
                                             title="{{__('messages.edit')}}"> <i
                                                    class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                            @if($role == 'secretary')
                                                <a href="@if(auth()->user()->is_administrator){{route('administrator.charges.secretary',['secretary_id'=>$value->id])}}@else javascript:void(0) @endif"
                                                title="{{__('messages.charges')}}"> <i
                                                        class="fa fa-money text-gray m-r-10 icon-datatable"></i> </a>
                                            @endif 
                                            @if($role == 'secretary' && count($value->patientsSecretary)<=0 &&count($value->appointmentsSecretary)<=0 &&count($value->chargesSecretary)<=0)
                                                <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal"
                                                    data-target="#div-destroy-old-item"
                                                    data-url-destroy="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.destroy',['role'=>$role,'id'=>$value->id])}}@elseif(auth()->user()->is_administrator){{route('administrator.user.destroy',['role'=>$role,'id'=>$value->id])}}@else javascript:void(0) @endif"
                                                    data-title = "@if($role == 'administrator') {{__('messages.delete_administrator')}} @elseif($role == 'secretary') {{__('messages.delete_secretary')}} @endif"
                                                    data-message="{{__('messages.do_you_want_to_delete_this')}} @if($role == 'administrator') {{__('messages.administrator')}} @elseif($role == 'secretary') {{__('messages.secretary')}} @endif ?"
                                                title="{{__('messages.delete')}}"> <i
                                                        class="fa fa-close text-danger icon-datatable"></i> </a>
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
@endsection
@section('javascript')

@include('javascript.datatable')
@include('javascript.helper')
@include('javascript.destroy')
@endsection
