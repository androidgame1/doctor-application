<!-- /.modal -->
<div class="modal fade" id="div-edit-old-test" tabindex="-1" role="dialog" aria-labelledby="div-edit-old-test-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-edit-old-test"
                    action=""
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-edit-old-test-modal">Edit test</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">Name<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('name')?'form-control-danger':''}}"
                                    type="text" placeholder="Name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">Description<span class="text-danger d-none"> * </span></label>
                                <textarea rows="4" class="form-control {{$errors->has('description')?'form-control-danger':''}}"
                             placeholder="Description" name="description"></textarea>
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