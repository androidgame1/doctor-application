<!-- /.modal -->
<div class="modal fade" id="div-create-new-drug" tabindex="-1" role="dialog" aria-labelledby="div-create-new-drug-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-create-new-drug"
                    action="@if(auth()->user()->is_administrator){{route('administrator.drug.store')}} @else javascript:void(0) @endif"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-create-new-drug-modal">New drug</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Trade name<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('trade_name')?'form-control-danger':''}}"
                                    type="text" placeholder="Trade name" name="trade_name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Generic name<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('trade_name')?'form-control-danger':''}}"
                                    type="text" placeholder="Generic name" name="generic_name" required>
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
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->