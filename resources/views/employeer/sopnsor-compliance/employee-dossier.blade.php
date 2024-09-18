@extends('employeer.include.app')
@section('title', ' Sponsor Management Dossier')
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
            <h3 class="page-title">  Sponsor Management Dossier</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-dashboarddetails')}}">Sponsor Compliance Dashboard</a></li>
               <li class="breadcrumb-item active"> Sponsor Management Dossier</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @include('employeer.layout.message')
   <div class="row">
      <div class="col-md-12">
         <div class="table-responsive">
            <table class="table table-striped custom-table datatable" id="employeeTable">
               <thead>
                  <th>Sl. no.</th>
                  <th>Document Title</th>
                  <th>Link</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>1</td>
                     <td>Sponsorship: guidance for employers and educators</td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://www.gov.uk/government/collections/sponsorship-information-for-employers-and-educators">https://www.gov.uk/government/collections/sponsorship-information-for-employers-and-educators</a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://www.gov.uk/government/collections/sponsorship-information-for-employers-and-educators" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>2</td>
                     <td>Sponsor guidance appendix A: supporting documents for sponsor applications</td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://www.gov.uk/government/publications/supporting-documents-for-sponsor-applications-appendix-a">https://www.gov.uk/government/publications/supporting-documents-for-sponsor-applications-appendix-a
                        </a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://www.gov.uk/government/publications/supporting-documents-for-sponsor-applications-appendix-a" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>3</td>
                     <td>Sponsor guidance appendix D: keeping records for sponsorship
                     </td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://www.gov.uk/government/publications/keep-records-for-sponsorship-appendix-d">https://www.gov.uk/government/publications/keep-records-for-sponsorship-appendix-d
                        </a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://www.gov.uk/government/publications/keep-records-for-sponsorship-appendix-d" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>4</td>
                     <td>prevent illegal working.
                     </td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://www.gov.uk/government/publications/preventing-illegal-working">https://www.gov.uk/government/publications/preventing-illegal-working
                        </a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://www.gov.uk/government/publications/preventing-illegal-working" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>5</td>
                     <td>right to work checks 
                     </td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://www.gov.uk/government/publications/right-to-work-checks-employers-guide">https://www.gov.uk/government/publications/right-to-work-checks-employers-guide
                        </a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://www.gov.uk/government/publications/right-to-work-checks-employers-guide" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>6</td>
                     <td>Priority change of circumstances for sponsors
                     </td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://www.gov.uk/government/publications/priority-change-of-circumstances-for-sponsors">https://www.gov.uk/government/publications/priority-change-of-circumstances-for-sponsors
                        </a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://www.gov.uk/government/publications/priority-change-of-circumstances-for-sponsors" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>7</td>
                     <td>Introduction to the sponsorship management system: SMS guide 1
                     </td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://www.gov.uk/government/publications/use-the-sponsorship-management-system-sms-user-manual">https://www.gov.uk/government/publications/use-the-sponsorship-management-system-sms-user-manual
                        </a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://www.gov.uk/government/publications/use-the-sponsorship-management-system-sms-user-manual" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>8</td>
                     <td>Manage your sponsorship licence: SMS guide 2
                     </td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/939148/2._Managing_your_licence_-_PBS820.pdf">https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/939148/2._Managing_your_licence_-_PBS820.pdf
                        </a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/939148/2._Managing_your_licence_-_PBS820.pdf" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>9</td>
                     <td>Applications, renewals and services: SMS guide 3
                     </td>
                     <td style="text-align:left" id="myInput">
                        <a target="_blank" href="https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/939200/3._Applications__renewals_and_services_-_PBS820.pdf">https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/939200/3._Applications__renewals_and_services_-_PBS820.pdf
                        </a>
                        <button type="button" class="btn btn-default btn-copy js-tooltip js-copy" data-toggle="tooltip" data-placement="bottom" data-copy="https://assets.publishing.service.gov.uk/government/uploads/system/uploads/attachment_data/file/939200/3._Applications__renewals_and_services_-_PBS820.pdf" title="Copy Link">
                           <!-- icon from google's material design library -->
                           <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="19" height="19" viewBox="0 0 24 24">
                              <path d="M17,9H7V7H17M17,13H7V11H17M14,17H7V15H14M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z" />
                           </svg>
                        </button>
                     </td>
                  </tr>
                  <tr>
                     <td>10</td>
                     <td>Right to Work Checklist
                     </td>
                     <td style="text-align:left" id="myInput">Hardcopy File</td>
                  </tr>
                  <tr>
                     <td>11</td>
                     <td>Paper and electronic files of all migrant workers 
                     </td>
                     <td style="text-align:left" id="myInput">Hardcopy File</td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')
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
   
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
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