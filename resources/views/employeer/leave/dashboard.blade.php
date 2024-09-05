@extends('employeer.include.app')
@section('title', 'Add New IFSC')
@section('content')
<div class="main-panel">
   <div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                    
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="page-inner mt--5">
        <div class="row mt--2">
              @if(count($leave_type_tot)!=0)
            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-body">
                      
                        <div class="card-title">Leave Type</div>
                    
                        <!--<div class="card-category">Daily information about statistics in system</div>-->
                        <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                                <?php
                        $k=1;
                        ?>
                             @foreach($leave_type_tot as $LeaveAlloca)
                            <div class="px-2 pb-2 pb-md-0 text-center">
                                <div id="circles-{{$k}}"></div>
                                <h6 class="fw-bold mt-3 mb-0">{{$LeaveAlloca->leave_type_name}}</h6>
                            </div>
                                <?php
                        $k++;
                        ?>
                            @endforeach
                            
                        
                        </div>
                    </div>
                </div>
            </div>
                @endif
              @if(count($leave_rule_tot)!=0)
            <div class="col-md-12">
                <div class="card full-height">
                    <div class="card-body">
                       
                        <div class="card-title">Annual Total Leave</div>
                    
                    
                        <div class="row py-3">
                        
                            <div class="col-md-12">
                                <div id="chart-container">
                                    <canvas id="multipleLineChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @endif
        </div>
        
    </div>
   </div>
</div>
@endsection