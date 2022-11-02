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
                <th>{{__('messages.date_creation')}}</th>
                <th>{{__('messages.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $value)
                <tr>
                    <td class="d-none">{{$value->id}}</td>
                    <td><a href="javascript:void(0)" class="btn-show-patient" data-toggle="modal" data-target="#div-show-old-patient" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.patient.show',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.show',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.show')}}">{{$value->cin}}</a></td>
                    <td>{{$value->fullname}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->address}}</td>
                    <td>{{$value->phone}}</td>
                    <td>{{$value->city}}</td>
                    <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                    <td>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.patient.show',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.show',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.patient.edit',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.edit',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                        <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.patient.destroy',$value->id)}}@elseif(auth()->user()->is_secretary){{route('secretary.patient.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_patient')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.patient')}}." title="{{__('messages.delete')}}"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>