@extends('layouts.out')
@section('content')
        <div class="login-register" style="background:#4F5467">
            <div class="login-box card">
                <div class="card-body">
                <form method="post" class="form-horizontal" id="from-email" action="{{route('forget.password.post')}}" class="needs-validation" novalidate>   
                @csrf
                        <div class="form-group ">
                                <h3>{{__('messages.recover_password')}}</h3>
                                
                        </div>
                        <div class="form-group ">
                            @include('messages.messages')
                        </div>
                         <div class="form-group ">
                            <p class="text-muted">{{__('messages.enter_your_email_and_instructions_will_be_sent_to_you')}}</p>
                           </div> 
                        <div class="form-group ">
                            <label class="label-group">{{__('messages.email')}}<span class="text-danger"> * </span></label>
                            <div class="col-xs-12">
                                <input class="form-control {{$errors->has('email')?'no-valid':''}}" type="email" placeholder="{{__('messages.email')}}" name="email" required> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">{{__('messages.reset')}}</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
@endsection
@section('javascript')

@endsection