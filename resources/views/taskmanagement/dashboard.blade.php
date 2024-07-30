@extends('taskmanagement.layouts.master')

@section('title')
SWCH
@endsection

@section('sidebar')
@include('taskmanagement.partials.sidebar')
@endsection

@section('header')
@include('taskmanagement.partials.header')
@endsection

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

<!-- Content -->
<div class="main-panel">
	<div class="pt-5 bg-transparent container">
		<div class="row">
			@foreach($projects as $k=>$p)
			<!-- <?php
					// echo "<pre>";
					// 		print_r($p);
					// 		echo "</pre>"; 
					?> -->
			<div class="col-sm-4">
				<div class="mt-2">
					<h6 class="bg-secondary m-0 p-2 text-white">{{$p->title}}</h6>
					<table class="table table-hover border m-0 p-0">
						<tr>
							<th>Owner:</th>
							<td>{{$p->owner}}</td>
						</tr>
						<tr>
							<th>Satrt Date:</th>
							<td><span class="badge text-bg-secondary">{{date("d-m-Y",strtotime($p->created_at))}}</span></td>
						</tr>
					</table>

				</div>
				<div class="mb-5 d-block mt-2">
					@foreach($p->labels as $l)
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">{{$l['count']}}</h4>
						<p class="m-0 p-0">{{$l['title']}}</p>
					</span>
					@endforeach
					<!-- <span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">3</h4>
						<p class="m-0 p-0">Ready</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Work in progress</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Done</p>
					</span> -->
				</div>
			</div>
			@endforeach
			<!-- <div class="col-sm-4">
				<div class="mt-2">
					<h6 class="bg-secondary m-0 p-2 text-white">Project Name: KS Solution</h6>
					<table class="table table-hover border m-0 p-0">
						<tr>
							<th>Owner:</th>
							<td>Name of the Owner</td>
						</tr>
						<tr>
							<th>Satrt Date:</th>
							<td><span class="badge text-bg-secondary">16-04-2020</span></td>
						</tr>
					</table>

				</div>
				<div class="mb-5 d-block mt-2">
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">3</h4>
						<p class="m-0 p-0">Ready</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Work in progress</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Done</p>
					</span>
				</div>
			</div>



			<div class="col-sm-4">
				<div class="mt-2">
					<h6 class="bg-secondary m-0 p-2 text-white">Project Name: KS Solution</h6>
					<table class="table table-hover border m-0 p-0">
						<tr>
							<th>Owner:</th>
							<td>Name of the Owner</td>
						</tr>
						<tr>
							<th>Satrt Date:</th>
							<td><span class="badge text-bg-secondary">16-04-2020</span></td>
						</tr>
					</table>

				</div>
				<div class="mb-5 d-block mt-2">
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">3</h4>
						<p class="m-0 p-0">Ready</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Work in progress</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Done</p>
					</span>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="mt-2">
					<h6 class="bg-secondary m-0 p-2 text-white">Project Name: KS Solution</h6>
					<table class="table table-hover border m-0 p-0">
						<tr>
							<th>Owner:</th>
							<td>Name of the Owner</td>
						</tr>
						<tr>
							<th>Satrt Date:</th>
							<td><span class="badge text-bg-secondary">16-04-2020</span></td>
						</tr>
					</table>

				</div>
				<div class="mb-5 d-block mt-2">
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">3</h4>
						<p class="m-0 p-0">Ready</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Work in progress</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Done</p>
					</span>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="mt-2">
					<h6 class="bg-secondary m-0 p-2 text-white">Project Name: KS Solution</h6>
					<table class="table table-hover border m-0 p-0">
						<tr>
							<th>Owner:</th>
							<td>Name of the Owner</td>
						</tr>
						<tr>
							<th>Satrt Date:</th>
							<td><span class="badge text-bg-secondary">16-04-2020</span></td>
						</tr>
					</table>

				</div>
				<div class="mb-5 d-block mt-2">
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">3</h4>
						<p class="m-0 p-0">Ready</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Work in progress</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Done</p>
					</span>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="mt-2">
					<h6 class="bg-secondary m-0 p-2 text-white">Project Name: KS Solution</h6>
					<table class="table table-hover border m-0 p-0">
						<tr>
							<th>Owner:</th>
							<td>Name of the Owner</td>
						</tr>
						<tr>
							<th>Satrt Date:</th>
							<td><span class="badge text-bg-secondary">16-04-2020</span></td>
						</tr>
					</table>

				</div>
				<div class="mb-5 d-block mt-2">
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">3</h4>
						<p class="m-0 p-0">Ready</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Work in progress</p>
					</span>
					<span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center">
						<h4 class="m-0 p-0">0</h4>
						<p class="m-0 p-0">Done</p>
					</span>
				</div>
			</div> -->


		</div>
	</div>
</div>
<!-- /.content -->
<div class="clearfix"></div>
<style>
	.right-panel {
		background: transparent !important;
	}
</style>


@endsection

@section('scripts')
@include('taskmanagement.partials.scripts')
@endsection