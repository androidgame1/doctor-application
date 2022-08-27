<!-- /.modal -->
<div class="modal fade" id="div-destroy-old-item" tabindex="-1" role="dialog" aria-labelledby="div-destroy-old-item-modal">
    <div class="modal-dialog" role="document">
    <form method="post" id="form-destroy-old-item"
                    action=""
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        @method('delete')
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-destroy-old-item-modal"><span name="span-title-old-item"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="table-destroy-old-item" class="table browser no-border m-0">
                <tbody>
                    <tr>
                        <td class="p-1"><p class="text-center" name="p-message"></p></td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">{{__('messages.delete')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->