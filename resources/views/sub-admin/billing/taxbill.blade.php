
@extends('sub-admin.include.app')
@section('title', 'Tax Master')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Tax Master</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Billing Dashboard</a></li>
					<li class="breadcrumb-item active">Tax Master</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				<a href="{{url('superadmin/add-taxforbill')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Tax Master</a>
			</div>
		</div>
	</div>
	<!-- /Page Header -->
    @include('sub-admin.layout.message')
	<div class="row">
		<div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Tax Master
                    </h4>
                    <div class="row">
                       <div class="col-auto">
                           <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                               @csrf
                               <input type="hidden" name="data" id="data">
                               <input type="hidden" name="headings" id="headings">
                               <input type="hidden" name="filename" id="filename">
                               {{-- put the value - that is your file name --}}
                               <input type="hidden" id="filenameInput" value="Tax">
                               <button type="submit" class="btn btn-success btn-sm">
                                   <i class="fas fa-file-excel"></i> Export to Excel
                               </button>
                           </form>
                       </div>
                       <div class="col-auto">
                           <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                             @csrf
                             <input type="hidden" name="data" id="pdfData">
                             <input type="hidden" name="headings" id="pdfHeadings">
                             <input type="hidden" name="filename" id="pdfFilename">
                             <button type="submit" class="btn btn-info btn-sm">
                                 <i class="fas fa-file-pdf"></i> Export to PDF
                             </button>
                         </form>
                       </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="basic-datatables">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Tax Name </th>
                                    <th>Tax Percentage </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee_type_rs as $employee_type)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>  
                                        <td> {{$employee_type->name}}</td>
                                        <td> {{$employee_type->percent}}</td>
                                        <td>
                                            <div class="dropdown action-label">
                                                <span class="btn btn-white btn-sm {{ $employee_type->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                                    {{$employee_type->status}}
                                                </span>
                                            </div>
                                        </td>  
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{ url("superadmin/add-taxforbill/".base64_encode($employee_type->id)) }}">
                                                        <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<!-- /Page Content -->


@endsection

