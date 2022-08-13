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
                                            <td>{{\Carbon\Carbon::parse($value->start_date)->format('Y-m-d h:i:s')}}</td>
                                            <td>{{\Carbon\Carbon::parse($value->end_date)->format('Y-m-d h:i:s')}}</td>
                                            <td>{!!$value->status_state!!}</td>
                                            <td>{{\Carbon\Carbon::parse($value->created_at)->format('Y-m-d h:i:s')}}</td>
                                            <td>
                                                <a href="javascript:void(0)" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.appointment.show',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.appointment.show',$value->id)}}@else javascript:void(0) @endif" class="btn-show-appointment" data-toggle="modal" data-target="#div-show-old-appointment" data-toggle="tooltip" data-original-title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                                                <a href="javascript:void(0)" data-url-edit="@if(auth()->user()->is_administrator){{route('administrator.appointment.edit',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.appointment.edit',$value->id)}}@else javascript:void(0) @endif" class="btn-edit-appointment" data-url-update="@if(auth()->user()->is_administrator){{route('administrator.appointment.update',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.appointment.update',$value->id)}}@else javascript:void(0) @endif" data-toggle="modal" data-target="#div-edit-old-appointment" data-toggle="tooltip" data-original-title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                                                @if($value->status == '0')
                                                    <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.appointment.destroy',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.appointment.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.appointment')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.appointment')}} ?" data-toggle="tooltip" data-original-title="{{__('messages.destroy')}}"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
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
