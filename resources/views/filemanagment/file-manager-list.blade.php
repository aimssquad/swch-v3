@extends('filemanagment.include.app')
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="#">
            Home
            </a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="#">File Manager</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                <div class="card">

                  <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-briefcase"></i> File Manager
                  
                     <span><a data-toggle="tooltip" data-placement="bottom" title="Excel Download" href="{{url('fileManagment/report-excel')}}"><img  style="width: 30px; height:25px; border-radius:5px" src="{{ asset('img/ex.png')}}"></a></span>	
                     <span><a  data-toggle="tooltip" data-placement="bottom" title="Add File Manager" href="{{ url('fileManagment/fileManagment-add') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span>
                    
                     </h4>
                   @include('layout.message')
                </div>


                    <div class="card-body">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:6%;">Sl.No.</th>
                                        <th style="width:6%;">File Name</th>
                                        <th style="width:6%;">Organization Id</th>
                                        <th style="width:6%;">Status</th>
                                        <th style="width:6%;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach($file_details as $item)

                                  <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>{{$item->file_name}}</td>
                                    <td>{{$item->organization_id}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>
                                       <?php if(session('user_type')==="employee"){?>

                                          <?php if($item->status==="pending") {?>
                                             {{-- <a href='{{url("fileManagment/edit-fileManager/$item->id")}}'><i class="fas fa-edit"></i></a> --}}
                                             <?php }else{ ?>
                                                <button class="btn btn-info">
                                                   <a href='{{url("fileManagment/folder-create/$item->id")}}'><i class="fas fa-plus"  style="color: #fff"></i></a>
                                                   </button>
                                              <?php } ?>

                                          <?php }else{ ?>
                                             <?php if($item->status==="pending") {?>
                                                <a href='{{url("fileManagment/edit-fileManager/$item->id")}}'><i class="fas fa-edit"></i></a>
                                                <?php }else{ ?>
                                                   <button class="btn btn-info">
                                                      <a href='{{url("fileManagment/folder-create/$item->id")}}'><i class="fas fa-plus"  style="color: #fff"></i></a>
                                                      </button>
                                                 <?php } ?>
                                             <?php } ?>
                                    </td>
                                  </tr>
                                  <?php  $i++ ?>
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

   @endsection
    @section('js')

    @endsection
