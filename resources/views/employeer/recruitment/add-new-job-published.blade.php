@extends('employeer.include.app')
@section('title', 'Job Published')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
                @if(isset($_GET['id']))
                <h4 class="card-title"><i class="fas fa-briefcase"></i> Edit Job Published</h4>
                @else
                <h4 class="card-title"><i class="fas fa-briefcase"></i> Add Job Published</h4>
                @endif 
				<ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Recruitment Dashboard</a></li>
					<li class="breadcrumb-item active">Job Published</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->
   @include('employeer.layout.message')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}					
                    <div class="row form-group">
                       
                       <div class="col-md-4">
                          
                          <div class=" form-group">
                             <label for="inputFloatingLabel-soc-code" class="col-form-label">JOB Code</label>
                             <select id="job_id" class="form-control input-border-bottom" required="" name="job_id"  onchange="chngdepartment(this.value);">
                                <option value="">select</option>
                               @foreach($department_rs as $dept)
                                <?php
                                   $email = Session::get('emp_email');
                                   $dataRoledata = DB::table('registration')      
                                   ->where('email','=',$email) 
                                   ->first();
                                   if(isset($_GET['id'])){ ?>
                                     
                                    <option value="{{$dept->soc}}" <?php if($dept->soc==$dept->soc){?> selected="selected"<?php }?>>{{$dept->soc}}</option>
                                    
                                      <?php
                                    if($designation[0]->job_id==$dept->id){
                                        ?>
                                      <option value="{{$dept->soc}}" <?php  if(isset($_GET['id'])){  if($designation[0]->job_id==$dept->id){ echo 'selected';} } ?>>{{$dept->soc}}</option>
                                      <?php
                                    }
                                   }else{
                                    $deptgf= DB::table('company_job')      
                                   ->where('emid','=',$dataRoledata->reg) 
                                   ->where('soc','=',$dept->id) 
                                   ->first();
                                   
                                   
                                   ?>
                                <option value="{{$dept->soc}}">{{$dept->soc}}</option>
                                <?php
                                   }
                                   ?>
                                @endforeach
                             </select>
                          </div>
                       </div>
                       <?php   if(isset($_GET['id'])){ ?>
                       <div class="col-md-4">
                          <label for="title" class="col-form-label">Job Title</label>
                           <select id="title" class="form-control input-border-bottom" required="" name="title"  onchange="chngdepartmentdesp(this.value);">
                                <option value="" <?php if($designation[0]->title==$designation[0]->title){?> selected="selected"<?php }?>><?php echo $designation[0]->title; ?></option>
                             </select>
                          {{-- <input id="title" type="text"  name="title" class="form-control input-border-bottom" required=""  value="<?php //if(isset($_GET['id'])){  echo $designation[0]->title;  }?>{{ old('title') }}" 	<?php //if(isset($_GET['id'])){ echo 'readonly';}?>> --}}
                       </div>
                       <?php
                          }else{
                              ?>
                       <div class="col-md-4">
                          <div class=" form-group">
                             <label for="title" class="col-form-label">Job Title</label>
                             <select id="title" class="form-control input-border-bottom" required="" name="title"  onchange="chngdepartmentdesp(this.value);">
                                <option value="">&nbsp;</option>
                             </select>
                          </div>
                       </div>
                       <?php
                          }
                          ?>
                       <div class="col-md-4">
                          <div class=" form-group">
                             <label for="department" class="col-form-label">Department</label>
                             <input id="department" type="text" class="form-control input-border-bottom" required="" name="department" value="<?php if(isset($_GET['id'])){  echo $designation[0]->department;  }?>{{ old('title') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
                          </div>
                       </div>
                    </div>
                    <div class="row form-group">
                       <div class="col-md-12">
                          <label for="job_desc" class="col-form-label">Job Description</label>
                          <textarea id="job_desc"   name="job_desc" type="text"  rows="5" class="form-control"  required="" <?php if(isset($_GET['id'])){ echo 'readonly';}?>><?php if(isset($_GET['id'])){  ?>  {!! $designation[0]->job_desc !!} <?php }?>  </textarea>
                       </div>
                    </div>
                    <h3 class="card-title" style="border-bottom: 1px solid #ccc;padding: 15px 0;margin-bottom: 16px;">Published websites </h3>
                    <div id="education_fields">
                       <?php if(isset($_GET['id'])){ ?> 
                       <?php   $trupload_id=0;
                          $rr=1;
                            $deptgfhh= DB::table('job_post')      
                                  
                                   ->where('job_id','=',$designation[0]->job_id) 
                                   ->where('title','=',$designation[0]->title) 
                                    ->where('emid','=',$Roledata->reg) 
                                   ->get();
                              
                          $countpayuppas= count($deptgfhh)			;?>
                       @if ($countpayuppas!=0)
                       @foreach($deptgfhh as $empuprs)
                       @if($empuprs->url!='')
                       <div class="row form-group">
                          <div class="col-md-6">
                             <div class="form-group">
                                @if($trupload_id==0)
                                <label class="col-form-label">Published websites url/link   </label>
                                @endif
                                <input type="text" class="form-control input-border-bottom" id="url_{{ $empuprs->id}}"  name="url_{{ $empuprs->id}}" value="{{ $empuprs->url}}" >
                                <input  type="hidden" class="form-control input-border-bottom" name="id_up_doc[]" value="{{ $empuprs->id}}">
                             </div>
                          </div>
                          <div class="col-md-4">
                             <div class="form-group">
                                @if($trupload_id==0)
                                <label for="other_doc_input_{{ $empuprs->id}}">Upload Document  </label>
                                @endif
                                @if($empuprs->scren!='')
                                <a href="{{ asset('public/'.$empuprs->scren) }}" target="_blank" download  style="text-align: right;
                                   float: right;
                                   position: relative;
                                   top: 23px;
                                   right: 72px;"/><i class="fas fa-download"></i></a>
                                @endif
                                <input type="file" class="form-control-file" id="docu_nat_{{ $empuprs->id}}" name="scren_{{ $empuprs->id}}"  onchange="Filevalidation({{ $empuprs->id}})">
                             </div>
                             @if($trupload_id==0)
                             <span>*Document Size not more than 2 MB</span>
                             @endif
                          </div>
                       </div>
                       @endif	
                       @endforeach   
                       <div class="row form-group">
                          <div class="col-md-2">
                             <div class="input-group-btn">
                                <button class="btn btn-success" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button>
                             </div>
                          </div>
                       </div>
                       @endif
                       <?php }else{?>
                       <div class="row form-group">
                          <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-form-label">Published websites url/link   </label>
                                <input type="text" class="form-control input-border-bottom" id="url_1"  name="url[]"  >
                             </div>
                          </div>
                          <div class="col-md-4">
                             <div class="form-group">
                                <label for="other_doc_input_1">Upload Document  </label>
                                <input type="file" class="form-control-file" id="docu_nat_1" name="scren[]"  onchange="Filevalidation(1)"  >
                             </div>
                             <span>*Document Size not more than 2 MB</span>
                          </div>
                       </div>
                       <div class="row form-group">
                          <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-form-label">Published websites url/link   </label>
                                <input type="text" class="form-control input-border-bottom" id="url_2" name="url[]"  >
                             </div>
                          </div>
                          <div class="col-md-4">
                             <div class="form-group" style="margin-top: 30px">
                                <input type="file" class="form-control-file" id="docu_nat_2" name="scren[]"  onchange="Filevalidation(2)"  >
                             </div>
                          </div>
                          <div class="col-md-2">
                             <div class="input-group-btn" style="margin-top: 33px;">
                                <button class="btn btn-success" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button>
                             </div>
                          </div>
                       </div>
                       <?php } ?>
                       
                    </div>
                    <br>
                    <div class="row form-group">
                       <div class="col-md-12">
                          <button class="btn btn-primary" type="submit">Submit</button>
                       </div>
                    </div>
                 </form>
            </div>
        </div>
    </div>
	
</div>
<!-- /Page Content -->
@endsection
@section('script')
<script >
    var room = 3;
    function education_fields() {
    // alert(room);
    
       room++;
       var objTo = document.getElementById('education_fields')
       var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass"+room);
    var rdiv = 'removeclass'+room;
       divtest.innerHTML = '<div class="row form-group"><div class="col-md-6"><div class="form-group"><label class="col-form-label">Published websites url/link   </label><input type="text" class="form-control input-border-bottom" id="url_'+ room +'"  name="url[]"  ></div></div><div class="col-md-4" id="other_doc'+ room +'" style="display:none"><div class="form-group"><input type="text"  id="newdoc_'+ room +'" class="form-control input-border-bottom"   name="other_doc[]"></div></div><div class="col-md-4"><div class="form-group" style="margin-top:30px;"><input type="file" class="form-control-file" required id="docu_nat_'+ room +'" name="scren[]"  onchange="Filevalidation('+ room +')"></div></div><div class="col-md-2" style="margin-top:30px;"><div class="input-group-btn"><button class="btn btn-success" style="margin-right: 15px;margin-bottom:0;" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fas fa-minus"></i></button></div></div></div>';
       
       objTo.appendChild(divtest)
    }
      function remove_education_fields(rid) {
       $('.removeclass'+rid).remove();
      }
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
        
          function chngdepartment(empid){
         
       console.log(empid);
           $.ajax({
        type:'GET',
        url:'{{url('pis/getjobpostByIdlkkk')}}/'+empid,
           cache: false,
        success: function(response){
        console.log(response);
       
          document.getElementById("title").innerHTML = response;
            
        }
        });
      }
        function chngdepartmentdesp(empid){
       var soc=$( "#job_id option:selected" ).val();
      
           $.ajax({
        type:'GET',
        url:'{{url('pis/getjobpostByIdlkkkll')}}/'+empid+'/'+soc,
           cache: false,
        success: function(response){
            console.log(response);
         var obj = jQuery.parseJSON(response);
             var job_desc=obj.des_job;
              var department=obj.department;
             
            
                   $("#job_desc").val(job_desc);
                    $("#skil_set").val(obj.skil_set);
                      $("#department").val(department);
                     CKEDITOR.instances['job_desc'].setData(job_desc);
                    
                     $("#job_desc").attr("readonly", true);
                      $("#department").attr("readonly", true);
            
        }
        });
      }
          Filevalidation = (val) => { 
           const fi = document.getElementById('docu_nat_'+val); 
           // Check if any file is selected. 
           
           if (fi.files.length > 0) { 
               for (const i = 0; i <= fi.files.length - 1; i++) { 
     
                   const fsize = fi.files.item(i).size; 
                   const file = Math.round((fsize / 1024)); 
                   // The size of the file. 
                    if (file <= 2048) { 
                       
                   } else { 
                     alert( 
                         "File is too Big, please select a file up to 2mb");
                             $("#docu_nat_"+val).val('');  
                   } 
               } 
           } 
       } 
       
           Filevalidationnew = (val) => { 
           const fi = document.getElementById('docu_nat_new_'+val); 
           // Check if any file is selected. 
           
           if (fi.files.length > 0) { 
               for (const i = 0; i <= fi.files.length - 1; i++) { 
     
                   const fsize = fi.files.item(i).size; 
                   const file = Math.round((fsize / 1024)); 
                   // The size of the file. 
                    if (file <= 2048) { 
                       
                   } else { 
                     alert( 
                         "File is too Big, please select a file up to 2mb");
                             $("#docu_nat_new_"+val).val('');  
                   } 
               } 
           } 
       } 
 </script>
@endsection

