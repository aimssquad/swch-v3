@extends('employeer.include.app')
@section('title', 'Leave Dashboard')
@section('content')
<div class="content container-fluid pb-0">
				
    <!-- Page Header -->
    <div class="page-header">
        <div class="content-page-header">
            <h5>Dashboard</h5>
        </div>	
    </div>
    <!-- /Page Header -->
    <div class="row">
					
        <!-- Chart -->
        <div class="col-md-12">	
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Leave Type</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-4">
                            <div class="card-body ">
                                <span class="donut" data-peity='{ "fill": ["#7638ff", "rgba(67, 87, 133, .09)"]}'>1/5</span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <div class="card-body ">
                                <span class="donut" data-peity='{ "fill": ["#7638ff", "rgba(67, 87, 133, .09)"]}'>226/360</span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <div class="card-body ">
                                <span class="donut" data-peity='{ "fill": ["#7638ff", "rgba(67, 87, 133, .09)"]}'>0.52/1.561</span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <div class="card-body ">
                                <span class="donut" data-peity='{ "fill": ["#7638ff", "rgba(67, 87, 133, .09)"]}'>1,4</span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <div class="card-body ">
                                <span class="donut" data-peity='{ "fill": ["#7638ff", "rgba(67, 87, 133, .09)"]}'>226,134</span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <div class="card-body ">
                                <span class="donut" data-peity='{ "fill": ["#7638ff", "rgba(67, 87, 133, .09)"]}'>0.52,1.041</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
					
            <!-- Chart -->
            <div class="col-md-6">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Leave Chart</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="chartBar1" class="h-300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Chart -->
            
            <!-- Chart -->
            <div class="col-md-6">	
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Type Of Cahrt </h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <canvas id="chartBar2" class="h-300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Chart -->
        
							
						
    </div>
</div>
@endsection
