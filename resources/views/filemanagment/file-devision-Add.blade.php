@extends('filemanagment.include.app')
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="#">
            Home
            </a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="#">Add File Managment</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  @if(Session::has('message'))
                  <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                  @endif
                  <div class="card-body">
                    <form  method="post" action="{{url('fileManagment/fileManagment-division-adds')}}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                   <label>Name</label>
                                   <input type="text" class="form-control" id="name" name="name" oninput="intrFunction()" required>
                                   <input type="hidden" id="sort" class="form-control" name="sort_name" >
                                </div>
                                </div>
                        </div>
                        <div class="row form-group">

                           <div class="col-md-3">
                              <a href="#">
                              <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Go</button></a>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   @endsection
   @section('js')
{{-- @include('payroll.partials.scripts') --}}
<script>
	function intrFunction(){
    $name=$("#name").val();
    $first=$name.charAt(0);
    $seco=$name.charAt(1);
      $finaltwochar=$first+""+$seco
    $("#sort").val($finaltwochar);
   }
</script>
@endsection
