@include('admin.include.head')
<body>
   <div class="wrapper">
      @include('admin.include.header')
      <!-- Sidebar -->
      @include('admin.include.sidebar')
      <!-- End Sidebar -->
      <div class="main-panel">
         <div class="page-header">
            <!-- <h4 class="page-title">Organisation</h4> -->
         </div>
         <div class="content">
            <div class="page-inner">
               <div class="row">
                  <div class="col-md-12">
                     <div class="card custom-card">
                        <div class="card-header">
                           <h4 class="card-title"><i class="far fa-user"></i> Hr Support Files <span><a data-toggle="tooltip" data-placement="bottom" title="Add Hr Support File" href="{{url('superadmin/add-hr-support-file')}}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
                           @include('layout/message')
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table id="basic-datatables" class="display table table-striped table-hover" >
                                 <thead>
                                    <tr>
                                       <th>Sl.No.</th>
                                       <th>Type</th>
                                       <th>Title</th>
                                       <th>Type &nbsp &nbsp|&nbsp &nbspShort Description&nbsp &nbsp|&nbsp &nbsp Long Description</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php $i = 1;?>
                                        @foreach($data as $datas)
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $datas->type->type }}</td>
                                        <td>{{ $datas->title}}</td>
                                        <td>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Type Description" class="view-support-file" data-id="{{ $datas->type->id }}">
                                                <img style="width: 14px;" src="{{ asset('assets/img/view.png') }}">
                                            </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <a data-toggle="tooltip" data-placement="bottom" title="View Short Description" class="view-support-file-view-long ml-3" data-id="{{ $datas->id }}">
                                                <img style="width: 14px;" src="{{ asset('assets/img/view.png') }}">
                                            </a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <a data-toggle="tooltip" data-placement="bottom" title="View Long Description" class="view-support-file-view ml-3" data-id="{{ $datas->id }}">
                                                <img style="width: 14px;" src="{{ asset('assets/img/view.png') }}">
                                            </a>
                                          
                                        </td>
                                        <td>{{ $datas->status }}</td>
                                        <td class="icon">
                                            <a data-toggle="tooltip" data-placement="bottom"  title="Edit" href="{{url('superadmin/edit-hr-support-file/'.$datas->id)}}"><img  style="width: 14px;" src="{{ asset('assets/img/edit.png')}}"></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a data-toggle="tooltip" data-placement="bottom"  title="Delete" href="{{ route('delete-hr-support-file', ['id' => $datas->id]) }}"><img  style="width: 14px;" src="{{ asset('assets/img/delete.png')}}"></a>
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

         <!-- Modal -->
            <div class="modal fade" id="viewSupportFileModal" tabindex="-1" role="dialog" aria-labelledby="viewSupportFileModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewSupportFileModalLabel">View HR Support File Type Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Type:</strong> <span id="view-support-file-type"></span></p>
                            <p><strong>Description:</strong></p>
                            <p id="view-support-file-description"></p>
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
            <div class="modal fade" id="viewSupportFileModalDescription" tabindex="-1" role="dialog" aria-labelledby="viewSupportFileModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewSupportFileModalLabel">View HR Support Long Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Title:</strong> <span id="view-support-file-title-long"></span></p>
                            <p><strong>Long Description:</strong></p>
                            <p id="view-support-file-description-long"></p>
                        </div>
                    </div>
                </div>
            </div>

         @include('admin.include.footer')
      </div>
   </div>
   <!--   Core JS Files   -->
   @include('admin.include.script')
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


</body>
</html>
