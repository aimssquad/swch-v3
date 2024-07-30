@extends('hrsupport.include.app')
@section('css')
<style>
    .colorfixed{
        
        color:black;
    }
    p{
        font-size:16px !important;
        color:black;
        text-align:justify;
    }
    .lifixed{
        
    }
</style>




@endsection
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="{{ route('home') }}">
            Home
            </a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="{{ route('hrsupport.dashboard') }}">Hr Support</a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="{{ isset($data->type->id) ? route('supportfile.show', ['id' => $data->type->id]) : '#' }}">{{$data->type->type}}</a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="#">{{$data->title}}</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-briefcase"></i> {{$data->title}}</h4>
                        @include('layout.message')
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="colorfixed">{{$data->title}}</h1>
                                {!! $data->description !!}
                            </div>
                            <div class="col-md-4">
                                <h3>Download Template</h3>
                                @if ($data->pdf !='')
                                    <a href="{{ asset('storage/app/public/hrsupport/pdf/' . $data->pdf) }}" class="btn btn-primary" target="_blank" >View PDF</a>
                                @endif
                                @if ($data->doc !='')
                                    <a href="{{ asset('storage/app/public/hrsupport/doc/' . $data->doc) }}" class="btn btn-secondary" target="_blank" download>Download DOC</a>
                                @endif

                                <h3 style="margin-top: 20px;"><u>Related Templates</u></h3>
                                <ul>
                                    @if(!empty($relatedFiles))
                                        @foreach($relatedFiles as $relatedFile)
                                            @if($relatedFile->id != $data->id)
                                                <a href="{{ isset($relatedFile->id) ? route('supportfile.details', ['id' => $relatedFile->id]) : '#' }}" class="special-link" style="color: black;"><li style="color: black;font-size:15px;">{{ $relatedFile->title }}</li></a>
                                            @endif
                                        @endforeach
                                    @else
                                        <li>No related templates found.</li>
                                    @endif
                                </ul>
                            </div>
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
