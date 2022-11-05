<!-- /.modal -->
<div class="modal fade" id="div-show-old-test" tabindex="-1" role="dialog" aria-labelledby="div-show-old-test-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-show-old-test-modal">{{__('messages.show_test')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="table-show-old-test" class="table browser m-0 no-border">
                <tbody>
                    <tr class="tr-show">
                        <td><b>{{__('messages.name')}}</b></td>
                        <td class="text-right"><span class="text-primary" name="name"></span></td>
                    </tr>
                    <tr class="tr-show">
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