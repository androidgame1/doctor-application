<!-- /.modal -->
<div class="modal fade" id="div-edit-old-charge" tabindex="-1" role="dialog" aria-labelledby="div-edit-old-charge-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-edit-old-charge"
                    action=""
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-edit-old-charge-modal">{{__('messages.edit_charge')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('put')
                    @csrf
                    <div class="row">
                        @if($secretary)
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label class="label-group">{{__('messages.secretary')}}<span class="text-danger"> * </span></label>
                                    <input class="form-control {{$errors->has('secretary')?'form-control-danger':''}}"
                                        type="text" placeholder="{{__('messages.secretary')}}" value="{{$secretary->fullname}}" name="secretary" readonly required>
                                        <input class="form-control {{$errors->has('secretary')?'form-control-danger':''}}"
                                        type="hidden" placeholder="{{__('messages.secretary')}}" value="{{$secretary->id}}" name="secretary_id" required>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.name')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('name')?'form-control-danger':''}}"
                                    type="text" placeholder="{{__('messages.name')}}" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.amount')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('amount')?'form-control-danger':''}}"
                                    type="number" min="1" placeholder="{{__('messages.amount')}}" name="amount" required>
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