<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportemployeeInformation implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($reg,$emp_id)
    {
       
		 $this->reg = $reg;
		 	 $this->emp_id = $emp_id;
		 
    }
    public function collection()
    {
          $employeedata = DB::table('employee')      
                 
                  ->where('emid','=',$this->reg) 
                  ->where('emp_code','=',$this->emp_id) 
                  ->first();
                  if($employeedata->emp_gender!='null'){ $gen= $employeedata->emp_gender;} else{ $gen='';}
                   $f=1; 
		   $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Employee Code',
       'Particulars'    =>  $employeedata->emp_code
      );
$f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Employee Name',
       'Particulars'    =>  $employeedata->emp_fname.''.$employeedata->emp_mname.''.$employeedata->emp_lname
      );
      $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Gender',
       'Particulars'    => $gen 
           
       
      );
       $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'NI Number',
       'Particulars'    => $employeedata->ni_no 
           
       
      );
      if( $employeedata->emp_dob!='1970-01-01' &&  $employeedata->emp_dob!=''  &&  $employeedata->emp_dob!='E11') { $dob= date('d/m/Y',strtotime($employeedata->emp_dob)) ;} elseif($employeedata->emp_code=='E11')   {  $dob= date('d/m/Y',strtotime($employeedata->emp_dob)); } 
       $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Date of Birth',
       'Particulars'    =>$dob
           
       
      );
      $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Marital Status',
       'Particulars'    => $employeedata->marital_status
           
       
      );
      
        $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Nationality',
       'Particulars'    => $employeedata->nationality
           
       
      );
       $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Email',
       'Particulars'    =>  $employeedata->emp_ps_email
           
       
      );
       $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Contact Number',
       'Particulars'    =>  $employeedata->emp_ps_phone
           
       
      );
      
       $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Alternative Number',
       'Particulars'    =>   $employeedata->em_contact
           
       
      );
       $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Department',
       'Particulars'    =>  $employeedata->emp_department
           
       
      );
      
        $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Designation',
       'Particulars'    =>  $employeedata->emp_designation
           
       
      );
      if($employeedata->emp_doj!='1970-01-01' && $employeedata->emp_doj!='' ){ $doj= date('d/m/Y',strtotime($employeedata->emp_doj));}else{
           $doj='';
      } 
        $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Date of Joining',
       'Particulars'    =>  $doj
           
       
      );
      
        $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Employment  Type',
       'Particulars'    =>  $employeedata->emp_status
           
       
      );
      
       $f++;
       if($employeedata->date_confirm!='1970-01-01' && $employeedata->date_confirm!='' ){ $doc=  date('d/m/Y',strtotime($employeedata->date_confirm));} else{
           $doc='';
      }  
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Date of Confirmation',
       'Particulars'    =>  $doc
           
       
      );
      
       $f++;
       if($employeedata->start_date!='1970-01-01' && $employeedata->start_date!='' ){ $doc=  date('d/m/Y',strtotime($employeedata->start_date));} else{
           $doc='';
      }  
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Contract Start Date',
       'Particulars'    =>  $doc
           
       
      );
       $f++;
       if($employeedata->end_date!='1970-01-01' && $employeedata->end_date!='' ){ $doc=  date('d/m/Y',strtotime($employeedata->end_date));} else{
           $doc='';
      }  
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Contract End Date',
       'Particulars'    =>  $doc
           
       
      );
       $f++;
      
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Job Location',
       'Particulars'    =>  $employeedata->job_loc
           
       
      );
      
       $leave_allocation_rs = DB::table('employee_qualification')
                      ->where('emid','=',$this->reg)
                       ->where('emp_id','=',$employeedata->emp_code )
                 ->get();
             $f=19;    
    	if($leave_allocation_rs)
		{
			foreach($leave_allocation_rs as $leave_allocation)
			{
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Qualification',
       'Particulars'    =>  $leave_allocation->quli
           
       
      );    
		$f++;
		
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Subject',
       'Particulars'    => $leave_allocation->dis
           
       
      );    
		$f++;
		
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Institution Name ',
       'Particulars'    =>  $leave_allocation->ins_nmae
           
       
      );    
		$f++;
		
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Awarding Body/ University ',
       'Particulars'    => $leave_allocation->board
           
       
      );    
		$f++;
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Year of Passing',
       'Particulars'    =>  $leave_allocation->year_passing
           
       
      );    
		$f++;
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Percentage ',
       'Particulars'    =>  $leave_allocation->perce
           
       
      );    
		$f++;
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Grade/Division ',
       'Particulars'    =>$leave_allocation->grade
           
       
      );    
		$f++;
			if($leave_allocation->doc!=''){ $up='Uploaded'; }else{ $up='Not Uploaded'; }
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Transcript Document',
       'Particulars'    => $up
           
       
      );    
		$f++;
		if($leave_allocation->doc2!=''){ $up='Uploaded'; }else{ $up='Not Uploaded'; }
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Certificate Document ',
       'Particulars'    => $up
           
       
      );    
		$f++;
			}
		}
		
		 $tran_allocation_rs = DB::table('employee_job')
                      ->where('emid','=',$this->reg)
                       ->where('emp_id','=',$employeedata->emp_code )
                 ->get();
    	if($tran_allocation_rs)
		{
			foreach($tran_allocation_rs as $tran_allocation)
			{
			    
			    		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Job Title ',
       'Particulars'    =>  $tran_allocation->job_name
           
       
      );    
		$f++;
		if($tran_allocation->job_start_date!='1970-01-01' && $tran_allocation->job_start_date!='' ){ $doc=  date('d/m/Y',strtotime($tran_allocation->job_start_date));} else{
           $doc='';
      }  
		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Start Date ',
       'Particulars'    => $doc
           
       
      );    
		$f++;
			if($tran_allocation->job_end_date!='1970-01-01' && $tran_allocation->job_end_date!='' ){ $doc=  date('d/m/Y',strtotime($tran_allocation->job_end_date));} else{
           $doc='';
      }  
		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'End Date ',
       'Particulars'    => $doc
           
       
      );    
		$f++;
		
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Year of Experience ',
       'Particulars'    =>  $tran_allocation->exp
           
       
      );    
		$f++;
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Job Description  ',
       'Particulars'    =>  $tran_allocation->des
           
       
      );    
		$f++;
			}
			
		}
		  $traning_allocation_rs = DB::table('employee_training')
                      ->where('emid','=',$this->reg)
                       ->where('emp_id','=',$employeedata->emp_code )
                 ->get();
    	if($traning_allocation_rs)
		{
			foreach($traning_allocation_rs as $traning_allocation)
			{
			   	 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Training  Title',
       'Particulars'    =>  $traning_allocation->tarin_name
           
       
      );    
		$f++; 
			if($traning_allocation->tarin_start_date!='1970-01-01' && $traning_allocation->tarin_start_date!='' ){ $doc=  date('d/m/Y',strtotime($traning_allocation->tarin_start_date));} else{
           $doc='';
      }  
		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Training  Start Date ',
       'Particulars'    => $doc
           
       
      );    
		$f++; 
			if($traning_allocation->tarin_end_date!='1970-01-01' && $traning_allocation->tarin_end_date!='' ){ $doc=  date('d/m/Y',strtotime($traning_allocation->tarin_end_date));} else{
           $doc='';
      }  
		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Training  End Date ',
       'Particulars'    => $doc
           
       
      );    
		$f++; 
		   	 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Training  Description ',
       'Particulars'    =>  $traning_allocation->train_des
           
       
      );    
		$f++; 
			    
			    
			}
		}
		
		
		
		 	 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Next of Kin Contact Name',
       'Particulars'    =>  $employeedata->em_name
           
       
      );    
		$f++; 
		 if($employeedata->em_relation=='Others') { $re='('.  $employeedata->relation_others .')';} else{
		     $re='';
		 }
		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Next of Kin Contact Relationship',
       'Particulars'    =>  $re
           
       
      );    
		$f++; 
		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Next of Kin Contact Email',
       'Particulars'    =>  $employeedata->em_email
           
       
      );    
		$f++; 
			 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Next of Kin Contact Number',
       'Particulars'    =>  $employeedata->em_phone
           
       
      );    
		$f++; 
		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Next of Kin Contact Address',
       'Particulars'    =>  $employeedata->em_address
           
       
      );    
		$f++; 
		 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'COS  Number',
       'Particulars'    =>  $employeedata->cf_license_number
           
       
      );    
	
	 if( $employeedata->cf_start_date!='1970-01-01' &&  $employeedata->cf_start_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->cf_start_date)) ;} else{
           $doc='';
      }  
       $f++;
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'COS Number Start Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->cf_end_date!='1970-01-01' &&  $employeedata->cf_end_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->cf_end_date)) ;} else{
           $doc='';
      }  
       
 $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'COS Number End Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
      	$peradd='';
				$peradd=$employeedata->emp_pr_street_no;
				if( $employeedata->emp_per_village){ $peradd .=','. $employeedata->emp_per_village;} 
				if( $employeedata->emp_pr_state){ $peradd .=','. $employeedata->emp_pr_state
				;}  if( $employeedata->emp_pr_city){ $peradd .=','. $employeedata->emp_pr_city;}
  if( $employeedata->emp_pr_pincode){ $peradd .=','. $employeedata->emp_pr_pincode; }
  if( $employeedata->emp_pr_country){$peradd .=','.$employeedata->emp_pr_country; };
			
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Present Address',
       'Particulars'    =>$peradd
           
       
      );
      $f++;
      	if($employeedata->pr_add_proof!=''){ $up='Uploaded'; }else{ $up='Not Uploaded'; }
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Proof Of Present Address',
       'Particulars'    =>$up
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Passport No.',
       'Particulars'    =>$employeedata->pass_doc_no
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Nationality',
       'Particulars'    =>$employeedata->pass_nat
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Place of Birth',
       'Particulars'    =>$employeedata->place_birth
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Passport Issued By',
       'Particulars'    =>$employeedata->issue_by
           
       
      );
      $f++;
        if( $employeedata->pas_iss_date!='1970-01-01' &&  $employeedata->pas_iss_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->pas_iss_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Passport Issued Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->pass_exp_date!='1970-01-01' &&  $employeedata->pass_exp_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->pass_exp_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Passport Expiry Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->pass_review_date!='1970-01-01' &&  $employeedata->pass_review_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->pass_review_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Passport  Eligible Review  Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
      	if($employeedata->pass_docu!=''){ $up='Uploaded'; }else{ $up='Not Uploaded'; }
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Passport Document',
       'Particulars'    =>$up
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Is this your current passport?',
       'Particulars'    =>$employeedata->cur_pass
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Passport Remarks?',
       'Particulars'    =>$employeedata->remarks
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'BRP Number',
       'Particulars'    =>$employeedata->visa_doc_no
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Nationality',
       'Particulars'    =>$employeedata->visa_nat
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Country of Residence',
       'Particulars'    =>$employeedata->country_residence
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Visa Issued By',
       'Particulars'    =>$employeedata->visa_issue
           
       
      );
      $f++;
      
      
      
      
      
       if( $employeedata->visa_issue_date!='1970-01-01' &&  $employeedata->visa_issue_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->visa_issue_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Visa Issued Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->visa_exp_date!='1970-01-01' &&  $employeedata->visa_exp_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->visa_exp_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Visa Expiry Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->visa_review_date!='1970-01-01' &&  $employeedata->visa_review_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->visa_review_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Visa  Eligible Review  Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
      	if($employeedata->visa_upload_doc!=''){ $up='Uploaded'; }else{ $up='Not Uploaded'; }
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Visa Document',
       'Particulars'    =>$up
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Visa Remarks',
       'Particulars'    =>$employeedata->visa_remarks
           
       
      );
      
      
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'EUSS/Time limit Ref. No.',
       'Particulars'    =>$employeedata->euss_ref_no
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'EUSS/Time limit Nationality',
       'Particulars'    =>$employeedata->euss_nation
           
       
      );
      
      $f++;
      
       if( $employeedata->euss_issue_date!='1970-01-01' &&  $employeedata->euss_issue_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->euss_issue_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'EUSS/Time limit Issued Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->euss_exp_date!='1970-01-01' &&  $employeedata->euss_exp_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->euss_exp_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'EUSS/Time limit Expiry Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->euss_review_date!='1970-01-01' &&  $employeedata->euss_review_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->euss_review_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'EUSS/Time limit Eligible Review  Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
      	if($employeedata->euss_upload_doc!=''){ $up='Uploaded'; }else{ $up='Not Uploaded'; }
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'EUSS/Time limit Document',
       'Particulars'    =>$up
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'EUSS/Time limit Remarks',
       'Particulars'    =>$employeedata->euss_remarks
           
       
      );

      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'DBS Type',
       'Particulars'    =>$employeedata->dbs_type
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'DBS Ref. No.',
       'Particulars'    =>$employeedata->dbs_ref_no
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'DBS Nationality',
       'Particulars'    =>$employeedata->dbs_nation
           
       
      );
      
      $f++;
      
       if( $employeedata->dbs_issue_date!='1970-01-01' &&  $employeedata->dbs_issue_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->dbs_issue_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'DBS Issued Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->dbs_exp_date!='1970-01-01' &&  $employeedata->dbs_exp_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->dbs_exp_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'DBS Expiry Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->dbs_review_date!='1970-01-01' &&  $employeedata->dbs_review_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->dbs_review_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'DBS Eligible Review  Date',
       'Particulars'    =>$doc
           
       
      );

      $f++;
      if($employeedata->dbs_upload_doc!=''){ $up='Uploaded'; }else{ $up='Not Uploaded'; }
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'DBS Document',
       'Particulars'    =>$up
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'DBS Remarks',
       'Particulars'    =>$employeedata->dbs_remarks
           
       
      );
      
      
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'National Id No.',
       'Particulars'    =>$employeedata->nat_id_no
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'National Id Nationality',
       'Particulars'    =>$employeedata->nat_nation
           
       
      );
      $f++;
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'National Id Country of Residence',
       'Particulars'    =>$employeedata->nat_country_res
           
       
      );
      
      $f++;
      
       if( $employeedata->nat_issue_date!='1970-01-01' &&  $employeedata->nat_issue_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->nat_issue_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'National Id Issued Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->nat_exp_date!='1970-01-01' &&  $employeedata->nat_exp_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->nat_exp_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'National Id Expiry Date',
       'Particulars'    =>$doc
           
       
      );
      $f++;
       if( $employeedata->nat_review_date!='1970-01-01' &&  $employeedata->nat_review_date!='' ) { $doc= date('d/m/Y',strtotime($employeedata->nat_review_date)) ;} else{
           $doc='';
      }  
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'National Id Eligible Review  Date',
       'Particulars'    =>$doc
           
       
      );

      $f++;
      if($employeedata->nat_upload_doc!=''){ $up='Uploaded'; }else{ $up='Not Uploaded'; }
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'National Id Document',
       'Particulars'    =>$up
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'National Id Remarks',
       'Particulars'    =>$employeedata->nat_remarks
           
       
      );
      $f++;
      
       $employee_bank=DB::table('bank_masters')->where('id','=',$employeedata->emp_bank_name)->first();
       if(!empty($employee_bank)){
            $bank=$employee_bank->master_bank_name;
       }else{
          $bank=''; 
       }
       $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Bank Name',
       'Particulars'    =>$bank
           
       
      );
      $f++;
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Branch  Name',
       'Particulars'    =>$employeedata->bank_branch_id
           
       
      );
      $f++;
      
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Sort Code ',
       'Particulars'    =>$employeedata->emp_sort_code
           
       
      );
      $f++;
      
      $customer_array[] = array(
       'Sl No.'  => $f,
       'Type'   => 'Account Number',
       'Particulars'    =>$employeedata->emp_account_no
           
       
      );
      $f++;
	 return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No.', 'Type', 'Particulars',
        ];
    }
}