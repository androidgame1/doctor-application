<footer class="footer">
    <div class="div-administrator-information text-center">
            <span>{{__('messages.address')}} : {{auth()->user()->address}}</span> |
             <span>{{__('messages.email')}} : {{auth()->user()->email}}</span> |
             <span>{{__('messages.phone')}} : {{auth()->user()->phone}}</span> 
            {!!auth()->user()->ice ? ' | <span>'.__('messages.ice') .' : '. auth()->user()->ice.'</span>' : ''!!}
            {!!auth()->user()->rc ? ' | <span>'.__('messages.rc') .' : '. auth()->user()->rc.'</span>' : ''!!}
            {!!auth()->user()->if ? ' | <span>'.__('messages.if') .' : '. auth()->user()->if.'</span>' : ''!!}
    </div>
    <br>
    <div class="div-footer-number-page">
        <span class="footer-number-page"></span>
    </div>
</footer>