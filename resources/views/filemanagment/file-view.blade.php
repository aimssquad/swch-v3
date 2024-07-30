@extends('filemanagment.include.app')
@section('content')
<style>
    .card-body a {
    display: inline-block;
    width: 100px;
    height: 100px;
    text-align: center;
    background: #f4f4f4;
    border: 1px solid #e4e4e4;
    padding: 10px;
    margin: 6px;
    border-radius: 10px;
    vertical-align: top;
    position: relative;
}
.card-body a img{
    max-width: 100%;
    height: auto!important;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    top: 0;
    bottom: 0;
}
.file_uploading{
    margin:0;
    padding:0;
}
.file_uploading li {
    width: 90px;
    text-align: center;
    list-style: none;
    display: inline-block;
    margin: 0 5px;
    vertical-align: top;
}
.file_uploading li img{
    max-height:40px;
}
.file_btn .material-symbols-outlined {
    font-size: 15px;
}
.file_btn {
    right: 0;
}
.file_uploading a{
    color:#000;
}
.file_uploading a:hover{
    color:#000;
}
.file_uploading p {
    line-height: 10px;
    margin-top: 6px;
    height: 22px;
    overflow: hidden;
   display: -webkit-box;
   -webkit-line-clamp: 2; /* number of lines to show */
           line-clamp: 2; 
   -webkit-box-orient: vertical;
}
</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

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
                        <div class="d-flex justify-content-between mb-2">
                            <div class="mt-1"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i> Files</div>
                            <div>
                                <button type="button" class="btn btn-primary mx-1" title="Import Files" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;" data-toggle="modal" data-target="#exampleModal1">
                                Add File
                              </button>
                            </div>
                        </div>
                        <div>
                            <ul class="m-0 p-0 file_uploading">
                                @foreach($file_image as $item)
                         <?php
                           $filename = 'FileManagment/'.$item->fileName.'/'.$item->uploadFile;
                            $fileInfo = pathinfo($filename);
                            $extension = $fileInfo['extension']; // $extension will be 'jpg'
                          ?> 
                         @if ($extension=="pdf")
                                
                                <li class="position-relative shadow-sm p-2 mb-3">
                                     <div class="file_btn position-absolute">
                                         <a class="drop_downmain" style="    position: absolute; right: 0;" href="javascript:void(0)">
                                         <div>
                                             <span class="material-symbols-outlined show">
                                            more_vert
                                            </span>
                                            <span class="material-symbols-outlined hide">
                                            close
                                            </span>
                                         </div>
                                         </a>
                                         
                                        <div class="drop_down" style-="    background: #fff; font-size: 13px;"
                                            <a href="#" class="d-block" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                                            <span class="material-symbols-outlined">edit</span> Edit
                                        </a>
                                        <a class="d-block" href="{{url('fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                                            <span class="material-symbols-outlined text-danger">delete</span> Delete
                                        </a>
                                        </div>
                                        </div>
                                        
                                    <a href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>
                                        <div class="file_icon">
                                            <img src="{{asset('filemanagment/pdf.png')}}">
                                        </div>
                                        <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                                    </a>
                                </li>
                                
                              @elseif ($extension=="txt")
                              <li class="position-relative shadow-sm p-2 mb-3">
                                     <div class="file_btn position-absolute">
                                        <a href="#" class="d-block" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        <a class="d-block" href="{{url('fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                                            <span class="material-symbols-outlined text-danger">delete</span>
                                        </a>
                                        </div>
                                        
                                    <a href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>
                                        <div class="file_icon">
                                            <img src="{{asset('filemanagment/txt.png')}}">
                                        </div>
                                        <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                                    </a>
                                </li>
                                  @elseif($extension=="docx")
                                  <li class="position-relative shadow-sm p-2 mb-3">
                                     <div class="file_btn position-absolute">
                                        <a href="#" class="d-block" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        <a class="d-block" href="{{url('fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                                            <span class="material-symbols-outlined text-danger">delete</span>
                                        </a>
                                        </div>
                                        
                                    <a href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>
                                        <div class="file_icon">
                                           <img src="{{asset('filemanagment/doc.png')}}">
                                        </div>
                                        <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                                    </a>
                                </li>
                                  @else
                                   <li class="position-relative shadow-sm p-2 mb-3">
                                     <div class="file_btn position-absolute">
                                        <a href="#" class="d-block" data-toggle="modal" data-target="#exampleModal2" data-id="{{$item->id}}" id="renameButton" onclick="helopj('{{$item->id}}', '{{$item->file_rename}}')">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        <a class="d-block" href="{{url('fileManagment/file-name-delete/'.$item->id.'/'.request()->route('id'))}}">
                                            <span class="material-symbols-outlined text-danger">delete</span>
                                        </a>
                                        </div>
                                        
                                    <a href="{{asset('filemanagment/'.$item->fileName.'/'.$item->uploadFile)}}" download>
                                        <div class="file_icon">
                                            <img src="{{asset('filemanagment/ot.png')}}">
                                        </div>
                                        <p class="text-center mb-0"><?php echo $item->file_rename ?> </p>
                                    </a>
                                </li>
                                  @endif
                         @endforeach
                         
                         
                            </ul>
                        </div>
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
      <form style='padding: 0px;' action="{{url('fileManagment/saveUpload')}}" method="post" enctype="multipart/form-data">
          @csrf

          <div class="modal-content">
            <div class="modal-body">
                {{-- <div id="validationMessage" style="border: 1px solid red; color:red"></div> --}}
               <input type="hidden" name="empId" value="{{$data->emp_id}}">
                <input type="hidden" name="fileName" value="{{$data->file_name}}">
                <input type="hidden" name="folderName" value="{{$data->folder_name}}">
                <input type="hidden" name="orgId" value="{{$data->org_id}}">
                <input type="hidden" name="file_id" value="{{$data->file_id}}">
                <input type="hidden" name="file_add" value="{{ request()->route('id') }}">
                <div class="form-group">
                  <label for="excel_file">File Name</label>
                  <input type="text" name="file_rename[]" class="form-control" style='height: 40px;' id="fileInput" required>
                  <label for="excel_file">Upload Files</label>
                  <input type="file" name="uploadFile[]" class="form-control" style='height: 40px;' id="fileInput" multiple required>
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
    // $(".drop_down").hide();
     $(".drop_downmain").click(function(){
         
       $(".drop_down").toggleClass("action");
    });
     $(".drop_downmain").click(function(){
         
       $(".drop_downmain").toggleClass("action2");
    });
</script>

<style>
.drop_down,.hide{
    display:none;
    opacity:0;
}
    .drop_down.action{
       display: block;
    opacity: 1;
    background: #f8f8f8;
    padding: 5px;
    font-size: 13px;
    padding-top: 14px;
    border: 1px solid #f1f1f1;
        /*text-align: left;*/
    }
    .drop_down.action .material-symbols-outlined{
            vertical-align: middle;
        
    }
    .drop_downmain.action2 .show{
        display:none;
    }
    .drop_downmain.action2 .hide{
        display:block;
        opacity:1;
    }
</style>
  
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
