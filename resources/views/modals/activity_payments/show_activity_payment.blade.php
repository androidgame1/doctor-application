<!-- /.modal -->
<div class="modal fade" id="div-show-old-activity-payment" tabindex="-1" role="dialog" aria-labelledby="div-show-old-activity-payment-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-show-old-activity-payment-modal">{{__('messages.show_activity_payment')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="table-show-old-activity-payment" class="table browser m-0 no-border">
                <tbody>
                    <tr>
                        <td><b></b>{{__('messages.activity')}}</td>
                        <td class="text-right"><span class="text-primary" name="activity"></span></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.ht_amount')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="ht_amount"></span> <b>MAD</b></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.given_amount')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="given_amount"></span> <b>MAD</b></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.remaining_amount')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="remaining_amount"></span> <b>MAD</b></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.way_of_payment')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="way_of_payment"></span></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.remark')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="remark"></span></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.justification')}}</b></td>
                        <td class="text-right"><div name="justification"></div></td>
                    </tr>
                    <tr>
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