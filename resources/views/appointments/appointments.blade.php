@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">{{__('messages.appointments')}}</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a
                        href="@if(auth()->user()->is_administrator){{route('administrator.home')}}@elseif(auth()->user()->is_secretary){{route('secretary.home')}}@else javascript:void(0) @endif">{{__('messages.dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('messages.appointments')}}</li>
            </ol>
            <a href="javascript:void(0)" class="btn btn-info d-none d-lg-block m-l-15"  data-toggle="modal" data-target="#div-create-new-appointment"><i class="fa fa-plus-circle"></i> {{__('messages.new')}} {{__('messages.appointment')}}</a>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
@if(auth()->user()->is_administrator)
@include('includes.search_between_two_dates',['route'=>'administrator.appointments.dates.filter','param1'=>'appointments']) 
<div class="row">
        <div class="col-12">
            <div class="card-group">
                @foreach($counts_appintment_status as $count_appintment_status)
                    <div class="card">
                        <a href="javascript:void(0)">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <h3><i class="fa fa-calendar-o" style="color:{{$count_appintment_status->color}}"></i></h3>
                                                <p class="text-muted">{{$count_appintment_status->name}}</p>
                                            </div>
                                            <div class="ml-auto">
                                                <h2 class="counter" style="color:{{$count_appintment_status->color}}">{{$count_appintment_status->count_appointments}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 100%; height: 6px;background:{{$count_appintment_status->color}}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
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
                                        <th>{{__('messages.patient')}}</th>
                                        <th>{{__('messages.start_date')}}</th>
                                        <th>{{__('messages.end_date')}}</th>
                                        <th>{{__('messages.status')}}</th>
                                        <th>{{__('messages.date_creation')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $value)
                                        <tr>
                                            <td class="d-none">{{$value->id}}</td>
                                            <td>{{$value->patient->fullname}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->start_date)->format('d/m/Y H:i:s')}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->end_date)->format('d/m/Y H:i:s')}}</td>
                                            <td>{!!$value->status_state!!}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.appointment.show',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.appointment.show',$value->id)}}@else javascript:void(0) @endif" class="btn-show-appointment" data-toggle="modal" data-target="#div-show-old-appointment" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" data-url-edit="@if(auth()->user()->is_administrator){{route('administrator.appointment.edit',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.appointment.edit',$value->id)}}@else javascript:void(0) @endif" class="btn-edit-appointment" data-url-update="@if(auth()->user()->is_administrator){{route('administrator.appointment.update',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.appointment.update',$value->id)}}@else javascript:void(0) @endif" data-toggle="modal" data-target="#div-edit-old-appointment" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                @if($value->status == '0')
                                                    <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.appointment.destroy',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.appointment.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_appointment')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.appointment')}} ?" title="{{__('messages.delete')}}"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
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
@include('modals.appointments.create_appointment')
@include('modals.appointments.edit_appointment')
@include('modals.appointments.show_appointment')
@include('modals.destroy')
@endsection
@section('javascript')
@include('javascript.helper')
@include('javascript.datatable')
@include('javascript.appointments.edit_appointment')
@include('javascript.appointments.show_appointment')
@include('javascript.destroy')
@endsection
