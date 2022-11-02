<div class="table-responsive">
    <table class="table table-bordered table-striped table-datatable">
        <thead>
            <tr>
                <th class="d-none">#</th>
                <th>{{__('messages.series')}}</th>
                <th>{{__('messages.supplier')}}</th>
                <th>{{__('messages.date')}}</th>
                <th>{{__('messages.status')}}</th>
                <th>{{__('messages.date_creation')}}</th>
                <th>{{__('messages.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($delivery_orders as $value)
                <tr>
                <td class="d-none">{{$value->id}}</td>
                    <td><a href="javascript:void(0)" class="btn-show-delivery-order" data-toggle="modal" data-target="#div-show-old-patient" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.delivery_order.show',$value->id)}}@else javascript:void(0) @endif"  title="{{__('messages.show')}}">{{$value->series}}</a></td>
                    <td>{{$value->supplier->fullname}}</td>
                    <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                    <th>{!!$value->status_state!!}</th>
                    <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn-show-delivery-order" data-toggle="modal" data-target="#div-show-old-delivery-order" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.delivery_order.show',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.delivery_order.edit',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                        <a href="javascript:void(0)" class="btn-destroy-item" data-toggle="modal" data-target="#div-destroy-old-item" data-url-destroy="@if(auth()->user()->is_administrator){{route('administrator.delivery_order.destroy',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.delete_delivery_order')}}" data-message="{{__('messages.do_you_want_to_delete_this')}} {{__('messages.delivery_order')}} ?" title="{{__('messages.delete')}}"> <i class="fa fa-trash text-danger icon-datatable"></i> </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>