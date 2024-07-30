@extends('hrsupport.include.app')
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="{{ route('home') }}">
            Home
            </a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="{{ route('hrsupport.dashboard') }}">Hr Support</a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="#">Hr Support File List</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                <div class="card">

                  <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-briefcase"></i> Hr Support File List
                   @include('layout.message')
                </div>

                    <div class="card-body">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                       <th>Sl.No.</th>
                                       <th>Type</th>
                                       <th>Title</th>
                                       <th>Description</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach($data as $datas)
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $datas->type->type }}</td>
                                        <td>{{ $datas->title}}</td>
                                        <td>
                                            <a href="{{ isset($datas->id) ? route('supportfile.details', ['id' => $datas->id]) : '#' }}"><button class="btn btn-info btn-sm">View</button></a>
                                            <a data-toggle="tooltip" data-placement="bottom" title="View Description" class="view-support-file-view ml-3" data-id="{{ $datas->id }}">
                                                <button class="btn btn-info btn-sm">View Description</button>
                                            </a>

                                            {{-- <a href=""><button class="btn btn-info btn-sm">Download Pdf</button></a>
                                            <a href=""><button class="btn btn-info btn-sm">Download Doc</button></a> --}}
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
   </div>
    <!-- View Modal -->
    <div class="modal fade" id="viewSupportFileModalView" tabindex="-1" role="dialog" aria-labelledby="viewSupportFileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewSupportFileModalLabel">View HR Support Description</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Title:</strong> <span id="view-support-file-title"></span></p>
                    <p><strong>View Description:</strong></p>
                    <p id="view-support-file-description-small"></p>
                </div>
            </div>
        </div>
    </div>

   @endsection
    @section('js')

    <script>
        $(document).ready(function () {
            $('.view-support-file').click(function () {
                var id = $(this).data('id');

                // AJAX request to fetch HR Support File Type data by ID
                $.ajax({
                    url: '/hrms/superadmin/get-hr-support-file-type/' + id,
                    type: 'GET',
                    success: function (response) {
                        // Update modal content with fetched data
                        $('#view-support-file-type').text(response.type);
                        $('#view-support-file-description').html(response.description); // Use .html() instead of .text()

                        // Show the modal
                        $('#viewSupportFileModal').modal('show');
                    }
                });
            });

            // view description code

            $('.view-support-file-view').click(function () {
                var id = $(this).data('id');

                // AJAX request to fetch HR Support File Type data by ID
                $.ajax({
                    url: '/hrms/superadmin/get-hr-support-file/' + id,
                    type: 'GET',
                    success: function (response) {
                        // Update modal content with fetched data
                        $('#view-support-file-title').text(response.title);
                        $('#view-support-file-description-small').html(response.small_description); // Use .html() instead of .text()
                        // Show the modal
                        $('#viewSupportFileModalView').modal('show');
                    }
                });
            });

            $('.view-support-file-view-long').click(function () {
                var id = $(this).data('id');

                // AJAX request to fetch HR Support File Type data by ID
                $.ajax({
                    url: '/hrms/superadmin/get-hr-support-file/' + id,
                    type: 'GET',
                    success: function (response) {
                        // Update modal content with fetched data
                        $('#view-support-file-title-long').text(response.title);
                        $('#view-support-file-description-long').html(response.description); // Use .html() instead of .text()
                        // Show the modal
                        $('#viewSupportFileModalDescription').modal('show');
                    }
                });
            });
        });
</script>

    @endsection
