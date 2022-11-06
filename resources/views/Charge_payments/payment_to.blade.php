<div class="col-md-12">
    <h3>{{__('messages.charge')}} N° : <a href="javascript:void(0)" class="btn-show-charge text-primary font-bold" title="{{__('messages.show')}}">{{$charge->id}}</a></span></h3>
    <h3>{{__('messages.name')}} : <a href="javascript:void(0)">{{$charge->name}}</a></span></h3>
    @if($charge->secretary)
        <h3>{{__('messages.secretary')}} : <a href="javascript:void(0)">{{$charge->secretary->fullname}}</a></span></h3>
    @endif
</div>