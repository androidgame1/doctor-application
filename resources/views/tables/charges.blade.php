<div class="table-responsive">
    <table class="table table-bordered table-striped table-datatable">
        <thead>
            <tr>
                <th class="d-none">#</th>
                <th>{{__('messages.name')}}</th>
                <th>{{__('messages.secretary')}}</th>
                <th>{{__('messages.amount')}}</th>
                <th>{{__('messages.given_amount')}}</th>
                <th>{{__('messages.remaining_amount')}}</th>
                <th>{{__('messages.status')}}</th>
                <th>{{__('messages.date_creation')}}</th>
                <th>{{__('messages.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($charges as $value)
                <tr>
                    <td class="d-none">{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->secretary ? $value->secretary->fullname : ''}}</td>
                    <td>{{$value->amount}} <b>MAD</b></td>
                    <td><span class="text-success font-bold">{{$value->total_given_amount}} <b>MAD</b></span></td>
                    <td><span class="text-danger font-bold">{{$value->total_remaining_amount}} <b>MAD</b></span></td>
                    <td>{!!$value->status_state!!}</td>
                    <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                    <td>
                        <a href="javascript:void(0)" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.charge.show',$value->id)}}@else javascript:void(0) @endif" class="btn-show-charge" data-toggle="modal" data-target="#div-show-old-charge" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                        <a href="javascript:void(0)" data-url-edit="@if(auth()->user()->is_administrator){{route('administrator.charge.edit',$value->id)}}@else javascript:void(0) @endif" class="btn-edit-charge" data-url-update="@if(auth()->user()->is_administrator){{route('administrator.charge.update',$value->id)}}@else javascript:void(0) @endif" data-toggle="modal" data-target="#div-edit-old-charge" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                        @if($value->status == '0')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.charge_payment.create',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.create')}}"> <i class="fa fa-money text-purple m-r-10 icon-datatable"></i> </a>
                            <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.charge.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_charge')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.charge')}} ?" title="{{__('messages.delete')}}"> <i class="fa fa-close text-danger icon-datatable"></i> </a>
                        @elseif($value->status == '1')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.charge_payment.create',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.create')}}"> <i class="fa fa-money text-brown m-r-10 icon-datatable"></i> </a>
                        @elseif($value->status == '2')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.charge_payments',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.charge_payments')}}"> <i class="fa fa-money text-gray m-r-10 icon-datatable"></i> </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td><b>{{__('messages.total_amount')}}</b></td>
                <td colspan="6"><span class="font-bold">{{$total_amount}} <b>MAD</b></span></td>
            </tr>
            <tr>
                <td><b>{{__('messages.total_given_amount')}}</b></td>
                <td colspan="6"><span class="text-success font-bold">{{$total_given_amount}} <b>MAD</b></span></td>
            </tr>
            <tr>
                <td><b>{{__('messages.total_remaining_amount')}}</b></td>
                <td colspan="6"><span class="text-danger font-bold">{{$total_remaining_amount}} <b>MAD</b></span></td>
            </tr>
        </tfoot>
    </table>
</div>