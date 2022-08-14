<!-- /.modal -->
<div class="modal fade" id="div-create-new-type-drug" tabindex="-1" role="dialog" aria-labelledby="div-create-new-type-drug-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-create-new-type-drug"
                    action="@if(auth()->user()->is_administrator){{route('administrator.type_drug.store')}} @else javascript:void(0) @endif"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-create-new-type-drug-modal">{{__('messages.new')}} {{__('messages.type_of_drug')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.name')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('name')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.name')}}" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.measruing_unit')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('measruing_unit')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.measruing_unit')}}" name="measruing_unit" required>
                            </div>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('messages.save')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modal -->