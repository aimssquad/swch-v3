<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
      <title>SWCH</title>
      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
      <!-- Fonts and icons -->
      <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
      <script>
         WebFont.load({
         	google: {"families":["Lato:300,400,700,900"]},
         	custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/css/fonts.min.css')}}']},
         	active: function() {
         		sessionStorage.fonts = true;
         	}
         });
      </script>
      <!-- CSS Files -->
      <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">
      <!-- CSS Just for demo purpose, don't include it in your project -->
      <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
   </head>
   <body>
      <div class="wrapper">
         @include('settings.include.header')
         <!-- Sidebar -->
         @include('settings.include.sidebar')
         <!-- End Sidebar -->
         <div class="main-panel">
            <div class="page-header">
               <!-- <h4 class="page-title">HCM Master</h4> -->
               <ul class="breadcrumbs">
                  <li class="nav-home">
                     <a href="{{url('settingdashboard')}}">
                     Home
                     </a>
                  </li>
                  <li class="separator">
                     /
                  </li>
                  <li class="nav-item">
                     <a href="#">HCM Master</a>
                  </li>
                  <li class="separator">
                     /
                  </li>
                  <li class="nav-item">
                     <a href="{{url('settings/vw-type')}}">class</a>
                  </li>
                  <li class="separator">
                     /
                  </li>
                  <li class="nav-item active">
                     <a href="#"> New Mode Employee Type</a>
                  </li>
               </ul>
            </div>
            <div class="content">
               <div class="page-inner">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card custom-card">
                           <div class="card-header">
                              <h4 class="card-title"><i class="far fa-building"></i> Company Bank Add</h4>
                           </div>
                           <div class="card-body" style="">
                              <form action="{{url('settings/update-emp-bank-details')}}" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="bankid" value="{{ ((isset($bankdetails) && !empty($bankdetails))?$bankdetails[0]['id']:'')}}">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Enter Bank Name <span>(*)</span></label>
                                    <?php //print_r($MastersbankName); exit; 
                                    ?>
                                    <select name="bank_name" id="bank_name" class="form-control" required>
                                        @foreach($MastersbankName as $value):
                                        <option value="{{ $value->id }}" <?php if (!empty($bankdetails[0]['id'])) {
                                                                                if ($bankdetails[0]['bank_name'] == $value->id) {
                                                                                    echo "selected";
                                                                                }
                                                                            } ?>>
                                            {{ $value->master_bank_name }}
                                        </option>
                                        @endforeach
                                    </select>


                                </div>
                                <div class="col-md-4">
                                    <label class=" form-control-label">Enter Branch Name <span>(*)</span></label>
                                    <input type="text" id="branch_name" required required name="branch_name" class="form-control" value="{{ (isset($bankdetails[0]['branch_name']) && !empty($bankdetails[0]['branch_name']))?$bankdetails[0]['branch_name']:old('branch_name')}}">
                                    @if ($errors->has('branch_name'))
                                    <div class="error" style="color:red;">{{ $errors->first('branch_name') }}</div>
                                    @endif
                                </div>
                           

                          
                                <div class="col-md-4">
                                    <label class=" form-control-label">IFSC Code <span>(*)</span></label>
                                    <input type="text"   required id="ifsc_code" name="ifsc_code" class="form-control" value="{{ (isset($bankdetails[0]['ifsc_code']) && !empty($bankdetails[0]['ifsc_code']))?$bankdetails[0]['ifsc_code']:old('ifsc_code')}}">


                                    @if ($errors->has('ifsc_code'))
                                    <div class="error" style="color:red;">{{ $errors->first('ifsc_code') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class=" form-control-label">Enter MICR Code </label>
                                    <input type="text"   id="swift_code" name="swift_code" class="form-control" value="{{ (isset($bankdetails[0]['swift_code']) && !empty($bankdetails[0]['swift_code']))?$bankdetails[0]['swift_code']:old('swift_code')}}">
                                    @if ($errors->has('swift_code'))
                                    <div class="error" style="color:red;">{{ $errors->first('swift_code') }}</div>
                                    @endif
                                </div>
                           
                                
                            <div class="col-md-4">
                                    <label class=" form-control-label">Enter Account number <span>(*)</span></label>
                                    <select class="form-control" name="bank_status">
                                           
                                            <option value="active" <?php if($bankdetails['0']['bank_status']=='active'){?> selected="selected"<?php }?>>Active</option>
                                            <option value="inactive" <?php if($bankdetails['0']['bank_status']=='inactive'){?> selected="selected"<?php }?>>InActive</option>
                                            </select>
                                    @if ($errors->has('bank_status'))
                                    <div class="error" style="color:red;">{{ $errors->first('bank_status') }}</div>
                                    @endif
                                </div>
                            </div>

                                 <div class="row form-group">
                                    <div class="col-md-2"><button type="submit" class="btn btn-default">Submit</button></div>
                                 </div>
                           </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @include('settings.include.footer')
      </div>
      </div>
      <!--   Core JS Files   -->
      <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
      <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
      <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
      <!-- jQuery UI -->
      <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
      <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
      <!-- jQuery Scrollbar -->
      <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
      <!-- Datatables -->
      <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
      <!-- Atlantis JS -->
      <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
      <!-- Atlantis DEMO methods, don't include it in your project! -->
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
      </script>
   </body>
</html>