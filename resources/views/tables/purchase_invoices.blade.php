<div class="table-responsive">
    <table class="table table-bordered table-striped table-datatable">
        <thead>
            <tr>
                <th class="d-none">#</th>
                <th>{{__('messages.series')}}</th>
                <th>{{__('messages.supplier')}}</th>
                <th>{{__('messages.date')}}</th>
                <th>{{__('messages.reduction_amount')}}</th>
                <th>{{__('messages.ht_amount')}}</th>
                <th>{{__('messages.tva_amount')}}</th>
                <th>{{__('messages.ttc_amount')}}</th>
                <th>{{__('messages.status')}}</th>
                <th>{{__('messages.date_creation')}}</th>
                <th>{{__('messages.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchase_invoices as $value)
                <tr>
                    <td class="d-none">{{$value->id}}</td>
                    <td><a href="javascript:void(0)" class="btn-show-purchase-invoice" data-toggle="modal" data-target="#div-show-old-patient" data-url-show="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.show',$value->id)}}@else javascript:void(0) @endif"  title="{{__('messages.show')}}">{{$value->series}}</a></td>
                    <td>{{$value->supplier->fullname}}</td>
                    <td>{{\Carbon\Carbon::parse($value->date)->format('d/m/Y')}}</td>
                    <td>{{$value->reduction_total_amount}} <b>MAD</b></td>
                    <td>{{$value->ht_total_amount}} <b>MAD</b></td>
                    <td>{{$value->tva_total_amount}} <b>MAD</b></td>
                    <td>{{$value->ttc_total_amount}} <b>MAD</b></td>
                    <td>{!!$value->status_state!!}</td>
                    <td>{{\Carbon\Carbon::parse($value->created_at)->format('d/m/Y H:i:s')}}</td>
                    <td>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.show',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.show')}}"> <i class="fa fa-eye text-info m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.edit',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.edit')}}"> <i class="fa fa-pencil text-success m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.duplicate',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.duplicate')}}"> <i class="fa fa-files-o text-warning m-r-10 icon-datatable"></i> </a>
                        <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.pdf',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.pdf')}}" target="_blank"> <i class="fa fa-file text-primary m-r-10 icon-datatable"></i> </a>
                        @if($value->status == '0')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice_payment.create',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.create')}}"> <i class="fa fa-money text-purple m-r-10 icon-datatable"></i> </a>
                            <a href="javascript:void(0)" class="btn-cancel-item" data-toggle="modal" data-target="#div-cancel-old-item" data-url-cancel="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.cancel',$value->id)}}@else javascript:void(0) @endif" data-title="{{__('messages.cancel_purchase_invoice')}}" data-message="{{__('messages.do_you_want_to_cancel_this')}} {{__('messages.purchase_invoice')}} ?" title="{{__('messages.cancel')}}"> <i class="fa fa-ban text-danger icon-datatable"></i> </a>
                        @elseif($value->status == '1')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice_payment.create',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.create')}}"> <i class="fa fa-money text-brown m-r-10 icon-datatable"></i> </a>
                        @elseif($value->status == '2')
                            <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice_payments',$value->id)}}@else javascript:void(0) @endif" title="{{__('messages.purchase_invoice_payments')}}"> <i class="fa fa-money text-gray m-r-10 icon-datatable"></i> </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>