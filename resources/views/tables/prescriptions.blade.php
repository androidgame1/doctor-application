<div class="table-responsive">
    <table class="table table-bordered table-striped table-datatable">
        <thead>
            <tr>
                <th class="d-none">#</th>
                <th>{{__('messages.patient')}}</th>
                <th>{{__('messages.date')}}</th>
                <th>{{__('messages.date_creation')}}</th>
                <th>{{__('messages.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prescriptions as $value)
                <tr>
                    <td class="d-none">{{$value->id}}</td>
                    <td>{{$value->patient->fullname}}</td>
                    <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                    <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                    <td>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.prescription.edit',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.prescription.pdf',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.pdf')}}" target="_blank"> <i class="fa fa-file text-primary m-r-10 icon-datatable"></i> </a>
                        <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.prescription.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_prescription')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.prescription')}} ?" title="{{__('messages.delete')}}"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>