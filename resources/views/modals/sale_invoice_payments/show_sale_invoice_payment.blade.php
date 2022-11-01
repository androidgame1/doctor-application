<!-- /.modal -->
<div class="modal fade" id="div-show-old-sale-invoice-payment" tabindex="-1" role="dialog" aria-labelledby="div-show-old-sale-invoice-payment-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-show-old-sale-invoice-payment-modal">{{__('messages.show_sale_invoice_payment')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="table-show-old-sale-invoice-payment" class="table browser m-0 no-border">
                <tbody>
                    <tr class="tr-show">
                        <td><b></b>{{__('messages.sale_invoice')}}</td>
                        <td class="text-right"><span class="text-primary" name="sale_invoice"></span></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.ttc_amount')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="ttc_amount"></span> <b>MAD</b></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.given_amount')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="given_amount"></span> <b>MAD</b></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.ttc_amount')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="remaining_amount"></span> <b>MAD</b></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.way_of_payment')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="way_of_payment"></span></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.remark')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="remark"></span></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.justification')}}</b></td>
                        <td class="text-right"><div name="justification"></div></td>
                    </tr>
                    <tr class="tr-show">
                        <td><b>{{__('messages.date')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="date"></span></td>
                    </tr>
                    
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->