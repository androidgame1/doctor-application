<!-- Errors validation -->
@if($errors->any())
    <div class="alert alert-danger">
    <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    <h3 class="text-danger"><i class="fa fa-exclamation-triangle"></i> {{__('messages.error')}}</h3>    
            @foreach ($errors->all() as $error)
                <p class="text-danger">- {{ $error }}</p>
            @endforeach 
    </div>
@endif