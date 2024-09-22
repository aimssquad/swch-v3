@extends('sub-admin.include.app')

@section('title', 'Sub Admin Dashboard')

@section('content')
@php
    $arrrole = Session::get('empsu_role');
    $userType = Session::get('usersu_type');
    $emp_email = Session::get('empsu_email');
    $data = DB::table('sub_admin_registrations')->where('email', $emp_email)->where('status', 'active')->first();
    if ($data) {
        $org_code = $data->org_code;
        
    }
@endphp

    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->  
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Sub Admin Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sub Admin Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if($userType=='sub-admin')
                                <div class="p-5">
                                    <div class="card p-2" style="width: 18rem; background: #e9b2b8">
                                        <div class="card-body" style="background: linear-gradient(45deg, #fd7e14, #dc3545);">
                                            <p class="card-text text-light">
                                                <b>This is Registration URL: <span id="registrationUrl">{{ url('register/' . $org_code) }}</span></b>
                                            </p>
                                            <span class="copy-button text-warning" id="copyButton" onclick="copyToClipboard()">Copy URL</span>
                                        </div>
                                        
                                    </div>
                                </div>
                                <input type="text" id="tempInput" style="position: absolute; left: -9999px;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->
@endsection
@section('script')
    <script>
        function copyToClipboard() {
        var urlText = document.getElementById('registrationUrl').innerText;
        var tempInput = document.getElementById('tempInput');
        tempInput.value = urlText;
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand('copy');
        var copyButton = document.getElementById('copyButton');
        copyButton.classList.remove('text-warning');
        copyButton.classList.add('text-dark');
        }

    </script>
@endsection
