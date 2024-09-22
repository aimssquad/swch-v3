@if(Session::has('message'))	
<div class="alert alert-solid-success alert-dismissible fade show mt-2 mb-2">
    {{ Session::get('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button>
</div>
<br><br>
@endif

@if(Session::has('error'))		
<div class="alert alert-solid-danger alert-dismissible fade show mt-2 mb-2">
    {{ Session::get('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button>
</div>
<br><br>	
@endif

{{-- <div style="color: red; font-size: 16px; display: none;" id="draftmsg">Draft saved...!</div> --}}
