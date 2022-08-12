<!-- Errors validation -->
@if($errors->any())
    <div class="alert alert-danger">
    <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    <h3 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Error</h3><span class="text-danger">    
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </span> 
    </div>
@endif