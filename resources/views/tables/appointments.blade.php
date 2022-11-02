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