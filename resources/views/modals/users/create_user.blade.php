<!-- /.modal -->
<div class="modal fade" id="div-create-new-user" tabindex="-1" role="dialog" aria-labelledby="div-create-new-user-modal">
    <div class="modal-dialog" role="document">
        <form method="post" id="form-create-new-user"
                    action="@if(auth()->user()->is_superadministrator){{route('superadministrator.user.store',$role)}}@elseif(auth()->user()->is_administrator){{route('administrator.user.store',$role)}} @else javascript:void(0) @endif"
                    enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="div-create-new-user-modal">New @if($role=="administrator") administrator @elseif($role == "secretary") secretary @elseif($role == "deliveryman") delivery man @else error @endif</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                    @method('post')
                    @csrf
                    <input type="hidden" name="role" value="{{$role}}">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">CIN<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('cin')?'form-control-danger':''}}"
                                    type="text" placeholder="CIN" name="cin" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Fullname<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('fullname')?'form-control-danger':''}}"
                                    type="text" placeholder="Fullname" name="fullname" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Email<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}"
                                    type="email" placeholder="Email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Address<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('address')?'form-control-danger':''}}"
                                    type="text" placeholder="Address" name="address" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Phone<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('phone')?'form-control-danger':''}}"
                                    type="text" placeholder="Phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">City<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('city')?'form-control-danger':''}}"
                                    type="text" placeholder="City" name="city" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Password<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('password')?'form-control-danger':''}}"
                                    type="password" placeholder="Password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label class="label-group">Confirm password<span class="text-danger"> * </span></label>
                                <input class="form-control {{$errors->has('confirm_password')?'form-control-danger':''}}"
                                    type="password" placeholder="Confirm password" name="confirm_password" required>
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