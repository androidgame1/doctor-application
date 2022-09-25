<!-- /.modal -->
<div class="modal fade" id="div-show-old-charge" tabindex="-1" role="dialog" aria-labelledby="div-show-old-charge-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-show-old-charge-modal">{{__('messages.show_charge')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="table-show-old-charge" class="table browser m-t-30 no-border">
                <tbody>
                    <tr>
                        <td><b></b>{{__('messages.name')}}</td>
                        <td class="text-right"><span class="text-primary" name="name"></span></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.amount')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="amount"></span> <b>MAD</b></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.description')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="description"></span></td>
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