@extends('loan.include.app')
@section('css')
@endsection
@section('content')
<div class="main-panel">
<div class="page-header page-header-fixed">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="#">
            Home
            </a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="#">Edit Loan</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="fa fa-plus" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Edit Loan</h4>
                  </div>
               
               <div class="card-body">
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                  @endif
                  <form action="{{url('loans/update-loan')}}" method="post" enctype="multipart/form-data" onsubmit="return validate();">
							{{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="{{$id}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_id">Loan ID</label>
                                        <input type="text" name="loan_id" id="loan_id" value="{{$loan_details->loan_id}}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_code">Employee Code <span>(*)</span></label>
                                        <select id="emp_code" name="emp_code"
                                            class="form-control employee select2_el" required>
                                            <option selected disabled value="">Select</option>
                                            @foreach($Employee as $emp)
                                            <option value="{{$emp->emp_code}}" @if($loan_details->emp_code==$emp->emp_code) selected @endif>
                                                {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}} -
                                                {{$emp->emp_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_type">Loan Type <span>(*)</span></label>
                                        <select id="loan_type" name="loan_type"
                                            class="form-control employee select2_el" required>
                                            <option selected disabled value="">Select</option>
                                            <option value="PF" @if($loan_details->loan_type=="PF") selected @endif>PF Loan</option>
                                            <option value="SA" @if($loan_details->loan_type=="SA") selected @endif>Salary Advance</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_month">Loan Start Date <span>(*)</span></label>
                                        <input class="form-control" id="start_month" type="date" value="{{ $loan_details->start_month }}" name="start_month"  required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loan_amount">Loan Amount <span>(*)</span></label>
                                        <input class="form-control" id="loan_amount" type="number" value="{{ $loan_details->loan_amount }}" name="loan_amount" required  onkeyup="cal_installment();" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="installment_amount">Installment Amount <span>(*)</span></label>
                                        <input class="form-control" id="installment_amount" type="number" value="{{ $loan_details->installment_amount }}" name="installment_amount"  required  onkeyup="cal_installment();"/>
                                        <input type="hidden" name="no_installments" id="no_installments" value="{{ old('no_installments') }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="no_installments">No. of Installments</label>
                                        <input type="text" name="no_installments" id="no_installments" value="{{ old('no_installments') }}" class="form-control" readonly>
                                    </div>
                                </div> -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="deduction">Deduction <span>(*)</span></label>
                                        <select id="deduction" name="deduction"
                                            class="form-control" required>
                                            <option selected disabled value="">Select</option>
                                            <option value="Y" @if($loan_details->deduction=="Y") selected @endif>Yes</option>
                                            <option value="N" @if($loan_details->deduction=="N") selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-plus"></i>&nbsp;Update</button>
                                    
                                </div>
                            </div>
							<p>(*) marked fields are mandatory</p>
						</form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
@section('js')
<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initailizeSelect2();
    });
    // Initialize select2
    function initailizeSelect2() {

        $(".select2_el").select2();
    }

    function select2_reset(){
        $(".select2_el").val(null).trigger('change');
    }

    function cal_installment(){
        var loan_amount=$("#loan_amount").val();
        if(loan_amount=='') loan_amount=0;
        var installment_amount=$("#installment_amount").val();
        if(installment_amount=='') installment_amount=0;
        if(installment_amount>0){
            var installments=Math.round((eval(loan_amount)/eval(installment_amount))*100)/100;
            $("#no_installments").val(installments);
        }else{
            if(loan_amount>0){
                $("#no_installments").val(1);
            }else{
                $("#no_installments").val(0);
            }
        }
    }

    function validate(){
        //alert($("#installment_amount").val());
        if(eval($("#installment_amount").val())>eval($("#loan_amount").val())){
            alert("Installment Amount can't be greater than Loan Amount.");
            $("#installment_amount").focus();
            return false;
        }
        return true;
    }
</script>
@endsection