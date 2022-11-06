<!-- /.modal -->
<div class="modal fade" id="div-edit-old-drug" tabindex="-1" role="dialog" aria-labelledby="div-edit-old-drug-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-edit-old-drug"
                    action=""
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-edit-old-drug-modal">{{__('messages.edit_drug')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.trade_name')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('trade_name')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.trade_name')}}" name="trade_name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.generic_name')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('trade_name')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.generic_name')}}" name="generic_name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.description')}}<span class="text-danger d-none"> * </span></label>
                                <textarea rows="4" class="form-control {{$errors->has('description')?'no-valid':''}}"
                             placeholder="{{__('messages.description')}}" name="description" ></textarea>
                            </div>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> {{__('messages.modify')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->