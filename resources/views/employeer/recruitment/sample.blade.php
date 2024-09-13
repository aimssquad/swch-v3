@extends('employeer.include.app')
@section('title', 'Job List')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">SampleFORM</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Job List</li>
				</ul>
			</div>
            @include('employeer.layout.message')
		</div>
	</div>
	<!-- /Page Header -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="">
                    <h1>hhhh khihho i ihihihi  hih</h1>
                </form>
            </div>
        </div>
    </div>
	
</div>
<!-- /Page Content -->
@endsection
@section('script')
@endsection

