@extends('layouts.out')
@section('content')
        <div class="login-register" style="background:#5400a1">
            <div class="login-box card">
                <div class="card-body">
                <form method="post" class="form-horizontal" id="form-reset" action="{{route('reset.password.post')}}" class="needs-validation" novalidate>
                        @method('post') 
                        @csrf  
                        <input type="hidden" name="token" value={{$token}}>      
                        <div class="form-group ">
                                <h3>Recover Password</h3>   
                        </div>
                        <div class="form-group ">
                            @include('messages.messages')
                        </div>
                        <div class="form-group ">
                             <p class="text-muted">Enter the new password ! </p>
                        </div> 
                        <div class="form-group ">
                            <label class="label-group">Email<span class="text-danger"> * </span></label>
                            <div class="col-xs-12">
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}" value="{{ $email ?? old('email') }}" type="email" placeholder="Email" name="email" required> </div>
                        </div>
                        <div class="form-group">
                            <label class="label-group">New password<span class="text-danger"> * </span></label>
                            <div class="col-xs-12">
                                <input class="form-control {{$errors->has('new_password')?'form-control-danger':''}}" type="password" placeholder="New password" name="new_password" required> </div>
                        </div>
                        <div class="form-group">
                            <label class="label-group">Confirm password<span class="text-danger"> * </span></label>
                            <div class="col-xs-12">
                                <input class="form-control {{$errors->has('confirm_password')?'form-control-danger':''}}" type="password" placeholder="confirm_password" name="confirm_password" required> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('javascript')

@endsection