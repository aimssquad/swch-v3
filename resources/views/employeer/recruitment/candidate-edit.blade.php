@extends('employeer.include.app')
@section('title', 'Job Applied')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Job Applied</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Job Applied</li>
				</ul>
			</div>
            @include('employeer.layout.message')
		</div>
	</div>
	<!-- /Page Header -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{url('org-recruitment/edit-candidate')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input class="form-control" id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
                    <input class="form-control" id="id" type="hidden"  name="job_id" class="form-control input-border-bottom" required="" value="<?php   echo $job->job_id;  ?>" >
                    <div class="row form-group">
                       <div class="col-md-4">
                          <div class=" form-group current-stage">
                            <label for="name" class="col-form-label">Job Title</label>
                            <input class="form-control" type="text" name="" value="{{$job->job_title}}" readonly>
                             {{-- <h5>Job Title:<span>{{$job->job_title}}</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Candidate Name</label>
                            <input class="form-control" type="text" name="" value="{{$job->name}}" readonly>
                             {{-- <h5>Candidate Name:<span>{{$job->name}}</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Candidate Address:</label>
                            <input class="form-control" type="text" name="" value="{{$job->location}} {{$job->zip}}" readonly>
                             {{-- <h5>Candidate Address:<span>{{$job->location}} @if(!empty($job->zip)) , {{$job->zip}} @endif</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Email::</label>
                            <input class="form-control" type="email" name="" value="{{$job->email}}" readonly>
                             {{-- <h5>Email:<span>{{$job->email}}</span></h5> --}}
                          </div>
                       </div>
                       @if($job->dob!='')
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Date of Birth:</label>
                            <input class="form-control" type="date" name="" value="{{ date('d/m/Y',strtotime($job->dob))}}" readonly>
                             {{-- <h5>Date Of Birth:<span>{{ date('d/m/Y',strtotime($job->dob))}}</span></h5> --}}
                          </div>
                       </div>
                       @endif
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Contact Number:</label>
                            <input class="form-control" type="text" name="" value="{{$job->phone}}" readonly>
                             {{-- <h5>Contact Number:<span>+{{$job->phone}}</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Gender:</label>
                            <input class="form-control" type="text" name="" value="{{$job->gender}}" readonly>
                             {{-- <h5>Gender:<span>{{$job->gender}}</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Total Year of Experience:</label>
                            <input class="form-control" type="text" name="" value="{{$job->exp}} Years {{$job->exp_month}} Months" readonly>
                             {{-- <h5>Total Year of Experience:<span>{{$job->exp}} Years {{$job->exp_month}} Months</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Education Qualification:</label>
                            <input class="form-control" type="text" name="" value="{{$job->edu}}" readonly>
                             {{-- <h5>Education Qualification:<span>{{$job->edu}}</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Skill Set:</label>
                            <input class="form-control" type="text" name="" value="{{$job->skill}}" readonly>
                             {{-- <h5>Skill Set:<span>{{$job->skill}}</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Most Recent Employer:</label>
                            <input class="form-control" type="text" name="" value="{{$job->cur_or}}" readonly>
                             {{-- <h5>Most Recent Employer:<span>{{$job->cur_or}}</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Most Recent Job Title:</label>
                            <input class="form-control" type="text" name="" value="{{$job->cur_deg}}" readonly>
                             {{-- <h5>Most Recent Job Title:<span>{{$job->cur_deg}}</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class="app-form-text">
                            @if($job->exp_sal!='')
                            <label for="name" class="col-form-label">Expected Salary:</label>
                            <input class="form-control" type="text" name="" value="{{ number_format($job->exp_sal,2)}}" readonly>
                            @endif
                             {{-- <h5>Expected Salary (GBP):<span> @if($job->exp_sal!='') {{ number_format($job->exp_sal,2)}}  @endif</span></h5> --}}
                          </div>
                       </div>
                       <div class="col-md-4">
                          <div class=" form-group current-stage">
                            <label for="name" class="col-form-label">Application Date:</label>
                                <input class="form-control" type="date" name="application_date" id="application_date" value="{{date('Y-m-d',strtotime($job->date))}}" class="form-control">	
                          </div>
                       </div>
                    </div>
                    <!--------------------  -->
                    <div class="row form-group" style="padding: 3px 0 15px;">
                       <div class="col-md-4">
                          <div class=" form-group current-stage">
                             <label  >Current Stage of Recruitment</label>
                             <select class="form-control" required="" name="status"  style="margin-top: 10px;" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                }
                                
                                ?>
                                >
                                <option value=""><?php  if($job->status!=''){ echo $job->status;  } ?></option>
                                <option value="Short listed"  <?php  if($job->status!=''){  if($job->status=='Short listed'){ echo 'selected';} } ?> >Short listed</option>
                                <option value="Rejected" <?php  if($job->status!=''){  if($job->status=='Rejected'){ echo 'selected';} } ?>>Rejected</option>
                             </select>
                          </div>
                       </div>
                       @if($job->recruited!='')
                       <div class="col-md-6">
                          <div class="app-form-text">
                            <label for="name" class="col-form-label">Are  there suitable settled workers available to be recruited for this role ?::</label>
                            <input class="form-control" type="text" name="" value="{{ $job->recruited }} @if($job->recruited=='Yes')( {{ $job->other }} ) @endif" readonly>
                             {{-- <h5>Are  there suitable settled workers available to be recruited for this role ?:<span>{{ $job->recruited }} @if($job->recruited=='Yes')( {{ $job->other }} ) @endif</span></h5> --}}
                          </div>
                       </div>
                       @endif
                       <div class="col-md-4">
                          <div class="form-group current-stage">
                             <label class="col-form-label">How the candidate applied ? </label>
                             <select class="select" required="" name="apply"  style="margin-top: 10px;" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                }
                                
                                ?>
                                >
                                <?php  if($job->apply==''){?>	   
                                <option value="">Online</option>
                                <?php } ?>
                                <option value="Internal Job"  <?php  if($job->apply!=''){  if($job->apply=='Internal Job '){ echo 'selected';} } ?> >Internal Job</option>
                                <option value="External Job" <?php  if($job->apply!=''){  if($job->apply=='External Job'){ echo 'selected';} } ?>>External Job</option>
                             </select>
                          </div>
                       </div>
                       <div class="col-md-4" style="margin-top:35px;">
                          <button class="btn btn-primary download" type="button" style=""><a href="{{asset($job->resume)}}" download class="text-white">Download Resume</a></button>
                       </div>
                       <div class="col-md-4">
                          <?php  if($job->cover_letter!=''){   ?>
                          <button class="btn btn-primary download" type="button" style="    margin: 11px 0 0;"><a href="{{asset('public/'.$job->cover_letter)}}" download>Download Cover Letter</a></button>
                          <?php
                             }
                             
                             ?>
                       </div>
                    </div>
                    <div class="row form-group" style="    padding: 9px 0 15px;">
                       <div class="col-md-6">
                          <div class=" form-group">
                             <label class="col-form-label">Remarks</label>	
                             <input class="form-control" type="text" class="form-control" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                }
                                
                                ?> value="<?php  if($job->remarks!=''){  echo $job->remarks; } ?>"  name="remarks">
                             <!--<label for="inputFloatingLabel-remarks" class="placeholder remarks"></label>-->
                          </div>
                       </div>
                       <div class="col-md-6">
                          <div class=" form-group">
                             <label class="col-form-label">Date</label>	
                             <input class="form-control" type="date" <?php  if($job->status!=''){  if($job->status!='Application Received'){ ?> disabled	 <?php }
                                }
                                
                                ?> class="form-control" required=""  value="<?php  if( isset($job_details ) && !empty($job_details) ){  echo date('Y-m-d', strtotime($job_details->date)); }?>"  name="date"  >
                             <!--<label for="inputFloatingLabel-date" class="placeholder remarks">Date</label>-->
                          </div>
                       </div>
                    </div>
                    <div class="row form-group" style="margin-top: 25px;background:none">
                       <?php  if($job->status!=''){  
                          if($job->status=='Application Received'){ ?>
                       <div class="col-md-12">
                          <button class="btn btn-primary sub" type="submit">Submit</button>
                       </div>
                       <?php }
                          else{
                          ?>
                       <!-- <div class="col-md-12">
                          <button class="btn btn-default sub" type="button" onclick="goBack()">Back</button>
                          </div> -->
                       <div class="col-md-12">
                          <button class="btn btn-primary sub" type="submit">Submit</button>
                       </div>
                       <?php
                          }
                          }
                          ?>
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
 </script>
 <script>
    function goBack() {
      window.history.back();
    }
 </script>
@endsection

