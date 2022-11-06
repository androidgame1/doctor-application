<!-- /.modal -->
<div class="modal fade" id="div-add-new-drug" tabindex="-1" role="dialog" aria-labelledby="div-add-new-drug-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-add-new-drug-modal">{{__('messages.add_drug')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-add-new-drug" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group" data-field="type">{{__('messages.type')}}<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('type')?'form-control-danger':''}}"
                                    type="text" name="type" id="select-type-of-drug" required>
                                    <option value="" selected>{{__('messages.select')}}</option>
                                    @foreach($type_drugs as $value)
                                        <option value="{{$value->id}}" data-id="{{$value->id}}" data-name="{{$value->name}}" data-measruing-unit="{{$value->measruing_unit}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.drug')}}<span class="text-danger"> * </span></label>
                                <select class="form-control {{$errors->has('drug')?'form-control-danger':''}}"
                                    type="text" name="drug" required>
                                    <option value="" selected>{{__('messages.select')}}</option>
                                    @foreach($drugs as $value)
                                        <option value="{{$value->id}}" data-id="{{$value->id}}" data-trade-name="{{$value->trade_name}}" data-generic-name="{{$value->generic_name}}" data-description="{{$value->description}}">{{$value->trade_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group" data-field="quantity">{{__('messages.quantity')}} <span name="quantity"></span><span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('quantity')?'form-control-danger':''}}"
                                    type="number" min="1" placeholder="{{__('messages.quantity')}}" name="quantity">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.dose')}}<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('dose')?'form-control-danger':''}}"
                                    type="number" min="1" placeholder="{{__('messages.dose')}}" name="dose">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.duration')}} ({{__('messages.day')}})<span class="text-danger d-none"> * </span></label>
                                <input class="form-control {{$errors->has('duration')?'form-control-danger':''}}"
                                    type="number" min="1" placeholder="{{__('messages.duration')}}" name="duration">
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
                <button type="submit" class="btn btn-primary" id="btn-save-new-drug"><i class="fa fa-save"></i> {{__('messages.save')}}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('messages.close')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->