<!-- /.modal -->
<div class="modal fade" id="div-edit-old-appointment" tabindex="-1" role="dialog" aria-labelledby="div-edit-old-appointment-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-edit-old-appointment"
                    action=""
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-edit-old-appointment-modal">{{__('messages.edit_appointment')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.patient')}}<span class="text-danger"> * </span></label>
                                <select name="patient_id" id="patient_id" class="form-control {{$errors->has('patient_id')?'form-control-danger':''}}" required>
                                    <option value="">Select</option>
                                    @foreach($patients as $value)
                                        <option value="{{$value->id}}">{{$value->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.status')}}<span class="text-danger"> * </span></label>
                                <select name="status_id" id="status_id" class="form-control {{$errors->has('status_id')?'form-control-danger':''}}" required>
                                    <option value="">Select</option>
                                    @foreach($status as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.start_date')}}<span class="text-danger"> * </span></label>
                                <input type="datetime-local" class="form-control {{$errors->has('start_date')?'form-control-danger':''}}" placeholder="{{__('messages.start_date')}}" name="start_date" required/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.end_date')}}<span class="text-danger"> * </span></label>
                                <input type="datetime-local" class="form-control {{$errors->has('end_date')?'form-control-danger':''}}" placeholder="{{__('messages.end_date')}}" name="end_date" required/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label-group">{{__('messages.remark')}}<span class="text-danger d-none"> * </span></label>
                                <textarea rows="4" class="form-control {{$errors->has('remark')?'form-control-danger':''}}" placeholder="{{__('messages.remark')}}" name="remark"></textarea>
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