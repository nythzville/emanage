@if(Session::has('flash_notice'))
    <div class="info-msg">
        <div class="alert alert-success">
            <strong>Succes!</strong> <span class="msg">{{ Session::get('flash_notice') }}</span>
        </div>
    </div>
@endif

@if(Session::has('flash_error'))
    <div class="info-msg" >
        <div class="alert alert-danger">
            <strong>Error!</strong> <span class="msg">{{ Session::get('flash_error') }}</span>
        </div>
    </div>
@endif