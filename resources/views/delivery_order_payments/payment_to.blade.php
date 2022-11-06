<div class="col-md-12">
    <h3>{{__('messages.delivery_order')}} : <a href="@if(auth()->user()->is_administrator){{route('administrator.delivery_order.show',$delivery_order->id)}}@else javascript:void(0) @endif" class="btn-show-delivery-order text-primary font-bold" title="{{__('messages.show')}}">{{$delivery_order->series}}</a></span></h3>
    <h3>{{__('messages.supplier')}} : <a href="javascript:void(0)" class="text-primary">{{$delivery_order->supplier->fullname}}</a></span></h3>
</div>