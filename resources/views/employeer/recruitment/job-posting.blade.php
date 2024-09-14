@extends('employeer.include.app')
@section('title', 'Job Posting')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')
@php
function my_simple_crypt( $string, $action = 'encrypt' ) {
// you may change these values to your own
$secret_key = 'bopt_saltlake_kolkata_secret_key';
$secret_iv = 'bopt_saltlake_kolkata_secret_iv';
$output = false;
$encrypt_method = "AES-256-CBC";
$key = hash( 'sha256', $secret_key );
$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
if( $action == 'encrypt' ) {
$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
}
else if( $action == 'decrypt' ){
$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
}
return $output;
}
@endphp
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Job Posting</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Job Posting</li>
            </ul>
         </div>
         <div class="col-auto float-end ms-auto">
            @if($user_type == 'employee')
            @foreach($sidebarItems as $value)
            @if($value['rights'] == 'Add' && $value['module_name'] == 3 && $value['menu'] == 44)
            <a href="{{ url('org-recruitment/add-job-post') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Job Posting</a>
            @endif
            @endforeach
            @elseif($user_type == 'employer')
            <a href="{{ url('org-recruitment/add-job-post') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Job Posting</a>
            @endif
            {{-- 
            <div class="view-icons">
               <a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
               <a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
            </div>
            --}}
         </div>
         @include('employeer.layout.message')
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                   <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;
               </h4>
               <div>
                   <!-- Excel Link -->
                   <a href="path_to_excel_export" class="btn btn-success btn-sm">
                       <i class="fas fa-file-excel"></i> Export to Excel
                   </a>
                   
                   <!-- PDF Link -->
                   <a href="path_to_pdf_export" class="btn btn-info btn-sm">
                       <i class="fas fa-file-pdf"></i> Export to PDF
                   </a>
               </div>
           </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped custom-table datatable" id="employeeTable">
                     <thead>
                        <tr>
                           <th>Sl. No.</th>
                           <th>Job Code</th>
                           <th>Job Title</th>
                           <th>Job Link</th>
                           <th>Vacancy</th>
                           <th>Job Location</th>
                           <th>Job Posted Date</th>
                           <th>Closing Date</th>
                           <th>Email</th>
                           <th>Phone No.</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($company_job_rs as $recruitment_job)
                        <tr>
                           <td>{{$loop->iteration}}</td>
                           <td>{{ $recruitment_job->soc }}</td>
                           <td>{{ $recruitment_job->title }}</td>
                           <td style="text-align:center" id="myInput">
                              @if( $recruitment_job->post_date<=date('Y-m-d') && $recruitment_job->clos_date>=date('Y-m-d'))
                              <a target="_blank" href="{{ $recruitment_job->job_link }}">
                              @endif {{ $recruitment_job->job_link }}</a>
                              @if( $recruitment_job->post_date<=date('Y-m-d') && $recruitment_job->clos_date>=date('Y-m-d'))
                              <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="{{ $recruitment_job->job_link }}" title="Copy Link">
                                 <!-- icon from google's material design library -->
                                 <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                                 </svg>
                              </button>
                              @endif
                           </td>
                           <td>{{ $recruitment_job->no_vac }}</td>
                           <td>{{ $recruitment_job->job_loc }}</td>
                           <td>{{ date('d/m/Y',strtotime($recruitment_job->post_date)) }}</td>
                           <td>{{ date('d/m/Y',strtotime($recruitment_job->clos_date)) }}</td>
                           <td>{{ $recruitment_job->email }}</td>
                           <td>{{ $recruitment_job->con_num }}</td>
                           <td>{{ $recruitment_job->status }}</td>
                           <td class="text-end">
                              <div class="dropdown dropdown-action">
                                 <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="material-icons">more_vert</i>
                                 </a>
                                 <div class="dropdown-menu dropdown-menu-right">
                                    @if($user_type == 'employee')
                                    @foreach($sidebarItems as $value)
                                    @if($value['rights'] == 'Add' && $value['module_name'] == 2 && $value['menu'] == 35)
                                    <a class="dropdown-item" href="{{url('recruitment/add-job-post/')}}?id={{$recruitment_job->id}}">
                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                    </a>
                                    @endif
                                    @endforeach
                                    @elseif($user_type == 'employer')
                                    <a class="dropdown-item" href="{{url('recruitment/add-job-post/')}}?id={{$recruitment_job->id}}">
                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                    </a>
                                    @endif
                                 </div>
                              </div>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')
<!-- Include jQuery and DataTables JS library -->
<script>
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
      
      $('#allval').click(function(event) {  
      
          if(this.checked) {
              //alert("test");
              // Iterate each checkbox
              $(':checkbox').each(function() {
                  this.checked = true;                        
              });
          } else {
              $(':checkbox').each(function() {
                  this.checked = false;                       
              });
          }
      });
</script>
<script>
   function confirmDelete(url) {
       if (confirm("Are you sure you want to delete this record?")) {
           window.location.href = url;
       }
   }

   function copyToClipboard(text, el) {
  var copyTest = document.queryCommandSupported('copy');
  var elOriginalText = el.attr('data-original-title');

  if (copyTest === true) {
    var copyTextArea = document.createElement("textarea");
    copyTextArea.value = text;
    document.body.appendChild(copyTextArea);
    copyTextArea.select();
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'Copied!' : 'Whoops, not copied!';
      el.attr('data-original-title', msg).tooltip('show');
    } catch (err) {
      console.log('Oops, unable to copy');
    }
    document.body.removeChild(copyTextArea);
    el.attr('data-original-title', elOriginalText);
  } else {
    // Fallback if browser doesn't support .execCommand('copy')
    window.prompt("Copy to clipboard: Ctrl+C or Command+C, Enter", text);
  }
}

$(document).ready(function() {
  // Initialize
  // ---------------------------------------------------------------------

  // Tooltips
  // Requires Bootstrap 3 for functionality
  $('.js-tooltip').tooltip();

  // Copy to clipboard
  // Grab any text in the attribute 'data-copy' and pass it to the 
  // copy function
  $('.js-copy').click(function() {
    var text = $(this).attr('data-copy');
    var el = $(this);
    copyToClipboard(text, el);
  });
});
</script>
@endsection