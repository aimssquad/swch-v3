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
                           <h4 class="card-title"><i class="far fa-user"></i> Hr Support File Types <span><a data-toggle="tooltip" data-placement="bottom" title="Hr Support File Types" href="{{url('superadmin/add-hr-support-file-type')}}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span></h4>
                           @include('layout/message')
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table id="basic-datatables" class="display table table-striped table-hover" >
                                 <thead>
                                    <tr>
                                       <th>Sl.No.</th>
                                       <th>Type</th>
                                       <th>Description</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php $i = 1;?>
                                        @foreach($data as $datas)
                                        <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $datas->type }}</td>
                                        <td>
                                            <a data-toggle="tooltip" data-placement="bottom" title="View" class="view-support-file" data-id="{{ $datas->id }}">
                                                <img style="width: 14px;" src="{{ asset('assets/img/view.png') }}">
                                            </a>
                                        </td>
                                        @if ($datas->status == 0)
                                            <td><span class="badge badge-danger">Inactive</span></td>
                                        @else
                                            <td><span class="badge badge-success">Active</span></td>
                                        @endif

                                        <td class="icon">
                                            <a data-toggle="tooltip" data-placement="bottom"  title="Edit" href="{{url('superadmin/edit-hr-support-file-type/'.$datas->id)}}"><img  style="width: 14px;" src="{{ asset('assets/img/edit.png')}}"></a>
                                            <a data-toggle="tooltip" data-placement="bottom"  title="Delete" href="{{ route('delete-hr-support-file-type', ['id' => $datas->id]) }}"><img  style="width: 14px;" src="{{ asset('assets/img/delete.png')}}"></a>
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
                            <h5 class="modal-title" id="viewSupportFileModalLabel">View HR Support File</h5>
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

         @include('admin.include.footer')
      </div>
   </div>
   <!--   Core JS Files   -->
   @include('admin.include.script2')



</body>
</html>
