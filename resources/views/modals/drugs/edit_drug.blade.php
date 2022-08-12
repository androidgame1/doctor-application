<!-- /.modal -->
<div class="modal fade" id="div-edit-old-drug" tabindex="-1" role="dialog" aria-labelledby="div-edit-old-drug-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-edit-old-drug"
                    action=""
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-edit-old-drug-modal">Edit drug</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Trade name<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('trade_name')?'form-control-danger':''}}"
                                    type="text" placeholder="Trade name" name="trade_name" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Generic name<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('trade_name')?'form-control-danger':''}}"
                                    type="text" placeholder="Generic name" name="generic_name" required>
                            </div>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Modifier</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->