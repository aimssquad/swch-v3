<?php
$increment=0;			   
		
	  $data['result']='';
	  
	$employeenmae=DB::Table('employee')
            
			 
            ->where('emid', '=', $Roledata->reg )
           
			->where('emp_code', '=', $employee_code )
			
               ->select('employee.*')
               ->distinct()
              ->first();
		
		

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<!-- CSS Files -->
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
	
</head>



<style>
.custom-template {
	position: fixed;
	top: 50%;
	transform: translateY(-50%);
	right: -325px;
	width: 325px;
	height: max-content;
	display: block;
	z-index: 1;
	background: #ffffff;
	transition: all .3s;
	z-index: 1003;
	box-shadow: -1px 1px 20px rgba(69, 65, 78, 0.15);
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
	transition: all .5s;
}

.custom-template.open {
	right: 0px;
}
.card-title span{
float: right;
    background: #1269db;
    color: #fff;
    padding: 5px 15px;border-radius:5px;
}
.card-title span a{color:#fff;}
.custom-template .custom-toggle {
	position: absolute;
	width: 45px;
	height: 45px;
	background: rgb(88, 103, 221);
	top: 50%;
	left: -45px;
	transform: translateY(-50%);
	display: flex;
	align-items: center;
	justify-content: center;
	text-align: center;
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
	border-right: 1px solid #177dff;
	cursor: pointer;
	color: #ffffff;
	box-shadow: -5px 5px 20px rgba(69, 65, 78, 0.21);
}

.custom-template .custom-toggle i {
	font-size: 20px;
	animation: 1.3s spin linear infinite;
}

.custom-template .title{
    padding: 15px;
    text-align: left;
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
    border-top-left-radius: 5px;
    border-bottom: 1px solid #ebedf2;
    background: #5867dd;
}

.custom-template .custom-content{
	padding: 20px 15px;
	max-height: calc(100vh - 90px);
	overflow: auto;
}

.custom-template .switcher {
	padding: 5px 0;
}

.custom-template .switch-block h4 {
	font-size: 13px;
	font-weight: 600;
	color: #444;
	line-height: 1.3;
	margin-bottom: 0;
	text-transform: uppercase;
}

.custom-template .btnSwitch {
	margin-top: 20px;
	margin-bottom: 25px;
}

.custom-template .btnSwitch button {
	border: 0px;
	height: 20px;
	width: 20px;
	outline: 0;
	margin-right: 10px;
	margin-bottom: 10px;
	cursor: pointer;
	padding: 0;
	border-radius: 50%;
	border: 2px solid #eee;
	position: relative;
	transition: all .2s;
}

.custom-template .btnSwitch button:hover{
	border-color: #0bf;
}

.custom-template .btnSwitch button.selected{
	border-color: #0bf;
}

.custom-template .img-pick {
	padding: 4px;
	min-height: 100px;
	border-radius: 5px;
	cursor: pointer;
}

.custom-template .img-pick img {
	height: 100%;
	height: 100px;
	width: 100%;
	border-radius: 5px;
	border: 2px solid transparent;
}

.custom-template .img-pick:hover img, .custom-template .img-pick.active img{
	border-color: #177dff;
}

.demo .btn, .demo .progress{
	margin-bottom: 15px !important;
}

.demo .form-check-label, .demo .form-radio-label{
	margin-right: 15px;
}

.demo .toggle, .demo .btn-group{
	margin-right: 15px;
}

.demo #slider{
	margin-bottom: 15px;
}

.table-typo tbody > tr > td{
	border-color: #fafafa;
}

.table-typo tbody > tr > td:first-child{
	min-width: 200px;
	vertical-align: bottom;
}

.table-typo tbody > tr > td:first-child p{
	font-size: 14px;
	color: #333;
}

.demo-icon {
	display: flex;
	flex-direction: row;
	align-items: center;
	margin-bottom: 20px;
	padding: 10px;
	transition: all .2s;
}

.demo-icon:hover{
	background-color: #f4f5f8;
	border-radius: 3px;
}

.demo-icon .icon-preview{
	font-size: 1.8rem;
	margin-right: 10px;
	line-height: 1;
	color: #333439;
}

body[data-background-color="dark"] .demo-icon .icon-preview {
	color: #969696;
}

.demo-icon .icon-class{
	font-weight: 300;
	font-size: 13px;
	color: #777;
}

body[data-background-color="dark"] .demo-icon .icon-class {
	color: #a9a8a8;
}

.form-show-notify .form-control{
	margin-bottom: 15px;
}

.form-show-notify label{
	padding-top: 0.65rem;
}

.map-demo {
	height: 300px;
}

#instructions li{
	padding: 5px 0;
}

.row-demo-grid{
	margin-bottom: 15px;
}

.row-demo-grid [class^="col"]{
	text-align: center;
}

.row-demo-grid [class^="col"] .card-body{
	background: #ddd;
}

.btnSwitch button[data-color="white"] {
	background-color: #fff;
}
.btnSwitch button[data-color="grey"] {
	background-color: #f1f1f1;
}
.btnSwitch button[data-color="black"] {
	background-color: #191919;
}
.btnSwitch button[data-color="dark"] {
	background-color: #1a2035;
}
.btnSwitch button[data-color="blue"] {
	background-color: #1572E8;
}
.btnSwitch button[data-color="purple"] {
	background-color: #6861CE;
}
.btnSwitch button[data-color="light-blue"] {
	background-color: #48ABF7;
}
.btnSwitch button[data-color="green"] {
	background-color: #31CE36;
}
.btnSwitch button[data-color="orange"] {
	background-color: #FFAD46;
}
.btnSwitch button[data-color="red"] {
	background-color: #F25961;
}
.btnSwitch button[data-color="dark2"] {
	background-color: #1f283e;
}
.btnSwitch button[data-color="blue2"] {
	background-color: #1269DB;
}
.btnSwitch button[data-color="purple2"] {
	background-color: #5C55BF;
}
.btnSwitch button[data-color="light-blue2"] {
	background-color: #3697E1;
}
.btnSwitch button[data-color="green2"] {
	background-color: #2BB930;
}
.btnSwitch button[data-color="orange2"] {
	background-color: #FF9E27;
}
.btnSwitch button[data-color="red2"] {
	background-color: #EA4d56;
}
.btnSwitch button[data-color="bg1"] {
	background-color: #fafafa;
}
.btnSwitch button[data-color="bg2"] {
	background-color: #fff;
}
.btnSwitch button[data-color="bg3"] {
	background-color: #f1f1f1;
}
/******************Absent Card Report************************/
.app-form-text h5{
  color: #6D7071;
  font-size: 14px;
}
.app-form-text h5 span{
  color: #6D7071;
  padding-left: 10px;


}





/*****************Daily-Attendance*****************************/
.table td, .table th {
    font-size: 14px!important;
    padding: 0 18px!important;
}


/********************Absent Record Card*******************/
/***********************************************/
                          /*Table*/
/****************************************************/
.table-calender-bg{
  text-align: center;	
}
.table-calender-text{
	color: #000;
}
.table-calender-text{
	text-align: left;
	padding-left: 134px;
}
.table-calender-header{
	color: #000;
	margin: 20px 0;
}
.table-calender-text h2 span{
	/*border-bottom: 1px solid #000;*/
}
.table-calender-text{
	float: left;
	margin: 20px 0;
	padding: 0px 3px 0px 134px;
}
.table-calender-text p{
	color: #000;
	font-size: 20px;
	float: left;
    padding-right: 100px;
}
.table-calender{
	text-align: center;
    width: 80%;
    margin: 0 auto;
}

.table-calender th,td{
 text-align: center;
 color: #000;
 font-weight: 600;
 width: 2%;
}
.tr-calender td{
	text-align: center;
	color: #000;
    font-weight: 600;
}

.mo{    background: #d4f3ff;}



/***********************************************************/
@media screen and (max-width: 550px){
	.table-typo tr td{
		display: flex;
		align-items: center;
		word-break: break-word;
	}

	.table-typo tr td:first-child p{
		margin-bottom: 0px;
	}
}

@media screen and (max-width: 576px){
	.custom-template .custom-content {
		overflow: auto;
	}
	.form-show-notify > .text-right, .form-show-validation > .text-right {
		text-align: left !important;
	}
}

@media screen and (max-width: 400px) {
	.custom-template {
		width: 85% !important;
		right: -85%;
	}
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  text-align: left;    
}

@page {
  size: A4 landscape;
}
</style>


<body style="height:100%;">
<div class="table-calender-bg">

<div class="table-calender-header">
<h1>ABSENCE RECORD CARD</h1>
</div>



<table class="table-calender">

<div class="table-calender-text">
  <!-- <p>Employment Type:  &nbsp;  &nbsp; &nbsp; &nbsp; Employee Code:  &nbsp;  &nbsp; &nbsp; &nbsp; Employee Name:  &nbsp;  &nbsp; &nbsp; &nbsp; Year:   </p> -->

  <p><span style="color:#06b3e7">Department :</span> <span style="border-bottom:1px dashed #000">{{$employeenmae->emp_department}}</span></p>
    <p><span style="color:#06b3e7">Designation :</span> <span style="border-bottom:1px dashed #000">{{$employeenmae->emp_designation}}</span></p>
  <p><span style="color:#06b3e7">Employee Code:</span>  <span style="border-bottom:1px dashed #000">{{$employeenmae->emp_code}}</span></p>
  <p><span style="color:#06b3e7">Employee Name:</span>  <span style="border-bottom:1px dashed #000">{{$employeenmae->emp_fname}}   {{$employeenmae->emp_mname}}   {{$employeenmae->emp_lname}}</span></p>
  <p><span style="color:#06b3e7">Year:</span> <span style="border-bottom:1px dashed #000">{{ $year_value}}</span></p>
</div>

  <tr style="background: #d0cccc;">
    <th></th>
    <th>1</th>
    <th>2</th>
    <th>3</th>
    <th>4</th>
    <th>5</th>
    <th>6</th>
    <th>7</th>
    <th>8</th>
    <th>9</th>
    <th>10</th>
    <th>11</th>
    <th>12</th>
    <th>13</th>
    <th>14</th>
    <th>15</th>
    <th>16</th>
    <th>17</th>
    <th>18</th>
    <th>19</th>
    <th>20</th>
    <th>21</th>
    <th>22</th>
    <th>23</th>
    <th>24</th>
    <th>25</th>
    <th>26</th>
    <th>27</th>
    <th>28</th>
    <th>29</th>
    <th>30</th>
    <th>31</th>
  </tr>


<?php
for($y=1;$y<13;$y++){
      $off_day=0;
                   $sun='';
                   $mon='';
                   $tue='';
                  $wed='';
                  $thu='';
                  $fri='';
                  $sat='';
		    if($y<=9){
		        $y='0'.$y;
		    }else{
		        $y=$y;
		    }
		    $my_year=$year_value;
		     $first_day_this_year = $year_value.'-'.$y.'-01'; 
		   if($y=='01' || $y=='03' || $y=='05' || $y=='07' || $y=='08' || $y=='10' || $y=='12'){
		       $last_day_this_year  = $year_value.'-'.$y.'-31' ;
		       $last_day='31';
		   }
        
      if($y=='04' || $y=='06' || $y=='09' || $y=='11' ){
		       $last_day_this_year  = $year_value.'-'.$y.'-30' ;
		         $last_day='30';
		   }
        
       if($y=='02'){
          if ($my_year % 400 == 0){
            $last_day_this_year  = $year_value.'-'.$y.'-29' ;
		        $last_day='29';   
          }
    
   if ($my_year % 4 == 0){
      $last_day_this_year  = $year_value.'-'.$y.'-29' ;
		        $last_day='29';    
   }
     
   else if ($my_year % 100 == 0){
       $last_day_this_year  = $year_value.'-'.$y.'-28' ;
		        $last_day='28';   
   }
      
   else
     {
        $last_day_this_year  = $year_value.'-'.$y.'-28' ;
		        $last_day='28';    
     }
		      
		   }
     
      $filename=
       
		$per_day_salary=$late_salary_deducted=$no_of_days_salary_deducted=$no_of_days_salary=0;
                
		$working_day=30;
		
		  $holidays=DB::table('holiday')->where('from_date','>=',$first_day_this_year)
	->where('to_date','<=', $last_day_this_year)
	->where('emid', '=', $Roledata->reg )
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
		 
        $total_wk_days=0;
		$date1_ts = strtotime($first_day_this_year);
	  $date2_ts = strtotime($last_day_this_year);
	  $diff = $date2_ts - $date1_ts;
		 
	 
      $total_wk_days=(round($diff / 86400)+1);
		
		
	
		$emp_v=$employee_code;
		$employee_data_new=DB::Table('employee')
             
            ->where('emid', '=', $Roledata->reg )
           
			->where('emp_code', '=', $emp_v )
			
               ->select('employee.*')
             
              ->first();
              $join_date='';
              	
		 if($employee_data_new->emp_doj!='1970-01-01'){ if($employee_data_new->emp_doj!=''){ $join_date= $employee_data_new->emp_doj;} }  
	
		  $employee_rs=DB::Table('employee')
              ->join('attandence','employee.emp_code','=','attandence.employee_code')
			   ->whereBetween('attandence.date', [$first_day_this_year, $last_day_this_year])
            ->where('employee.emid', '=', $Roledata->reg )
              ->where('attandence.emid', '=', $Roledata->reg )
			->where('employee.emp_code', '=', $emp_v )
			
               ->select('employee.*')
               ->distinct()
              ->get();
        
	 
              
               if(count($employee_rs)!=0){
	  
	 
    foreach($employee_rs as $emp)
    {
        $yes=date('Y',strtotime($first_day_this_year));
       
         $duty_authco = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                    ->where('start_date','like',$yes.'%')
	
                  ->orderBy('id', 'DESC')
                  ->get();
       if(count($duty_authco)==1){
          $duty_auth = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                    ->where('end_date','>=',$first_day_this_year)
	
                  ->orderBy('id', 'DESC')
                  ->first();  
       }else if(count($duty_authco)>1){
            $duty_auth = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                  
	->where('start_date','>=',$first_day_this_year)				  
                  ->where('end_date','<=',$last_day_this_year)
                  ->orderBy('id', 'DESC')
                  ->first();  
       }
		
  							
                  $offg=array();
                 
                    if(!empty($duty_auth)){
                        
                
                   	 $shift_auth = DB::table('shift_management')      
                 
                    ->where('id','=',$duty_auth->shift_code)
                  
                  ->where('emid','=',$Roledata->reg) 
                  ->orderBy('id', 'DESC')
                  ->first();
                   $off_auth = DB::table('offday')      
                  
                    ->where('shift_code','=',$duty_auth->shift_code)
                   
                  ->where('emid','=',$Roledata->reg) 
                  ->orderBy('id', 'DESC')
                  ->first();
                  
                  
                  
                  
                   $off_day=0;
                   $sun='';
                   $mon='';
                   $tue='';
                  $wed='';
                  $thu='';
                  $fri='';
                  $sat='';
                  if(!empty($off_auth)){
                   if($off_auth->sun=='1' ){
                    $sun='Sunday';
                   $off_day=$off_day+1;
                    $offg[]='Sunday';
                  }
                  if($off_auth->mon=='1' ){
                    $off_day=$off_day+1;
                     $mon='Monday';
                      $offg[]='Monday';
                  } 
                  
                   if($off_auth->tue=='1' ){
                  $off_day=$off_day+1;
                   $tue='Tuesday';
                     $offg[]='Tuesday';
                  } 
                  
                  
                   if($off_auth->wed=='1' ){
                   $off_day=$off_day+1;
                     $wed='Wednesday';
                      $offg[]='Wednesday';
                  } 
                  
                  if($off_auth->thu=='1' ){
                  $off_day=$off_day+1;
                    $thu='Thursday';
                    $offg[]='Thursday';
                  } 
                  
                  if($off_auth->fri=='1' ){
                  $off_day=$off_day+1;
                    $fri='Friday';
                     $offg[]='Friday';
                  } 
                  if($off_auth->sat=='1' ){
                    $off_day=$off_day+1;
                     $sat='Saturday';
                     $offg[]='Saturday';
                  } 
                  
                  
                  
                  }
                      $new_off=0;
                  for($we=date('d',strtotime($first_day_this_year));$we<=$total_wk_days;$we++){
                      
                      if($we<10 && $we!='01'){
                          $we='0'.$we;
                      }else if($we=='01'){
                          $we=$we;
                      }else{
                          $we=$we;
                      }
                     
                       $new_f=date('Y-m',strtotime($first_day_this_year)).'-'.$we;
                   
                     if($off_day>1){
                         if (in_array(  date('l',strtotime($new_f)), $offg))
  {
  $new_off=$new_off+1;
  }
else
  {
  
  }
                         
                     }
                  }
                 $off_day= $new_off;  
                    }else{
                       $off_day=0;    
                    }
					     
		?>
		
  <tr class="tr-calender">
    <td class="mo">{{date('M',strtotime($y.'/10/2020'))}}</td>
           <?php
    
    for($m=1;$m<32;$m++){
         if($m<=9){
		        $m='0'.$m;
		    }else{
		        $m=$m;
		    }
		    if($last_day>=$m){
		        
		    
		    $nfd=$y.'/'.$m.'/'.$year_value;
		     $Roledatad =DB::table('duty_roster')
	 
		
		->whereDate('start_date', '<=', $nfd)
            ->whereDate('end_date', '>=', $nfd)
		 
		->where('duty_roster.employee_id', '=', $emp_v )
			->where('duty_roster.emid', '=', $Roledata->reg )
->first();
		
           $att=DB::table('attandence')      
                  
                    ->where('employee_code','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                    ->where('date','=',$year_value.'-'.$y.'-'.$m) 
                  ->orderBy('id', 'DESC')
                  ->first(); 
                   $laevepp=DB::table('leave_apply')      
                  
                    ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                  ->where('from_date','<=',$year_value.'-'.$y.'-'.$m)
	->where('to_date','>=',$year_value.'-'.$y.'-'.$m)
                  ->where('status','=','APPROVED') 
                  ->orderBy('id', 'DESC')
                  ->first();
                   $laeveppnrejj=DB::table('leave_apply')      
                  
                  ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                  ->where('from_date','<=',$year_value.'-'.$y.'-'.$m)
	->where('to_date','>=',$year_value.'-'.$y.'-'.$m)
                  ->where('status','!=','APPROVED') 
                  ->orderBy('id', 'DESC')
                  ->first();
                   
                 
                if($join_date<=$year_value.'-'.$y.'-'.$m) {
					  $add='';
					    if(!empty($laevepp) || !empty($laeveppnrejj)){
							if(!empty($laevepp)){
								$leave_typenewmm=$laevepp->leave_type;
							}
							if(!empty($laeveppnrejj)){
								$leave_typenewmm=$laeveppnrejj->leave_type;
							}
							$leave_tyepenew=DB::table('leave_type')->where('id','=',$leave_typenewmm)->first(); 
	 
					if($leave_tyepenew->alies=='H' && in_array(  date('l',strtotime($nfd)), $offg)){
							 $add='yes'; 
						}else{
							 $add='no'; 
						}
							
						}else{
							 $add='no'; 
						}
                    if(in_array( $year_value.'-'.$y.'-'.$m, $offgholi)){
                         ?>
     <td>PH</td>
    
    <?php } 
                    
     else if(!empty($att) && empty($laevepp) && empty($laeveppnrejj)){  
         
         
    ?>
     <td>P</td>
    
    <?php }else if((!empty($laevepp) || !empty($laeveppnrejj))  && $join_date!=$nfd && $add=='no'){
         
          if(!empty($laevepp)){
                              $laeveppnrnamee=DB::table('leave_type')      
                  
                    ->where('id','=',$laevepp->leave_type) 
                  
                  ->first();
                  if($laeveppnrnamee->leave_type_name=='Holiday'){
                             $lc='H';
                         }else{
                              $lc=$laeveppnrnamee->alies;
                         }
                               }
                         
                         if(!empty($laeveppnrejj)){
                              $laeveppnrnamee=DB::table('leave_type')      
                  
                    ->where('id','=',$laeveppnrejj->leave_type) 
                  
                  ->first();
                             $lc='U';
                         }
        
        
       ?>
      <td>{{$lc}}</td>
    
    
   
    <?php   
     }else if(isset($sun) && $sun!='' && $sun==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
    else if(isset($mon) && $mon!='' && $mon==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
     else if(isset($tue) && $tue!='' && $tue==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
     else if(isset($wed) && $wed!='' && $wed==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
      else if(isset($thu) && $thu!='' && $thu==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
     else if(isset($fri) && $fri!='' && $fri==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
     else if(isset($sat) && $sat!='' && $sat==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    } 
    else{
    
    
    
				   if(count($duty_authco)==1){
          $duty_auth_new_oow = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                    ->where('end_date','>=',$first_day_this_year)
	
                  ->orderBy('id', 'DESC')
                  ->first();  
       }else if(count($duty_authco)>1){
            $duty_auth_new_oow = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                  
	->where('start_date','>=',$first_day_this_year)				  
                  ->where('end_date','<=',$last_day_this_year)
                  ->orderBy('id', 'DESC')
                  ->first();  
       }
    if(empty($duty_auth_new_oow)){
		
		
		
		
   ?>
      <td></td>
    
    
   
    <?php 
	}else{
		 if(empty( $Roledatad) ){
				
   ?>
      <td></td>
    
    
   
    <?php  
		 }else{
			 
			?>
      <td>A</td>
    
    
   
    <?php  
			 
		 }
			
		} }
                    
                    
                }
    
    else{
		     ?>
      <td></td>
    <?php    
		    }
		    }else{
		     ?>
      <td></td>
    <?php    
		    }
    }?>
    
  </tr>

  <?php
    }
               }
               else{
                 	$emp_v=$employee_code;
		  $employeepp=DB::Table('employee')
              
            ->where('emid', '=', $Roledata->reg )
            
			->where('.emp_code', '=', $emp_v )
			
               ->select('employee.*')
               ->distinct()
              ->first();
              
              
  							 $yes=date('Y',strtotime($first_day_this_year));
       
         $duty_authco = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp_v) 
                  ->where('emid','=',$Roledata->reg) 
                    ->where('start_date','like',$yes.'%')
	
                  ->orderBy('id', 'DESC')
                  ->get();
                  
       if(count($duty_authco)==1){
          $duty_auth = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp_v) 
                  ->where('emid','=',$Roledata->reg) 
                    ->where('end_date','>=',$first_day_this_year)
	
                  ->orderBy('id', 'DESC')
                  ->first();  
       }else if(count($duty_authco)>1){
            $duty_auth = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp_v) 
                  ->where('emid','=',$Roledata->reg) 
                  
	->where('start_date','>=',$first_day_this_year)				  
                  ->where('end_date','<=',$last_day_this_year)
                  ->orderBy('id', 'DESC')
                  ->first();  
       }
      
        
		
                    if(!empty($duty_auth)){
                        
                   	 $shift_auth = DB::table('shift_management')      
                 
                    ->where('id','=',$duty_auth->shift_code)
                  
                  ->where('emid','=',$Roledata->reg) 
                  ->orderBy('id', 'DESC')
                  ->first();
                   $off_auth = DB::table('offday')      
                  
                    ->where('shift_code','=',$duty_auth->shift_code)
                   
                  ->where('emid','=',$Roledata->reg) 
                  ->orderBy('id', 'DESC')
                  ->first();
                  
                  
                  
                  
                   $off_day=0;
                   $sun='';
                   $mon='';
                   $tue='';
                  $wed='';
                  $thu='';
                  $fri='';
                  $sat='';
                    if(!empty($off_auth)){
                   if($off_auth->sun=='1' ){
                    $sun='Sunday';
                   $off_day=$off_day+1;
                    $offg[]='Sunday';
                  }
                  if($off_auth->mon=='1' ){
                    $off_day=$off_day+1;
                     $mon='Monday';
                      $offg[]='Monday';
                  } 
                  
                   if($off_auth->tue=='1' ){
                  $off_day=$off_day+1;
                   $tue='Tuesday';
                     $offg[]='Tuesday';
                  } 
                  
                  
                   if($off_auth->wed=='1' ){
                   $off_day=$off_day+1;
                     $wed='Wednesday';
                      $offg[]='Wednesday';
                  } 
                  
                  if($off_auth->thu=='1' ){
                  $off_day=$off_day+1;
                    $thu='Thursday';
                    $offg[]='Thursday';
                  } 
                  
                  if($off_auth->fri=='1' ){
                  $off_day=$off_day+1;
                    $fri='Friday';
                     $offg[]='Friday';
                  } 
                  if($off_auth->sat=='1' ){
                    $off_day=$off_day+1;
                     $sat='Saturday';
                     $offg[]='Saturday';
                  } 
                  
                  
                  
                  }
                    $new_off=0;
                  for($we=date('d',strtotime($first_day_this_year));$we<=$total_wk_days;$we++){
                      
                      if($we<10 && $we!='01'){
                          $we='0'.$we;
                      }else if($we=='01'){
                          $we=$we;
                      }else{
                          $we=$we;
                      }
                     
                       $new_f=date('Y-m',strtotime($first_day_this_year)).'-'.$we;
                   
                     if($off_day>1){
                         if (in_array(  date('l',strtotime($new_f)), $offg))
  {
  $new_off=$new_off+1;
  }
else
  {
  
  }
                         
                     }
                  }
                 $off_day= $new_off;  
                    }else{
                       $off_day=0;    
                    }
		
              
                  
              
                 ?>
                   <tr class="tr-calender">
    <td class="mo">{{date('M',strtotime($y.'/10/2020'))}}</td>
       <?php
    
    for($m=1;$m<32;$m++){
         if($m<=9){
		        $m='0'.$m;
		    }else{
		        $m=$m;
		    }
		     $nfd=$y.'/'.$m.'/'.$year_value;
			   $Roledatad =DB::table('duty_roster')
	 
		
		->whereDate('start_date', '<=', $nfd)
            ->whereDate('end_date', '>=', $nfd)
		 
		->where('duty_roster.employee_id', '=', $emp_v )
			->where('duty_roster.emid', '=', $Roledata->reg )
->first();
		     
		    if($last_day>=$m){
		        
           $att=DB::table('attandence')      
                  
                    ->where('employee_code','=',$employeepp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                    ->where('date','=',$year_value.'-'.$y.'-'.$m) 
                  ->orderBy('id', 'DESC')
                  ->first();
                  
                 $laevepp=DB::table('leave_apply')      
                  
                    ->where('employee_id','=',$employeepp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                  ->where('from_date','<=',$year_value.'-'.$y.'-'.$m)
	->where('to_date','>=',$year_value.'-'.$y.'-'.$m)
                  ->where('status','=','APPROVED') 
                  ->orderBy('id', 'DESC')
                  ->first();
                
                $laeveppnrejj=DB::table('leave_apply')      
                  
                  ->where('employee_id','=',$employeepp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                  ->where('from_date','<=',$year_value.'-'.$y.'-'.$m)
	->where('to_date','>=',$year_value.'-'.$y.'-'.$m)
                  ->where('status','!=','APPROVED') 
                  ->orderBy('id', 'DESC')
                  ->first();
              if($join_date<=$year_value.'-'.$y.'-'.$m) {  
			    $add='';
					    if(!empty($laevepp) || !empty($laeveppnrejj)){
							if(!empty($laevepp)){
								$leave_typenewmm=$laevepp->leave_type;
							}
							if(!empty($laeveppnrejj)){
								$leave_typenewmm=$laeveppnrejj->leave_type;
							}
							$leave_tyepenew=DB::table('leave_type')->where('id','=',$leave_typenewmm)->first(); 
	 
					if($leave_tyepenew->alies=='H' && in_array(  date('l',strtotime($nfd)), $offg)){
							 $add='yes'; 
						}else{
							 $add='no'; 
						}
							
						}else{
							 $add='no'; 
						}
                    if(in_array( $year_value.'-'.$y.'-'.$m, $offgholi)){
                         ?>
     <td>PH</td>
    
    <?php } 
                    
     else if(!empty($att) && empty($laevepp) && empty($laeveppnrejj) ){  
    ?>
     <td>P</td>
    
    <?php } else if((!empty($laevepp) || !empty($laeveppnrejj))  && $join_date!=$nfd && $add=='no'){
         
       if(!empty($laevepp)){
                              $laeveppnrnamee=DB::table('leave_type')      
                  
                    ->where('id','=',$laevepp->leave_type) 
                  
                  ->first();
                  if($laeveppnrnamee->leave_type_name=='Holiday'){
                             $lc='H';
                         }else{
                              $lc=$laeveppnrnamee->alies;
                         }
                               }
                         
                         if(!empty($laeveppnrejj)){
                              $laeveppnrnamee=DB::table('leave_type')      
                  
                    ->where('id','=',$laeveppnrejj->leave_type) 
                  
                  ->first();
                             $lc='U';
                         }
        
        
       ?>
      <td>{{$lc}}</td>
    
    
   
    <?php   
     }else if(isset($sun) && $sun!='' && $sun==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
    else if(isset($mon) && $mon!='' && $mon==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
     else if(isset($tue) && $tue!='' && $tue==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
     else if(isset($wed) && $wed!='' && $wed==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
      else if(isset($thu) && $thu!='' && $thu==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
     else if(isset($fri) && $fri!='' && $fri==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
     else if(isset($sat) && $sat!='' && $sat==date("l",strtotime($nfd))){
        
        ?>
      <td>Off</td>
    <?php 
        
        
    }
    
    else{
  	   if(count($duty_authco)==1){
          $duty_auth_new_oow = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                    ->where('end_date','>=',$first_day_this_year)
	
                  ->orderBy('id', 'DESC')
                  ->first();  
       }else if(count($duty_authco)>1){
            $duty_auth_new_oow = DB::table('duty_roster')      
                   
                    ->where('employee_id','=',$emp->emp_code) 
                  ->where('emid','=',$Roledata->reg) 
                  
	->where('start_date','>=',$first_day_this_year)				  
                  ->where('end_date','<=',$last_day_this_year)
                  ->orderBy('id', 'DESC')
                  ->first();  
       } 
    if(empty($duty_auth_new_oow)){
		
		
		
		
   ?>
      <td></td>
    
    
   
    <?php 
	}else{
		 if(empty( $Roledatad)){
				
   ?>
      <td></td>
    
    
   
    <?php  
		 }else{
			 
		?>
      <td>A</td>
    
    
   
    <?php	 
			 
		 }
		 
		} }
              }
    else{
     ?>
      <td></td>
    
    
   
    <?php   
    }    
		    }
    else{
     ?>
      <td></td>
    
    
   
    <?php   
    }
    }?>
  </tr>
                 <?php
                   
                   
                   
               }
      }
               
               ?>
</table>
	<table width="80%" style="margin:20px auto;border:none !important;">
	    <tr>
	         
	          <td style="border:none !important;"><p>A :  Authorised  Absence</p></td>
	         <td style="border:none !important;"><p>H :  Holiday</p></td>
	          <td style="border:none !important;"><p>L : Leave</p></td>
	          <td style="border:none !important;"><p>Off : Offday</p></td>
			   </tr>
			    <tr>
	        <td style="border:none !important;"><p>P : Present</p></td>
	        
	          
	             
	                <td style="border:none !important;"><p>PH :  Public Holiday</p></td>
	                 <td style="border:none !important;"><p>U :  Unauthorized Absent</p></td>
					   <td style="border:none !important;"><p>SL : Sick Leave</p></td>
					   </tr>
	   
	    </table>
</div>


</body>


<!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
</html>