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
            <a href="#">File Division</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                <div class="card">

                  <div class="card-header">
                    <h4 class="card-title"><i class="fas fa-briefcase"></i> File Division
                    <span><a  data-toggle="tooltip" data-placement="bottom" title="Add File Division" href="{{ url('fileManagment/fileManagment-division-add') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span>	</h4>
                   @include('layout.message')
                </div>

                    <div class="card-body">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:6%;">Sl.No.</th>
                                        <th style="width:6%;">name</th>
                                        <th style="width:6%;">Status</th>
                                        <th style="width:6%;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach($file_details as $item)

                                  <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->status}}</td>
                                    <td><a href='{{url("fileManagment/edit-file-devision/$item->id")}}'><i class="fas fa-edit"></i></a></td>
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
