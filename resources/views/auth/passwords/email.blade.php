@extends('layouts.out')
@section('content')
        <div class="login-register" style="background:#4F5467">
            <div class="login-box card">
                <div class="card-body">
                <form method="post" class="form-horizontal" id="from-email" action="{{route('forget.password.post')}}" novalidate>   
                @csrf
                        <div class="form-group ">
                                <h3>Recover Password</h3>
                                
                        </div>
                        <div class="form-group ">
                            @include('messages.messages')
                        </div>
                         <div class="form-group ">
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                           </div> 
                        <div class="form-group ">
                            <label class="label-group">Email<span class="text-danger"> * </span></label>
                            <div class="col-xs-12">
                                <input class="form-control {{$errors->has('email')?'form-control-danger':''}}" type="email" placeholder="Email" name="email" required> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
@endsection
@section('javascript')

@endsection