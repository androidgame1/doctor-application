<!DOCTYPE html>
@extends('layouts.out')
@section('content')
        <div class="login-register" style="background:#4F5467">
            <div class="login-box card">
                <div class="card-body">
                    <form method="post" id="form-login" action="{{route('login')}}" class="needs-validation" novalidate>
                        @csrf 
                        <div class="form-group ">
                            <h3 class="box-title m-b-20">Sign In</h3>
                        </div>
                        
                        <div class="form-group ">
                            @include('messages.messages')
                        </div>
                        <div class="form-group ">
                            <label class="label-group">Email<span class="text-danger"> * </span></label>
                            <div class="col-xs-12">
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}" type="email" value="{{Cookie::get('email')?Cookie::get('email'):old('email')}}" placeholder="Email" name="email" required> </div>
                        </div>
                        <div class="form-group">
                            <label class="label-group">Password<span class="text-danger"> * </span></label>
                            <div class="col-xs-12">
                                <input class="form-control {{$errors->has('password')?'form-control-danger':''}}" type="password" value="{{Cookie::get('password')?Cookie::get('password'):old('password')}}" placeholder="Password" name="password" required> </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" {{Cookie::get('email') && Cookie::get('password')?'checked':''}} class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember me</label>
                                    <a href="{{route('forget.password.get')}}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password ?</a> 
                                </div> 
                            </div>
                        </div>
                        <div class="form-group m-0 text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
@section('javascript')

@endsection