@extends('employeer.include.app')
@section('title', 'Add Bank Short Code')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="col">
         <h3 class="page-title">Job List</h3>
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Dashboard</a></li>
            @if(isset($_GET['id']))
            <li class="breadcrumb-item active">Edit Job List</li>
            @else
            <li class="breadcrumb-item active">Add Job List</li>
            @endif 
         </ul>
      </div>
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  <div class="card-header">
                     @if(isset($_GET['id']))
                     <h4 class="card-title"><i class="fas fa-university"></i>Edit Job List</h4>
                     @else
                     <h4 class="card-title"><i class="far fa-user"></i> Add Job List</h4>
                     @endif 
                  </div>
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                  @endif
                  @if(Session::has('error'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('error') }}</div>
                  @endif
                  <div class="card-body">
                     <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                              <form action="" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <div class="row">
                                    <?php  if(request()->get('id')!=''){ }
                                       else{
                                           ?>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="type" class="placeholder">Select Job Type</label>
                                          <select id="type" type="text" class="form-control input-border-bottom" required="" name="type" onchange="jobcheck(this.value);">
                                             <option value="" >&nbsp;</option>
                                             <option  value="new"  >New</option>
                                             <option  value="exiting"  >Existing</option>
                                          </select>
                                       </div>
                                    </div>
                                    <?php
                                       }
                                       ?>
                                    <?php  if(request()->get('id')!=''){
                                       ?>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-soc-code" class="placeholder">Job Code</label>
                                          <input id="inputFloatingLabel-soc-code" type="text" class="form-control input-border-bottom" required="" name="soc" value="<?php if(isset($_GET['id'])){  echo $departments[0]->soc;  }?>{{ old('soc') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
                                       </div>
                                    </div>
                                    <?php
                                       }
                                       else{
                                       ?>
                                    <div class="col-md-4" id="newcust" style="display:none;">
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-soc-code" class="placeholder">Job Code</label>
                                          <input id="socnew" type="text" class="form-control input-border-bottom" name="socnew" value="<?php if(isset($_GET['id'])){  echo $departments[0]->soc;  }?>{{ old('soc') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
                                       </div>
                                    </div>
                                    @if( isset($oldcust) && count($oldcust)!=0)
                                    <div class="col-md-4" id="oldcust" style="display:none;">
                                       <div class=" form-group">
                                          <label for="soc" class="placeholder">Job Code</label>
                                          <select id="socold" type="text" class="form-control input-border-bottom"  name="socold" onChange="socClick()">
                                             <option value="" >&nbsp;</option>
                                             @foreach($oldcust as $recruitment_job)
                                             <option value="{{ $recruitment_job->soc }}" >{{ $recruitment_job->soc }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                    @endif
                                    <?php
                                       }
                                       ?>
                                    <div class="col-md-4">
                                       <div id="test">
                                          <div class=" form-group">
                                             <label>Department</label>
                                             <input type="text" id="dept" class="form-control" class="form-control" name="department" placeholder="Enter Your Department">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div id="test1"></div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-job-title" class="placeholder">Job Title  </label>
                                          <input id="inputFloatingLabel-job-title" type="text" class="form-control input-border-bottom" required="" name="title" value="<?php if(isset($_GET['id'])){  echo $departments[0]->title;  }?>{{ old('title') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <input id="skil_set" type="hidden" class="form-control input-border-bottom" required="" name="skil_set" value="<?php if(isset($_GET['id'])){  echo $departments[0]->skil_set;  }?>{{ old('skil_set') }}" >
                                       <div class=" form-group">
                                          <label for="editor"  class="placeholder">Job Descriptions</label>
                                          <textarea   rows="5" class="form-control"  required="" id="editor" name="des_job"><?php if(isset($_GET['id'])){?>  {!! $departments[0]->des_job !!} <?php  }?> </textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <div class="col-md-6"><button type="submit" class="btn btn-default" style="margin-top: 12px;">Submit</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
<script >
   $(document).ready(function() {
       $('#basic-datatables').DataTable({
       });
   
       $('#multi-filter-select').DataTable( {
           "pageLength": 5,
           initComplete: function () {
               this.api().columns().every( function () {
                   var column = this;
                   var select = $('<select class="form-control"><option value=""></option></select>')
                   .appendTo( $(column.footer()).empty() )
                   .on( 'change', function () {
                       var val = $.fn.dataTable.util.escapeRegex(
                           $(this).val()
                           );
   
                       column
                       .search( val ? '^'+val+'$' : '', true, false )
                       .draw();
                   } );
   
                   column.data().unique().sort().each( function ( d, j ) {
                       select.append( '<option value="'+d+'">'+d+'</option>' )
                   } );
               } );
           }
       });
   
       // Add Row
       $('#add-row').DataTable({
           "pageLength": 5,
       });
   
       var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
   
       $('#addRowButton').click(function() {
           $('#add-row').dataTable().fnAddData([
               $("#addName").val(),
               $("#addPosition").val(),
               $("#addOffice").val(),
               action
               ]);
           $('#addRowModal').modal('hide');
   
       });
   });
   function jobcheck(val) {
   if(val=='new'){
    console.log(val);
   
       document.getElementById("newcust").style.display = "block";
       document.getElementById("oldcust").style.display = "none";
       $("#socnew").prop('required',true);
           $("#socold").prop('required',false);
           $("#test").html(`
   
                                       <div class="form-group">
                                               <label for="department">Department</label>
                                               <select class="form-control" name="department">
                                               <option>Department</option>
                                               @if(isset($depert) && count($depert)!=0)
                                               @foreach($depert as $recruitment_job)
                                               <option value="{{ $recruitment_job->department_name }}" >{{ $recruitment_job->department_name }}</option>
                                                  @endforeach
                                              @endif
                                               </select>
                                           </div>
   
           `)
   }else{
        $('select#socold option:selected'). val();
        let valuess =$('#socold :selected').text();
        //console.log(valuess);
       // let socVal=$("#socold").val();
        console.log("++++++++",valuess)
       document.getElementById("newcust").style.display = "none";
       document.getElementById("oldcust").style.display = "block";
           $("#socold").prop('required',true);
           $("#socnew").prop('required',false);
   
           // $("#test").html(`<h1>test 2222</h1>`)
   }
   
   }
   
   function socClick(){
   let socid =$('#socold :selected').text();
   $.ajax({
   url:"soccode" + "/" + socid,
   type: "GET",
   success: function (response) {
   const arrayValue = JSON.parse(response);
   console.log("==========", arrayValue[0].department);
   if (arrayValue.length == 0) {
   
   } else {
   $("#dept").val(arrayValue[0].department).prop("readonly", false);
   }
   },
   error: function (data) {
   
   },
   });
   }
   
</script>
@endsection