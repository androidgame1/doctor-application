<!-- /.modal -->
<div class="modal fade" id="div-add-new-test" tabindex="-1" role="dialog" aria-labelledby="div-add-new-test-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-add-new-test-modal">{{__('messages.add_test')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-add-new-test" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.test')}}<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('test')?'form-control-danger':''}}"
                                    type="text" name="test" required>
                                    <option value="" selected>{{__('messages.select')}}</option>
                                    @foreach($tests as $value)
                                        <option value="{{$value->id}}" data-id="{{$value->id}}" data-name="{{$value->name}}" data-description="{{$value->description}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.description')}}<span class="text-danger d-none"> * </span></label>
                                <textarea rows="4" class="form-control {{$errors->has('description')?'form-control-danger':''}}"
                             placeholder="{{__('messages.description')}}" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save-new-test"><i class="fa fa-save"></i> {{__('messages.save')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->