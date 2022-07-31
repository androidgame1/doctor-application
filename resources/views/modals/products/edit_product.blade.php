<!-- /.modal -->
<div class="modal fade" id="div-edit-old-product" tabindex="-1" role="dialog" aria-labelledby="div-edit-old-product-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-edit-old-product"
                    action=""
                    enctype="multipart/form-data" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-edit-old-product-modal">Edit product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Name<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('name')?'form-control-danger':''}}"
                                    type="text" placeholder="Name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6 cl-12">
                            <div class="form-group">
                                <label class="label-group">Amount<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('amount')?'form-control-danger':''}}"
                                    type="amount" min="1" placeholder="Amount" name="amount" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">Description<span class="text-danger"> * </span></label>
                                <textarea rows="4" class="form-control {{$errors->has('description')?'form-control-danger':''}}"
                                    type="description" placeholder="Description" name="description" required></textarea>
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