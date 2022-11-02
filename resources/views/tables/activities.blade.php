<div class="table-responsive">
    <table class="table table-bordered table-striped table-datatable">
        <thead>
            <tr>
                <th class="d-none">#</th>
                <th>{{__('messages.series')}}</th>
                <th>{{__('messages.patient')}}</th>
                <th>{{__('messages.date')}}</th>
                <th>{{__('messages.ttc_amount')}}</th>
                <th>{{__('messages.given_amount')}}</th>
                <th>{{__('messages.remaining_amount')}}</th>
                <th>{{__('messages.status')}}</th>
                <th>{{__('messages.date_creation')}}</th>
                <th>{{__('messages.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $value)
                <tr>
                    <td class="d-none">{{$value->id}}</td>
                    <td><a href="javascript:void(0)" class="btn-show-activity" data-toggle="modal" data-target="#div-show-old-activity" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.activity.show',$value->id)}}@else javascript:void(0) @endif"  title="{{__('messages.show')}}">{{$value->series}}</a></td>
                    <td>{{$value->patient->fullname}}</td>
                    <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                    <td>{{$value->ttc_total_amount}} <b>MAD</b></td>
                    <td><span class="text-success font-bold">{{$value->total_given_amount}} <b>MAD</b></span></td>
                    <td><span class="text-danger font-bold">{{$value->total_remaining_amount}} <b>MAD</b></span></td>
                    <td>{!!$value->status_state!!}</td>
                    <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                    <td>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.activity.show',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.activity.edit',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.activity.duplicate',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.duplicate')}}"> <i class="fa fa-files-o text-warning m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.activity.pdf',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.pdf')}}" target="_blank"> <i class="fa fa-file text-primary m-r-10 icon-datatable"></i> </a>
                        @if($value->status == '0')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.activity_payment.create',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.create')}}"> <i class="fa fa-money text-purple m-r-10 icon-datatable"></i> </a>
                            <a href="javascript:void(0)" class="btn-cancel-item" data-toggle="modal" data-target="#div-cancel-old-item" data-url-cancel="@if(auth()->user()->is_administrator){{route('administrator.activity.cancel',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.cancel_activity')}}" data-message="{{__('messages.do_you_want_to_cancel_this')}} {{__('messages.activity')}} ?" title="{{__('messages.cancel')}}"> <i class="fa fa-ban text-danger icon-datatable"></i> </a>
                        @elseif($value->status == '1')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.activity_payment.create',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.create')}}"> <i class="fa fa-money text-brown m-r-10 icon-datatable"></i> </a>
                            <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.activity.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_activity')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.activity')}} ?" title="{{__('messages.delete')}}"> <i class="fa fa-trash text-danger icon-datatable"></i> </a>
                        @elseif($value->status == '2')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.activity_payments',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.activity_payments')}}"> <i class="fa fa-money text-gray m-r-10 icon-datatable"></i> </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td><b>{{__('messages.total_amount')}}</b></td>
                <td colspan="8"><span class="font-bold">{{$total_amount}} <b>MAD</b></span></td>
            </tr>
            <tr>
                <td><b>{{__('messages.total_given_amount')}}</b></td>
                <td colspan="8"><span class="text-success font-bold">{{$total_given_amount}} <b>MAD</b></span></td>
            </tr>
            <tr>
                <td><b>{{__('messages.total_remaining_amount')}}</b></td>
                <td colspan="8"><span class="text-danger font-bold">{{$total_remaining_amount}} <b>MAD</b></span></td>
            </tr>
        </tfoot>
    </table>
</div>