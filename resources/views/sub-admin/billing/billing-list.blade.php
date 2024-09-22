
@extends('sub-admin.include.app')
@section('title', ' Billing')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title"> Billing</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('superadmindasboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Billing Dashboard</a></li>
					<li class="breadcrumb-item active"> Billing</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				<a href="{{ url('superadmin/add-billing') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add  Billing</a>
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
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; Billing
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
                                    <th>Sl.No.</th>
                                    <th>Invoice Number</th>
                                    <th>Bill To</th>
                                    <th>Bill For</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Payment Mode</th>
                                    <th>Invoice Cancel</th>
                                    <th>Email Send Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $t = 1;?>
                                <?php $i = 1;?>
              @foreach($bill_rs as $company)
                  <?php
if ($company->billing_type == 'Organisation') {
$pass = DB::Table('registration')

->where('reg', '=', $company->emid)

->first();}

$bil_name = DB::Table('billing')

->where('in_id', '=', $company->in_id)

->get();
$nameb = array();
if (count($bil_name) != 0) {
foreach ($bil_name as $biname) {
$nameb[] = $biname->des;

}
}
$strbil = implode(',', $nameb);
?>
          <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $company->in_id }}</td>
              <td>
                  @if($company->billing_type=='Organisation')
                      @if($company->bill_for=='first invoice recruitment service')
                          {{ $company->canidate_name }}
                          <p><small>({{ $pass->com_name }})</small></p>
                      @elseif($company->bill_for=='second invoice visa service')
                          {{ $company->canidate_name }}
                          <p><small>({{ $pass->com_name }})</small></p>
                      @else
                          {{ $pass->com_name }}
                      @endif
                  @else
                      {{ $company->canidate_name }}
                  @endif
              </td>

              <td>{{ ucwords($company->bill_for)}}</td>
              <td>{{ $strbil}}</td>



                <td>{{ $company->amount }}</td>
                <td>{{ date('d/m/Y',strtotime($company->date)) }}</td>



              <td>{{ strtoupper($company->status) }}</td>
                  <td>{{ ($company->pay_mode=='Ofline')? 'Offline': $company->pay_mode }}</td>
                     <td>
               <script language="JavaScript" type="text/javascript">
                  function checkDelete(){
                  return confirm('Are you sure you want to cancel this invoice?');
                  }
                  </script>
<a href="{{url('superadmin/invoice-bill/'.base64_encode($company->in_id))}}" onClick="return checkDelete()">Yes</a>
          </td>
           <td> @if($company->bill_send!='')
                   {{ date('d/m/Y',strtotime($company->bill_send)) }}
                   @endif</td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{url('superadmin/edit-billing/'.base64_encode($company->in_id))}}">
                                                        <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="{{url('superadmin/edit-billing/'.base64_encode($company->in_id))}}">
                                                        <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="{{url('superadmin/edit-billing/'.base64_encode($company->in_id))}}">
                                                        <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item" href="{{url('superadmin/edit-billing/'.base64_encode($company->in_id))}}">
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

