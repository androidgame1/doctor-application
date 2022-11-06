<footer class="footer">
    <div class="div-administrator-information text-center">
            <span>{{__('messages.address')}} : {{auth()->user()->address}}</span> | <span>{{__('messages.email')}} : {{auth()->user()->email}}</span> | <span>{{__('messages.phone')}} : {{auth()->user()->phone}}</span>
    </div>
    <br>
    <div class="div-footer-number-page">
        <span class="footer-number-page"></span>
    </div>
</footer>