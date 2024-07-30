@extends('hrsupport.include.app')
@section('css')
<style>
   .dash-inr {margin-top: 20px;}
   .alert.alert-info{display:none !important}
   .dash-box{padding: 8px 30px;border-radius: 7px;    margin-bottom: 26px;}
   .grn {background: linear-gradient(-45deg, #30feff, #17276d) !important;}.red{background:#f3425f}.blue{background:#763ee7}.sky{background:#1878f3}.orange{background:orange}
   .dash-box img{width: 30px;margin-top: -8px;}
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
      <div class="container-fluid">
         <div class="row">
           @foreach ($data as $datas)
                <div class="col-xl-3 col-lg-3 col-md-4">
                    <div class="dash-box grn">
                    <div class="row">
                        <div class="col-md-8 col-8">
                            <div class="dash-ico">
                            </div>
                            <div class="dash-cont">
                                <h4> {{isset($datas->type) ? $datas->type : ""}} </h4>
                            </div>
                        </div>
                        <div class="col-md-4 col-4">
                            <div class="view-more">
                                <a href="{{ isset($datas->id) ? route('supportfile.show', ['id' => $datas->id]) : '#' }}">
                                <img src="{{ asset('assets/img/login.png')}}"></a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
         </div>
      </div>
   </div>
</div>
@endsection
