@extends('filemanagment.include.include')
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
            <a href="#">File Division Report</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                  @endif
               </div>
            </div>
         </div>
       
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;File Division Report</h4>
                    </div>
                    <div class="card-header">
                        {{-- <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;FileManagment Report</h4> --}}
                        <a href="{{url('fileManagment/fileManagment-division-add')}}">Add</a>
                    </div>
                   
                    <div class="card-body">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:6%;">Sl.No.</th>
                                        <th style="width:6%;">name</th>
                                        <th style="width:6%;">file_name</th>
                                        <th style="width:6%;">Organization Id</th>
                                        <th style="width:6%;">Employee Code</th>
                                        <th style="width:6%;">Employee Name</th>
                                        <th style="width:6%;">Division</th>
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
                                    <td>{{$item->file_name}}</td>
                                    <td>{{$item->organization_id}}</td>
                                    <td>{{$item->emp_id}}</td>
                                    <td>{{$item->emp_name}}</td>
                                    <td>{{$item->division}}</td>
                                    <td>{{$item->status}}</td>
                                    <td><a href='{{url("fileManagment/edit-file-devision/$item->id")}}'><i class="fas fa-edit"></i></a></td>
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

   @endsection
    @section('js')

    @endsection
   