<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" id="form-filter-between-two-dates" action="@if(in_array(Route::current()->getName(),['administrator.charges.secretary','administrator.charges.secretary.dates.filter','administrator.appointments','administrator.appointments.dates.filter'])) {{route($route,$param1)}} @else {{route($route)}} @endif" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @include('messages.messages')
                        </div>
                        <div class="col-12">
                            <div class="d-flex">
                                    <input class="form-control mx-1 {{$errors->has('start_date')?'form-control-danger':''}}"
                                    type="date" placeholder="{{__('messages.start_date')}}" name="start_date" value="">
                                    <input class="form-control mx-1 {{$errors->has('end_date')?'form-control-danger':''}}"
                                    type="date" placeholder="{{__('messages.end_date')}}" name="end_date" value="">        
                                    <button type="submit" class="btn btn-primary mx-1"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>