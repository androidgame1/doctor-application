<div class="col-md-12">
    <h3>{{__('messages.sale_invoice')}} : <a href="@if(auth()->user()->is_administrator){{route('administrator.sale_invoice.show',$sale_invoice->id)}}@else javascript:void(0) @endif" class="btn-show-sale-invoice text-primary font-bold" title="{{__('messages.show')}}">{{$sale_invoice->series}}</a></span></h3>
    <h3>{{__('messages.patient')}} : <a href="javascript:void(0)" class="btn-show-sale-invoice text-primary" title="{{__('messages.show')}}">{{$sale_invoice->patient->fullname}}</a></span></h3>
</div>