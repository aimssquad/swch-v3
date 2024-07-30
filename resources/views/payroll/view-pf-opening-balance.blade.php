@extends('payroll.include.app')
@section('css')
<style>
    .card-header-fixed-loan {
    text-align: right;
    padding-right: 16px;
    margin: -30px;
}
</style>
@endsection
@section('content')
<div class="main-panel">
   <div class="page-header page-header-fixed">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{url('payroll-home-dashboard')}}"> Home</a></li>
         <li class="separator">/</li>
         <li class="nav-item"><a href="{{url('payroll/dashboard')}}">Payroll</a></li>
         <li class="separator">/</li>
         <li class="nav-item active"><a href="#">PF Opening Balance</a></li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;PF Opening Balance</h4>
                        <div class="card-header-fixed-loan">
                        
                            <a href="{{ URL::to('/sampledata/pf-opening-balance-import-sample-format.xlsx') }}" title="Download Sample Excel" class="btn float-right excel-button" type="submit" style="background: none;margin-top:-7px;"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></a>
                        
                        <button type="button"  class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#exampleModal" style="color: black">Upload <i class="fa fa-upload"></i></button>
                    </div>
                   
                    <div class="card-body">
                       @include('layout.message')
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Employee Code</th>
                                        <th>Employee Name</th>
                                        <th>Member Balance</th>
                                        <th>Company Balance</th>
                                        <th>Total Balance</th>
                                        <th>Financial Year</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($pf_opening_balance as $record)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $record->emp_code}}</td>
                                            <td>{{ $record->emp_name}}</td>
                                            <td>{{ $record->member_balance }}</td>
                                            <td>{{ $record->company_balance }}</td>
                                            <td>{{ $record->total_balance }}</td>
                                            <td>{{ $record->emp_financial_year }}</td>
                                        </tr>
                                        @endforeach
                                </tbody>

                            </table>
                            </div>
                        </div>
                    </div>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <form style='padding: 0px;' action="{{ url('payroll/upload-pf-opening-balance') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-content">
                            <!--<div class="modal-header">-->
                            <!--  <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>-->
                            <!--  <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                            <!--    <span aria-hidden="true">&times;</span>-->
                            <!--  </button>-->
                            <!--</div>-->
                            <div class="modal-body">
                              
                                <div class="form-group">
                                  <label for="excel_file">Upload Excel</label>
                                  <input type="file" name="import_file" class="form-control" style='height: 40px;' id="excel_file">
                                </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" style="padding: 0px 8px;height: 32px;" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;height: 32px;">Import</button>
                            </div>
                          </div>
                      </form>
                    </div>
                  </div>
                  <!-- END -->

                </div>
                </div>
            </div>
      </div>
   </div>

   @endsection
    @section('js')

    @endsection
   