<footer class="footer">
    <div class="div-administrator-information">
        <table width="100%">
            <tbody>
                <tr>
                    <td><span><b>{{__('messages.address')}} :</b> {{auth()->user()->address}}</span></td>
                    <td><span><b>{{__('messages.email')}} :</b> {{auth()->user()->email}}</span></td>
                    <td><span><b>{{__('messages.phone')}} :</b> {{auth()->user()->phone}}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <div class="div-footer-number-page">
        <span class="footer-number-page"></span>
    </div>
</footer>