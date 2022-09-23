<!-- /.modal -->
<div class="modal fade" id="div-show-old-delivery-order" tabindex="-1" role="dialog" aria-labelledby="div-show-old-delivery-order-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-show-old-delivery-order-modal">{{__('messages.show_delivery_order')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="table-show-old-delivery-order" class="table browser m-t-30 no-border">
                <tbody>
                    <tr>
                        <td><b></b>{{__('messages.series')}}</td>
                        <td class="text-right"><span class="text-primary" name="series"></span></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.supplier')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="supplier"></span><b></b></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.remark')}}</b></td>
                        <td class="text-right"><span class="text-gray" name="remark"></span></td>
                    </tr>
                    <tr>
                        <td><b>{{__('messages.file')}}</b></td>
                        <td class="text-right"><div name="file"></div></td>
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