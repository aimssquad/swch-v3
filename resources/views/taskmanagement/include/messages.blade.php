
  @if(Session::has('message'))	
        <div class="alert alert-success alert-dismissable __web-inspector-hide-shortcut__">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {{ Session::get('message') }}
        </div>
@endif

 @if(Session::has('error'))		
        <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                {{ Session::get('error') }}
        </div>	
@endif


<div style="color: red; font-size: 16px; display: none;" id="draftmsg">Draft saved...!</div>