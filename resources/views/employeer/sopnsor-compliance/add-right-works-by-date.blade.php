@extends('employeer.include.app')
@section('title', 'Right to Work Checklist')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i> Add New Right to Work Checklist </h4>
               </div>
               @include('employeer.layout.message')
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form name="basicform" id="basicform" method="post" action="{{ url('add-right-works-by-date') }}" >
                              <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                              <div id="sf1" class="frm">
                                 <fieldset>
                                    <!-- <legend>Your Details</legend> -->
                                    <div class="row form-group">
                                       <div class="col-md-6">
                                          <label class="col-form-label">Name of Person</label>
                                          <select class="form-control"  id="employee_id" name="employee_id" required  onchange="checkemp(this.value);">
                                             <option value="">Applicant /Employee Name</option>
                                             @foreach($employee_rs as $employee)
                                             <option value="{{$employee->emp_code}}" >{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }} ({{$employee->emp_code}})</option>
                                             @endforeach
                                          </select>
                                       </div>
                                       <div class="col-md-6">
                                          <label class="col-form-label">Date of Check</label>
                                          <input type="date" class="form-control" id="date" placeholder="" name="date" required>
                                       </div>
                                       <div class="col-md-4">
                                          <label class="col-form-label">Work start time</label><br>
                                          <input type="date" class="form-control" placeholder="" name="start_date" id="start_date" required>
                                       </div>
                                    </div>
                                    <div class="clearfix" style="height: 10px;clear: both;"></div>
                                    <div class="form-group" style="margin-top: 30px">
                                       <div class="col-lg-10 col-lg-offset-2">
                                          <button class="btn btn-primary open1" type="submit">Next <span class="fa fa-arrow-right"></span></button> 
                                       </div>
                                    </div>
                                 </fieldset>
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
@endsection
@section('script')
<script type="text/javascript">
    jQuery().ready(function() {
      // validate form on keyup and submit
        var v = jQuery("#basicform").validate({
          rules: {
            
            email: {
              required: true,
              
              email: true,
              
            },
            phone: {
              required: true,
              
            },
            method: {
              required: true,
              
            },
     city: {
              required: true,
              
            },
             country: {
              required: true,
              
            },
             postcode: {
              required: true,
              
            },
    ca1: {
              required: true,
              
            }
          },
          errorElement: "span",
          errorClass: "help-inline-error",
        });
    
      // Binding next button on first step
      $(".open1").click(function() {
          if (v.form()) {
            $(".frm").hide("fast");
            $("#sf2").show("slow");
          }
        });
    
         $(".open2").click(function() {
         if (v.form()) {
         $(".frm").hide("fast");
        $("#sf3").show("slow");
         }
        });
          $(".open3").click(function() {
         if (v.form()) {
         $(".frm").hide("fast");
        $("#sf4").show("slow");
         }
        });
        
        $(".open4").click(function() {
        
        });
        
        $(".back2").click(function() {
          $(".frm").hide("fast");
          $("#sf1").show("slow");
        });
    
        $(".back3").click(function() {
          $(".frm").hide("fast");
          $("#sf2").show("slow");
        });
    
        $(".back4").click(function() {
          $(".frm").hide("fast");
          $("#sf3").show("slow");
        });
    
      });
          function checkemp(val){
            var empid=val;
            
                       $.ajax({
            type:'GET',
            url:'{{url('pis/getEmployeetaxempByIdnewemployee')}}/'+empid,
            cache: false,
            success: function(response){
            
                 var obj = jQuery.parseJSON(response);
                    console.log(obj[0]);
                  var emp_code=obj[0].emp_code;
             
                      $("#emp_id").val(emp_code);
                    
                        $("#emp_id").attr("readonly", true);
                
                         
                         if(obj[0].emp_doj!='1970-01-01'){
                         $("#start_date").val(obj[0].emp_doj);
                          var input = document.getElementById("date");
                            //input.setAttribute("max", obj[0].emp_doj);
                         }
                         $("#start_date").attr("readonly", true);
                            if(obj[0].emp_doj!='1970-01-01'){
                         $("#start_date").val(obj[0].emp_doj);
                         } 
                    
                            if(obj[0].visa_review_date!='1970-01-01'){
                         $("#list_rightb_date").val(obj[0].visa_review_date);
                         } 
                             
                          
                 
            }
            });
                 $.ajax({
            type:'GET',
            url:'<?=env("BASE_URL");?>pis/getEmployeedreportfileById/'+empid,
            cache: false,
            success: function(response){
                
            
                document.getElementById("scan_f").innerHTML = response;
                    document.getElementById("scan_s").innerHTML = response;
                        document.getElementById("scan_r").innerHTML = response;
                            document.getElementById("evidence").innerHTML = response;
            }
            });
        }
        
        
        function checkscsnf(val){
        
        var emp_id=$("#emp_id").val();
            $.ajax({
            type:'GET',
            url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
            cache: false,
            success: function(response){
                var gg="<?=env("BASE_URL");?>public/"+response;
        
          
            $("#imgeid").attr("src",gg);
            $("#scan_f_img").val(response);  	   
            }
            });
        
    }
    function checkscsns(val){
        
        var emp_id=$("#emp_id").val();
            $.ajax({
            type:'GET',
            url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
            cache: false,
            success: function(response){
                var gg="<?=env("BASE_URL");?>public/"+response;
        
          
            $("#imgeids").attr("src",gg);
                    $("#scan_s_img").val(response);  
            }
            });
        
    }
    function checkscsnr(val){
        
        var emp_id=$("#emp_id").val();
            $.ajax({
            type:'GET',
            url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
            cache: false,
            success: function(response){
                var gg="<?=env("BASE_URL");?>public/"+response;
        
          
            $("#imgeidsj").attr("src",gg);
              $("#scan_r_img").val(response);
            
                   
            }
            });
        
    }
    </script>
@endsection