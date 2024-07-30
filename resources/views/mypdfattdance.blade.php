<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SWCH</title>
<style>
@media print {
   body {
      -webkit-print-color-adjust: exact;
   }
}
.odd_class tr:nth-child(even) {
    background-color: #ecebfd;
}
.mm {
    background-color: white;
}
</style>
</head>

<body style="webkit-print-color-adjust: exact; ">


<table class="odd_class" style="width:100%;font-family:cambria">
 <thead>
     <tr>
         <th style="width:130px;">
             <div style="border:2px solid #d00eff;"><img src="https://skilledworkerscloud.co.uk/hrms/img/logo.png" alt="" width="130px"></div>
         </th>
         <th style="text-align:right;">
             <p style="margin:0;font-size:15px">{{ $address }}<br />{{$addresssub}}</p>

	  <p style="margin:0;font-size:20px">Attendance Report</p>
         </th>
     </tr>
  <tr>
  </tr>
 </thead>
</table>

<table style="width:100%;font-family:cambria">
    <tr>
        <th calspan="2" style="width:90%; background-color: #fff!imporant;"><h2 style="font-size: 30px;    margin-bottom: 0;">{{ $com_name }}</h2></th>
    </tr>
</table>


<table style="width:100%;font-family:cambria">

 
 <?php
       
                   $employee_attendence=
       DB::table('employee')      
                  
                    ->where('emp_code','=',$employee_code) 
                  ->where('emid','=',$emid) 
                   
                  ->first();
                  ?>
</table>
<table class="odd_class" style="width:100%;margin-top: 50px;">
<tr>
<td>Employee Code:{{ $employee_attendence->emp_code }}</td>

<td style="text-align:right">Employee Name: {{ $employee_attendence->emp_fname }} {{ $employee_attendence->emp_mname }} {{ $employee_attendence->emp_lname }}	</td>
</tr>
<tr>
<td class="mm">Department: {{ $department_name }}</td>

<td style="text-align:right" class="mm">Designation: {{ $designation_name }}	</td>
</tr>
</table>
	 
<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
<thead style="background: #d00eff;">
  <tr>
    <th style="color:#fff">Sl No.</th>

	 <th style="color:#fff">Date</th>
	 <th style="color:#fff">Clock In</th>
	 <th style="color:#fff">Clock In Location</th>
	 <th style="color:#fff">Clock Out</th>
	 <th style="color:#fff">Clock Out Location</th>
	  <th style="color:#fff">Duty Hours</th>
  </tr>
 </thead>
<tbody>
    
    
    <?php
    $total_wk_days=0;
		$date1_ts = strtotime($start_date);
	  $date2_ts = strtotime($end_date);
	  $diff = $date2_ts - $date1_ts;
		
	 
      $total_wk_days=(round($diff / 86400)+1);
	   $holidays=DB::table('holiday')->where('from_date','>=',$start_date)
	->where('to_date','<=', $end_date)
	->where('emid', '=', $emid )
            ->get(); 
	   $totday=0;
	
       $offgholi=array();
        foreach($holidays as $holiday) 
        {
          $totday=$totday+$holiday->day;
         if($holiday->day>1){
             
             for($weh=date('d',strtotime($holiday->from_date));$weh<=date('d',strtotime($holiday->to_date));$weh++){
                  if($weh<10 && $weh!='01'){
                          $weh='0'.$weh;
                      }else if($weh=='01'){
                          $weh=$weh;
                      }else{
                          $weh=$weh;
                      }
                       
                      
                   $offgholi[]=date('Y-m',strtotime($holiday->from_date)).'-'.$weh;;
             }
         }else{
             $offgholi[]=$holiday->from_date;
         }
        }
if($employee_attendence->emp_doj!='1970-01-01'){ if($employee_attendence->emp_doj!=''){ $join_date= $employee_attendence->emp_doj;} } else{
		$join_date='';   
	   } 
		 
	 
                             $new_off=0;	
$fh=1;			
if(date('d',strtotime($start_date))>$total_wk_days){
      $total_wk_days=date('d',strtotime($start_date))+($total_wk_days-1);
}
 else if(date('d',strtotime($start_date))!=1){
      $total_wk_days=date('d',strtotime($start_date))+($total_wk_days-1);
}else{
    $total_wk_days=$total_wk_days;
}
if(date('d',strtotime($start_date))==date('d',strtotime($end_date))){
      $total_wk_days=date('d',strtotime($start_date));
}

	    for($we=date('d',strtotime($start_date));$we<=$total_wk_days;$we++){
		  if($we<10 && $we!='01'){
                          $we='0'.$we;
                      }else if($we=='01'){
                          $we=$we;
                      }else{
                          $we=$we;
                      }
                
                       $new_f=date('Y-m',strtotime($start_date)).'-'.$we;
					   $duty_auth = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$employee_code) 
                  ->where('emid','=',$emid)
  ->whereDate('start_date', '<=', $new_f)
            ->whereDate('end_date', '>=', $new_f)


                  ->orderBy('id', 'DESC')
                  ->first();
          
    $offg=array();
    
                    if(!empty($duty_auth)){
                        
                   	 $shift_auth = DB::table('shift_management')      
                 
                    ->where('id','=',$duty_auth->shift_code)
                  
                  ->where('emid','=',$emid) 
                  ->orderBy('id', 'DESC')
                  ->first();
                   $off_auth = DB::table('offday')      
                  
                    ->where('shift_code','=',$duty_auth->shift_code)
                   
                  ->where('emid','=',$emid) 
                  ->orderBy('id', 'DESC')
                  ->first();
                  
                
                 
                  
                   $off_day=0;
                  if(!empty($off_auth)){
                   if($off_auth->sun=='1' ){
                    
                   $off_day=$off_day+1;
                   $offg[]='Sunday';
                  }
                  if($off_auth->mon=='1' ){
                    $off_day=$off_day+1;
                     $offg[]='Monday';
                  } 
                  
                   if($off_auth->tue=='1' ){
                  $off_day=$off_day+1;
                   $offg[]='Tuesday';
                  } 
                  
                  
                   if($off_auth->wed=='1' ){
                   $off_day=$off_day+1;
                    $offg[]='Wednesday';
                  } 
                  
                  if($off_auth->thu=='1' ){
                  $off_day=$off_day+1;
                   $offg[]='Thursday';
                  } 
                  
                  if($off_auth->fri=='1' ){
                  $off_day=$off_day+1;
                    $offg[]='Friday';
                  } 
                  if($off_auth->sat=='1' ){
                    $off_day=$off_day+1;
                    $offg[]='Saturday';
                  } 
                  
                  
                  
                  }
					}
                        
		if($join_date<=$new_f) { 
		
		
		 if(!empty($duty_auth)){
   
                    
                    $laeveppnre=DB::table('leave_apply')      
                  
                    ->where('employee_id','=',$employee_code) 
                  ->where('emid','=',$emid) 
                  ->where('from_date','<=',$new_f)
	->where('to_date','>=',$new_f)
                  ->where('status','=','APPROVED') 
                  ->orderBy('id', 'DESC')
                  ->first();
                  
                  $laeveppnrejj=DB::table('leave_apply')      
                  
                    ->where('employee_id','=',$employee_code) 
                  ->where('emid','=',$emid) 
                  ->where('from_date','<=',$new_f)
	->where('to_date','>=',$new_f)
                  ->where('status','!=','APPROVED') 
                  ->orderBy('id', 'DESC')
                  ->first();
                   
                     if($off_day>=0 ){
                       if(!empty($laeveppnre) || !empty($laeveppnrejj)){
							if(!empty($laeveppnre)){
								$leave_typenewmm=$laeveppnre->leave_type;
							}
							if(!empty($laeveppnrejj)){
								$leave_typenewmm=$laeveppnrejj->leave_type;
							}
							$leave_tyepenew=DB::table('leave_type')->where('id','=',$leave_typenewmm)->first(); 
	 
					if($leave_tyepenew->alies=='H' && in_array(  date('l',strtotime($new_f)), $offg)){
							 $add='yes'; 
						}else{
							 $add='no'; 
						}
							
						}else{
							 $add='no'; 
						}
                      if((!empty($laeveppnre) || !empty($laeveppnrejj))  && $join_date!=$new_f  && $add=='no'){
                         
                              if(!empty($laeveppnre)){
                              $laeveppnrnamee=DB::table('leave_type')      
                  
                    ->where('id','=',$laeveppnre->leave_type) 
                  
                  ->first();
                  if($laeveppnrnamee->leave_type_name=='Holiday'){
                             $lc='Annual Leave';
                         }else{
                              $lc=$laeveppnrnamee->leave_type_name;
                         }
                               }
                         
                         if(!empty($laeveppnrejj)  && $join_date!=$new_f){
                              $laeveppnrnamee=DB::table('leave_type')      
                  
                    ->where('id','=',$laeveppnrejj->leave_type) 
                  
                  ->first();
                             $lc='Unauthorized Absent';
                         }
      ?>
  <tr>
    <td>{{$fh }}</td>

	<td>{{ date('d/m/Y',strtotime($new_f)) }}</td>

													<td>{{$lc}}</td>
													<td></td>
														<td></td>
													<td></td>
													<td></td>
							
  </tr>
 
                         <?php
					
  $fh++;
                             
                        }else{
                         if (in_array(  date('l',strtotime($new_f)), $offg))
  {  
 

 if (in_array( $new_f, $offgholi))
  {
         ?>
  <tr>
    <td>{{$fh }}</td>

	<td>{{ date('d/m/Y',strtotime($new_f)) }}</td>

													<td>Public Holiday</td>
													<td></td>
														<td></td>
													<td></td>
													<td></td>
							
  </tr>
 
                         <?php 
                         $fh++;
 
  }
  
  else if( $join_date==$new_f){
       $month_entrynew= DB::table('attandence')->where('month','=',date('m/Y', strtotime($start_date)))->where('date','=',$new_f)->where('employee_code','=',$employee_code) ->where('emid','=',$emid)->get();


if(count($month_entrynew)!=0){
	foreach($month_entrynew as $month_entry){
	
	 
  $datein = strtotime(date("Y-m-d ".$shift_auth->time_in));
			$dateout = strtotime(date("Y-m-d ".$shift_auth->time_out));
			$difference = abs($dateout - $datein)/60;
			$hours = floor($difference / 60);
		    $minutes = ($difference % 60);
			 $duty_hours= $hours.":".$minutes;
			
  $time_in='';
			 if($month_entry->time_in!=''){
				 
				$time_in=date('h:i a',strtotime($month_entry->time_in)); 
			 }
			 $time_out='';
			 if($month_entry->time_out!=''){
				 
				$time_out=date('h:i a',strtotime($month_entry->time_out)); 
			 }			?>
  <tr>
    <td>{{$fh }}</td>

	<td>{{ date('d/m/Y',strtotime($new_f)) }}</td>
<td>{{$time_in}}</td>
													<td>{{$month_entry->time_in_location}}</td>
														<td>{{$time_out}}</td>
													<td>{{$month_entry->time_out_location}}</td>
													<td>{{$month_entry->duty_hours}}</td>
							
  </tr>
 
                         <?php 
  
  
  $fh++;
}
}
   
  }
  else{
        ?>
  <tr>
    <td>{{$fh }}</td>

	<td>{{ date('d/m/Y',strtotime($new_f)) }}</td>

													<td>Offday</td>
													<td></td>
														<td></td>
													<td></td>
													<td></td>
							
  </tr>
 
                         <?php 

   
							
						
  
  $fh++;
  }
  
  }
else
  {
      if (in_array( $new_f, $offgholi))
  {
     
     
                         ?>
  <tr>
    <td>{{$fh }}</td>

	<td>{{ date('d/m/Y',strtotime($new_f)) }}</td>

													<td>Public Holiday</td>
													<td></td>
														<td></td>
													<td></td>
													<td></td>
							
  </tr>
 
                         <?php 

  
  $fh++;
  }else{
  
  $month_entrynew= DB::table('attandence')->where('month','=',date('m/Y', strtotime($start_date)))->where('date','=',$new_f)->where('employee_code','=',$employee_code) ->where('emid','=',$emid)->get();


if(count($month_entrynew)!=0){
	foreach($month_entrynew as $month_entry){
	
	 
  $datein = strtotime(date("Y-m-d ".$shift_auth->time_in));
			$dateout = strtotime(date("Y-m-d ".$shift_auth->time_out));
			$difference = abs($dateout - $datein)/60;
			$hours = floor($difference / 60);
		    $minutes = ($difference % 60);
			 $duty_hours= $hours.":".$minutes;
			  $time_in='';
			 if($month_entry->time_in!=''){
				 
				$time_in=date('h:i a',strtotime($month_entry->time_in)); 
			 }
			 $time_out='';
			 if($month_entry->time_out!=''){
				 
				$time_out=date('h:i a',strtotime($month_entry->time_out)); 
			 }
			    ?>
  <tr>
    <td>{{$fh }}</td>

	<td>{{ date('d/m/Y',strtotime($new_f)) }}</td>

			<td>{{$time_in}}</td>
			<td>{{$month_entry->time_in_location}}</td>
														
														<td>{{$time_out}}</td>
													<td>{{$month_entry->time_out_location}}</td>
													<td>{{$month_entry->duty_hours}}</td>
							
  </tr>
 
                         <?php 
  
  
  $fh++;
}
}
   
  
  }
  }
                         
                    }
                     }
		 
		 
		 }
		
		}
		
                    }
		
                    
    
    
    
    
    
		?>
 
</tbody>
</table>
</body>
</html>
