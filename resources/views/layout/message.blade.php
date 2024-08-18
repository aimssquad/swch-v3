{{-- @if(Session::has('message'))										
<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
@endif --}}

@if(Session::has('message'))	
<div class="alert alert-success alert-dismissable __web-inspector-hide-shortcut__">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ Session::get('message') }}
</div>
<br><br>
@endif

{{-- @if(Session::has('message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
        <button class="close" data-dismiss="alert" type="button">×</button>
    {{ Session::get('message') }}
    
</div>
<br><br>
@endif --}}

@if(Session::has('error'))		
<div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ Session::get('error') }}
</div>
<br><br>	
@endif


<div style="color: red; font-size: 16px; display: none;" id="draftmsg">Draft saved...!</div>