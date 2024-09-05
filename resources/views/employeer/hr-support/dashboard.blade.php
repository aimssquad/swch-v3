@extends('employeer.include.app')
@section('title', 'HR Dashboard')
@section('css')
    <style>
        .card-bg-gradient {
        background: linear-gradient(to right, #ff7e5f, #feb47b); /* Example gradient colors */
        }
    </style>
@endsection
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Dashboard</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Dashboard</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
    @foreach ($data as $index => $datas)
        @php
            // Define an array of gradient colors
            $gradients = [
                'linear-gradient(to right, #ff7e5f, #feb47b)',   // Warm Sunset
                'linear-gradient(to right, #6a11cb, #2575fc)',   // Deep Blue
                'linear-gradient(to right, #f093fb, #f5576c)',   // Pinkish Delight
                'linear-gradient(to right, #5ee7df, #b490ca)',   // Cool Mint
                'linear-gradient(to right, #ff9966, #ff5e62)',   // Orange Red
                'linear-gradient(to right, #00c6ff, #0072ff)',   // Sky Blue
                'linear-gradient(to right, #00f260, #0575e6)',   // Aqua Marine
                'linear-gradient(to right, #e1eec3, #f05053)',   // Soft Red
                'linear-gradient(to right, #43e97b, #38f9d7)',   // Greenish Teal
                'linear-gradient(to right, #fa709a, #fee140)',   // Pink Lemonade
                'linear-gradient(to right, #a18cd1, #fbc2eb)',   // Lavender Dream
                //'linear-gradient(to right, #fdfbfb, #ebedee)',   // Subtle White
                //'linear-gradient(to right, #cfd9df, #e2ebf0)',   // Light Blue Sky
                'linear-gradient(to right, #ff9a9e, #fecfef)',   // Blushing Pink
                'linear-gradient(to right, #f3e7e9, #e3eeff)',   // Cotton Candy
                'linear-gradient(to right, #667eea, #764ba2)',   // Indigo Purple
                'linear-gradient(to right, #89f7fe, #66a6ff)',   // Light Ocean
                'linear-gradient(to right, #c471f5, #fa71cd)',   // Purple Pink
                'linear-gradient(to right, #f6d365, #fda085)',   // Warm Peach
                'linear-gradient(to right, #fbc2eb, #a6c1ee)',   // Soft Pastel
            ];

            // Choose a gradient based on the index
            $gradient = $gradients[$index % count($gradients)];
        @endphp
            <div class="col-xl-3">
                <div class="card" style="background: {{ $gradient }};">
                    <div class="card-body">
                        <div class="d-flex align-items-center w-100">
                            <div class="">
                                <div class="fs-15 fw-semibold">{{isset($datas->type) ? $datas->type : ""}}</div>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ isset($datas->id) ? route('support-file.show', ['id' => $datas->id]) : '#' }}" class="text-fixed-white"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
   </div>
</div>
@endsection
@section('script')
@endsection