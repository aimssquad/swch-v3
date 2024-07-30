<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExcelFileExportComplain implements FromCollection,WithHeadings
{
	private $sd;
	private $ed;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($start_date,$end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
	
		 
    }
    public function collection()
    {
        
          	$candidate_rs=DB::table('complain')
				     
								->whereBetween('cr_date', [$this->start_date, $this->end_date])
  
							->select('complain.*')
                            ->get();
         

    	$f=1;
				 foreach($candidate_rs as $open)
     {
		  $employee_desigrs=DB::table('users_admin_emp')
     ->where('employee_id', '=',  $open->cr_by)
   
  ->first();
  	 $employee_or=DB::table('registration')
     ->where('reg', '=',  $open->emid)
    ->where('reg', 'like',  'EM%')
  ->first();
  $com='';
  if(!empty( $employee_or)) { $com= $employee_or->com_name ; }
  $or='';
if($open->cat_name=='Others') { $or='( '.  $open->others  .')'; }

$up_date='';
if($open->up_date!=''){
$up_date=date('d/m/Y',strtotime($open->up_date)) ;
}
$close_date='';
if($open->close_date!=''){
$close_date=date('d/m/Y',strtotime($open->close_date)) ;
}

      $customer_array[] = array(
       'Sl No'  => $f,
       'Project Name'   =>$open->p_name,
       'Complain Type'    => $open->cat_name.''.$or,
       'Organisation Name'  => $com,
       'Complain By'   => $employee_desigrs->name,
	   'Description'   => $open->descrption,
	   'Status'   => ucwords($open->status),
	   'Complain Date '   => date('d/m/Y',strtotime($open->cr_date)),
	    'Complain Update Date '   => $up_date,
	     'Complain Closed Date  '   => $close_date,
	      'Remarks '   => $open->remarks
      );

   $f++;}
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No', 'Project Name', 'Complain Type', 'Organisation Name', 'Complain By', 'Description', 'Status', 'Complain Date ', 'Complain Update Date ',
             'Complain Closed Date ',
              'Remarks',
        ];
    }
}$f=1;