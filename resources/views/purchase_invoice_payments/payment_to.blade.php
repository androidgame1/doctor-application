<div class="col-md-12">
    <h3>{{__('messages.purchase_invoice')}} : <a href="@if(auth()->user()->is_administrator){{route('administrator.purchase_invoice.show',$purchase_invoice->id)}}@else javascript:void(0) @endif" class="btn-show-purchase-invoice text-primary font-bold" title="{{__('messages.show')}}">{{$purchase_invoice->series}}</a></span></h3>
    <h3>{{__('messages.supplier')}} : <a href="javascript:void(0)" class="text-primary">{{$purchase_invoice->supplier->fullname}}</a></span></h3>
</div>