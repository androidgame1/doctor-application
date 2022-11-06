<!-- /.modal -->
<div class="modal fade" id="div-edit-old-product" tabindex="-1" role="dialog" aria-labelledby="div-edit-old-product-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-edit-old-product"
                    action=""
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-edit-old-product-modal">{{__('messages.edit_product')}}</h4>
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
                                <label class="label-group">{{__('messages.name')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('name')?'no-valid':''}}"
                                    type="text" placeholder="{{__('messages.name')}}" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.amount')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('amount')?'no-valid':''}}"
                                    type="number" min="1" placeholder="{{__('messages.amount')}}" name="amount" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.description')}}<span class="text-danger d-none"> * </span></label>
                                <textarea rows="4" class="form-control {{$errors->has('description')?'no-valid':''}}"
                                 placeholder="{{__('messages.description')}}" name="description"></textarea>
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