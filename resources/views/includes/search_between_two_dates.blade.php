<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" id="form-filter-between-two-dates" action="@if(in_array(Route::current()->getName(),['administrator.charges.secretary','administrator.charges.secretary.dates.filter','administrator.appointments','administrator.appointments.dates.filter','administrator.delivery_orders.purchase_order.dates.filter'])) {{$route}} @else {{$route}} @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                    <input class="form-control mx-1 {{$errors->has('start_date')?'form-control-danger':''}}"
                                    type="date" placeholder="{{__('messages.start_date')}}" name="start_date" value="{{old('start_date')}}">
                                    <input class="form-control mx-1 {{$errors->has('end_date')?'form-control-danger':''}}"
                                    type="date" placeholder="{{__('messages.end_date')}}" name="end_date" value="{{old('end_date')}}">        
                                    <button type="submit" class="btn btn-primary mx-1"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(Route::current()->getName() == 'administrator.home')
            <div class="card">
                <div class="card-body">
                    <form method="post" id="form-filter-report-between-two-dates" action="{{route('administrator.home.report')}}" enctype="multipart/form-data" class="needs-validation" novalidate target="_blank">
                        @method('post')
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                @include('messages.messages')
                            </div>
                            <div class="col-12">
                                <div class="d-flex">
                                        <input class="form-control mx-1 {{$errors->has('start_date')?'form-control-danger':''}}"
                                        type="date" placeholder="{{__('messages.start_date')}}" name="start_date"  value="{{old('start_date')}}">
                                        <input class="form-control mx-1 {{$errors->has('end_date')?'form-control-danger':''}}"
                                        type="date" placeholder="{{__('messages.end_date')}}" name="end_date" value="{{old('end_date')}}">        
                                        <button type="submit" class="btn btn-info mx-1"><i class="fa fa-file"></i> {{__('messages.report')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>