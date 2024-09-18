@extends('employeer.include.app')
@section('title', 'Generate Attendance')
@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Generate Attendance</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('attendance-management/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Generate Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    @include('employeer.layout.message')
                    <div class="card-body">
                    <form  method="post" action="{{ url('attendance-management/generate-data') }}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <div class=" form-group">
                                <label for="department" class="col-form-label"> Select Department</label>
                                <select class="select" id="department" name="department" required="" onchange="chngdepartment(this.value);">
                                    <option value="">&nbsp;</option>
                                    @foreach($departs as $dept)
                                    <option value='{{ $dept->id }}'  >{{ $dept->department_name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="designation" class="col-form-label"> Select Designation </label>
                                <select class="select" id="designation"  name="designation" required="" onchange="chngdepartmentdesign(this.value);">
                                    <option value="">&nbsp;</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class=" form-group">		
                                <label for="employee_code" class="col-form-label">Employee Code</label>
                                <select id="employee_code" type="text" class="select"  required="" name="employee_code"  style="">
                                </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class=" form-group">
                                <label for="start_date"  class="col-form-label">Form Date</label>
                                <input id="start_date"  type="date"  name="start_date" class="form-control input-border-bottom" required="" style="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class=" form-group">
                                <label for="inputFloatingLabel-select-date"  class="col-form-label">To Date</label>
                                <input id="end_date"  type="date" name="end_date" class="form-control input-border-bottom" required="" style="" onchange="chngshift(this.value);">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="designation" class="col-form-label"> Select Shift </label>
                                <select class="select" id="shift_code"  name="shift_code" required="" >
                                    <option value="">&nbsp;</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <a href="#">	
                                <button class="btn btn-primary" type="submit" style="">Go</button></a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                            <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Generate Attendance
                        </h4>
                        <div class="row">
                            <div class="col-auto">
                                <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="data" id="data">
                                    <input type="hidden" name="headings" id="headings">
                                    <input type="hidden" name="filename" id="filename">
                                    {{-- put the value - that is your file name --}}
                                    <input type="hidden" id="filenameInput" value="Generate-Attendence">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-file-excel"></i> Export to Excel
                                    </button>
                                </form>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                                  @csrf
                                  <input type="hidden" name="data" id="pdfData">
                                  <input type="hidden" name="headings" id="pdfHeadings">
                                  <input type="hidden" name="filename" id="pdfFilename">
                                  <button type="submit" class="btn btn-info btn-sm">
                                      <i class="fas fa-file-pdf"></i> Export to PDF
                                  </button>
                              </form>
                            </div>
                        </div>
                     </div>
                    <div class="card-body">
                    <form method="post" action="{{ url('attendance-management/save-generate-attandance') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Date</th>
                                    <th>Clock In</th>
                                    <th>Clock In Location</th>
                                    <th>Clock Out</th>
                                    <th>Clock Out Location</th>
                                    <th>Duty Hours</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($result) && $result!=''  ){
                                                                                    print_r($result); 
                                    }?>
                                </tbody>
                                <tfoot>
                                <?php
                                    if(isset($result) && $result!=''  ){
                                                                                
                                    ?>
                                <tr>
                                    <td colspan="11"><button style="float:right" type="submit" class="btn btn-primary">Save</button></td>
                                </tr>
                                <?php }
                                    ?>
                                </tfoot>
                            </table>
                            </table>
                    </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')                  
    <script >
        function chngdepartmentdesign(val){
            var empid=val;
            $.ajax({
                type:'GET',
                url:'{{url('pis/getEmployeedailyattandeaneshightByIdnewr')}}/'+empid,
                        cache: false,
                success: function(response){
                    console.log(response);
                    document.getElementById("employee_code").innerHTML = response;
                }
            });
        }
        function chngdepartment(empid){
            $.ajax({
                type:'GET',
                url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
                        cache: false,
                success: function(response){ 
                    document.getElementById("designation").innerHTML = response;
                }
            });
        }
        
        function chngshift(empid){
            var emid="<?= $Roledata->reg;?>";  
            var department=document.getElementById("department").value;  
            var  designation=document.getElementById("designation").value;  
            var  employee_code=document.getElementById("employee_code").value; 
            var  start_date=document.getElementById("start_date").value;  
            var  end_date=document.getElementById("end_date").value;  
            $.ajax({
                type:'GET',
                url:'{{url('pis/getEmployeedesigByshiftIdcode')}}/'+department+'/'+designation+'/'+employee_code+'/'+start_date+'/'+end_date+'/'+emid,
                        cache: false,
                success: function(response){
                    console.log(response);
                    
                    document.getElementById("shift_code").innerHTML = response;
                }
            });
        }
        
        function setDutyHours(val){
            var timein="time_in"+val;
            var timeout="time_out"+val;
            var duty_hours="duty_hours"+val;
            
            var timein_val=$.base64.encode($('#'+timein).val());
            var timeout_val=$.base64.encode($('#'+timeout).val());
            // console.log(timein);
            // console.log($('#'+timein).val());
            // console.log($('#'+timeout).val());
            $.ajax({
                type:'GET',
                url:'{{url('pis/gettimemintuesnew')}}/'+timein_val+'/'+timeout_val,
                        cache: false,
                success: function(response){
                    const obj = JSON.parse(response);
                    console.log(obj.hour);
                    var dh=obj.hour+':'+obj.min;
                    $('#'+duty_hours).val(dh)
                    
                }
            });
        }
        
    </script>
@endsection