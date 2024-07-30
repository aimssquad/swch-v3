@extends('filemanagment.include.app')
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
   <div class="dash-inr">
      <div class="container">
         <div class="row">
         </div>
      </div>
   </div>
</div>
@endsection
