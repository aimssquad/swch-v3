
@extends('employeer.include.app')


@section('title', $data->title)
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')
@php
	function my_simple_crypt( $string, $action = 'encrypt' ) {
		// you may change these values to your own
		$secret_key = 'bopt_saltlake_kolkata_secret_key';
		$secret_iv = 'bopt_saltlake_kolkata_secret_iv';
	
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	
		if( $action == 'encrypt' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
	
		return $output;
	}

@endphp

<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Hr Support File List</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                       <a href="{{ route('home') }}">
                       Home
                       </a>
                    </li>
                    <li class="breadcrumb-item">
                       <a href="{{ route('hr-support.dashboard') }}">Hr Support</a>
                    </li>
                    <li class="breadcrumb-item">
                       <a href="{{ isset($data->type->id) ? route('supportfile.show', ['id' => $data->type->id]) : '#' }}">{{$data->type->type}}</a>
                    </li>
                    <li class="breadcrumb-item active">
                       <a href="#">{{$data->title}}</a>
                    </li>
                 </ul>
			</div>
		</div>
	</div>
    @if(Session::has('message'))										
    <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
    @endif
	<!-- /Page Header -->
	<div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title"><i class="far fa-briefcase" aria-hidden="true"
                            style="color:#f7a01f;"></i> {{$data->title}}
                    </h4>
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
                                            <a href="{{ isset($relatedFile->id) ? route('support-file.details', ['id' => $relatedFile->id]) : '#' }}" class="special-link" style="color: black;"><li style="color: black;font-size:15px;">{{ $relatedFile->title }}</li></a>
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
<!-- /Page Content -->


@endsection

