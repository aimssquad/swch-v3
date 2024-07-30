@extends('filemanagment.include.app')
@section('content')
<style>
    .card-body a {
    display: inline-block;
    /*width: 100px;*/
    /*height: 100px;*/
    text-align: center;
    /*background: #f4f4f4;*/
    /*border: 1px solid #e4e4e4;*/
    padding:0px;
    margin: 2px;
    border-radius: 10px;
    vertical-align: top;
    position: relative;
    color:#000;
}
.card-body a:hover{
    color:#000;
}
/*.card-body a img{*/
/*    max-width: 100%;*/
/*    height: auto!important;*/
/*    position: absolute;*/
/*    left: 0;*/
/*    right: 0;*/
/*    margin: auto;*/
/*    top: 0;*/
/*    bottom: 0;*/
/*}*/
</style>
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  
               </div>
            </div>
         </div>

            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Files</h4>
                        <div class="d-flex justify-content-between float-right mb-3">
                           <div>
                            <button type="button" class="btn btn-primary mx-1" title="Import Files" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;" data-toggle="modal" data-target="#exampleModal1">
                                Add Folder
                              </button>
                           </div>
                       </div>
                    </div>
                    @include('layout.message')

                       <div class="card-body">
                         @foreach($file_image as $item)
                         <a href="{{url('fileManagment/file-add/'.$item->id)}}" class="mb-2"><img src="{{asset('filemanagment/folder.png')}}" style="width:50px; border-radius:10px">
                         <p><?php echo $item->folder_name ?> </p>
                            </a>
                         @endforeach
                        </div>
                    </div>
                </div>
                </div>
            </div>

      </div>
   </div>


   <!-- Modal -->
   <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form style='padding: 0px;' action="{{url('fileManagment/saveFolder')}}" method="post" enctype="multipart/form-data">
          @csrf

          <div class="modal-content">
            <div class="modal-body">
                {{-- <div id="validationMessage" style="border: 1px solid red; color:red"></div> --}}
                <input type="hidden" name="empId" value="{{$data->emp_id}}">
                <input type="hidden" name="fileName" value="{{$data->file_name}}">
                <input type="hidden" name="orgId" value="{{$data->organization_id}}">
                <input type="hidden" name="file_id" value="{{ request()->route('id') }}">
                <div class="form-group">
                  <label for="excel_file">Folder Name</label>
                  <input type="text" name="folder_name" class="form-control" style='height: 40px;' id="fileInput" required>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" style="padding: 0px 8px;height: 32px;" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="validateButton" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;" onclick="hello()">submit</button>
            </div>
            {{-- <div id="validationMessage"></div> --}}
          </div>
      </form>
    </div>
  </div>
  <!-- END -->

   <!-- Modal -->
   <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form style='padding: 0px;' action="{{url('fileManagment/updateUpload')}}" method="post" enctype="multipart/form-data">
          @csrf

          <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" id="file_id" name="fileupload_id">
                <input type="hidden" name="org_id" value="{{ request()->route('id') }}">
                <div class="form-group">
                  <label for="excel_file">File Name</label>
                  <input type="text" name="file_rename" class="form-control"  style='height: 40px;' id="filerenameid" required>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" style="padding: 0px 8px;height: 32px;" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="validateButton" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;" onclick="hello()">Update</button>
            </div>
          </div>
      </form>
    </div>
  </div>
  <!-- END -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script>
    function helopj(id,fileRename){
       $("#file_id").val(id);
       $("#filerenameid").val(fileRename) ;
    }
</script>

  
  {{-- <script>
    function hello(){

            var fileInput = document.getElementById('fileInput');
            var validationMessage = document.getElementById('validationMessage');

            if (fileInput.files.length === 0) {
                validationMessage.innerHTML = 'No file selected.';
                return;
            }

            var file = fileInput.files[0];
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            var maxSizeInBytes = 5 * 1024 * 1024; // 5 MB

            var fileExtension = file.name.split('.').pop();

            if (allowedExtensions.indexOf(fileExtension.toLowerCase()) === -1) {
                validationMessage.innerHTML = 'Invalid file type. Allowed file types: ' + allowedExtensions.join(', ');
            } else if (file.size > maxSizeInBytes) {
                validationMessage.innerHTML = 'File is too large. Maximum size is 5 MB.';
            } else {
                validationMessage.innerHTML = 'File is valid.';
            }
    }
    $(document).ready(function () {
        $('#validateButton').on('click', function () {
            var fileInput = document.getElementById('fileInput');
            var validationMessage = document.getElementById('validationMessage');

            if (fileInput.files.length === 0) {
                validationMessage.innerHTML = 'No file selected.';
                return;
            }

            var file = fileInput.files[0];
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif','pdf','doc','txt'];
            var maxSizeInBytes = 5 * 1024 * 1024; // 5 MB

            var fileExtension = file.name.split('.').pop();

            if (allowedExtensions.indexOf(fileExtension.toLowerCase()) === -1) {
                validationMessage.innerHTML = 'Invalid file type. Allowed file types: ' + allowedExtensions.join(', ');
            } else if (file.size > maxSizeInBytes) {
                validationMessage.innerHTML = 'File is too large. Maximum size is 5 MB.';
            } else {
                validationMessage.innerHTML = 'File is valid.';
            }
        });
    });
</script> --}}


   @endsection
    @section('js')

    @endsection
