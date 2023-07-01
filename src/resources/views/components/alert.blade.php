@if (session('flash_message'))
    <div class="flash_message bg-success text-center py-3 my-0">
        {{ session('flash_message') }}
    </div>
@endif
@if (session('warning_message'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
        {{ session('warning_message') }}
    </div>
@endif