<div class="col-md-12">
    <h3>{{__('messages.activity')}} : <a href="@if(auth()->user()->is_administrator){{route('administrator.activity.show',$activity->id)}}@else javascript:void(0) @endif" class="btn-show-activity text-primary font-bold" title="{{__('messages.show')}}">{{$activity->series}}</a></span></h3>
    <h3>{{__('messages.patient')}} : <a href="javascript:void(0)" class="btn-show-sale-invoice text-primary" title="{{__('messages.show')}}">{{$activity->patient->fullname}}</a></span></h3>
</div>