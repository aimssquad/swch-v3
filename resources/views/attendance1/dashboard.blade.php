@extends('attendance.include.app')
@section('css')
<style>
   .dash-inr {margin: -45px 15px;}
   .alert.alert-info{display:none !important}
   .dash-box{padding: 15px 30px;border-radius: 7px;    margin-bottom: 26px;}
   .grn {background: #30a24b;}.red{background:#f3425f}.blue{background:#763ee7}.sky{background:#1878f3}.orange{background:orange}
   .dash-box img{width:50px}
   .dash-cont h4{color:#fff;padding-top:15px;font-size: 13px;}
   .numb h5{color: #fff;font-size: 28px;}.view-more a img{width: 22px;padding-top: 19px;}.numb{text-align: right;}.view-more{text-align: right;}
</style>
@endsection
@section('content')
<div class="main-panel">
<div class="content">
   <div class="panel-header bg-primary-gradient" style="background:#1572e8!important;">
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
   <div class="dash-inr">
      <div class="container">
         <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="dash-box grn">
                  <div class="row">
                     <div class="col-md-8 col-8">
                        <div class="dash-ico">
                           <img src="{{ asset('assets/img/employee-no.png')}}" alt="">
                        </div>
                        <div class="dash-cont">
                           <h4> Total No Of Employee Present</h4>
                        </div>
                     </div>
                     <div class="col-md-4 col-4">
                        <div class="numb">
                           <h5> 0 </h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="dash-box red">
                  <div class="row">
                     <div class="col-md-8 col-8">
                        <div class="dash-ico">
                           <img src="{{ asset('assets/img/emp-absent.png')}}" alt="">
                        </div>
                        <div class="dash-cont">
                           <h4>Total No Of Employee Absent</h4>
                        </div>
                     </div>
                     <div class="col-md-4 col-4">
                        <div class="numb">
                           <h5> 0 </h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="dash-box blue" style="background: #a19f9f;">
                  <div class="row">
                     <div class="col-md-8 col-8">
                        <div class="dash-ico">
                           <img src="{{ asset('assets/img/emp-leave.png')}}" alt="">
                        </div>
                        <div class="dash-cont">
                           <h4>Total No Of Employee On Leave</h4>
                        </div>
                     </div>
                     <div class="col-md-4 col-4">
                        <div class="numb">
                           <h5> 0 </h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection