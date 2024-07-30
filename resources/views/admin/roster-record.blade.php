	<?php
										 $employee_desigrs=DB::table('users_admin_emp')
     ->where('employee_id', '=',  $departs->employee_id)
    
  ->first();
  $od0=0;
  $gg=0;
  ?>
  <!doctype html>
<head>
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
<style type="text/css">
	.sky {width: 54px;background: #00b2ee;height: 30px;float: left; margin-right: 10px;}.sky1{background: #00b2ee;}
	.yellow {width: 54px;background: #ffc000;height: 30px;float: left; margin-right: 10px;}.yellow1{background: #ffc000;}
	.data tr:nth-child(even) {background-color: #d8f5c2;}
</style>
</head>
<body>
	<table style="width:700px;margin: 2% auto;font-family: calibri;">
		<tr>
			<td style="width: 50%"><h4 style="margin-bottom: 0;">Employee Name - {{$employee_desigrs->name}} (Code : {{$employee_desigrs->employee_id}})</h4></td>
			
					
			<td style="width: 50%"><h4 style="margin-bottom: 0;">Duty Roster - {{date('F',strtotime($departs->start_date))}} ( {{date('d/m/Y',strtotime($departs->start_date)) }} To  {{date('d/m/Y',strtotime($departs->end_date)) }})</h4></td>
				</tr>
				    	<tr>
			<td style="width: 40%"><span class="sky"></span>Working  </td>
			<td style="width: 40%"><span class="yellow"></span> Non Working</td>
		</tr>
	</table>
	<table class="data" border="1" style="width: 700px;margin: auto;text-align:center;font-family: calibri;border-collapse: collapse;border-color: #fff;">
		<thead>
			<tr style="background: #71ac46;">
				<th style="width: 200px;color: #fff;">Date</th>
				<th style="width: 200px;color: #fff;">Day</th>
				<th>&nbsp;</th>
			
				<th style="width: 100px;color: #fff;">Days Total</th>
				<th style="width: 100px;color: #fff;">Start time</th>
				<th style="width: 100px;color: #fff;">End time</th>
					<th style="width: 100px;color: #fff;">Working Hours</th>
			</tr>
		</thead>
		<tbody>
  <?php
  $gg=0;
  $od0=0;
  $min=0;
  
  $start_mon=date('m',strtotime($departs->start_date));
  $end_mon=date('m',strtotime($departs->end_date));
 	 $dutydesigrs=DB::table('duty_emp_leave')
     ->where('a_id', '=',  $departs->id)
    
  ->get();
  
  foreach($dutydesigrs as $valo){
      
		    ?>
		    <tr>
		        <td ><?= date('jS',strtotime($valo->date));?> - <?= date('M',strtotime($valo->date));?> - <?= date('Y',strtotime($departs->start_date));?></td>
		        <td><?= date('l',strtotime($valo->date));?></td>
		    <?php
		  $ss=array();
		    $od0=$od0+$valo->day_tot;
		    if ($valo->hours!='' ) {
		        
		         $word='.';
                   if(strpos($valo->hours, $word) !== false){
                      
                       $ss=explode('.',$valo->hours) ;
		       $min=$min+ $ss['1'];
		      
		    $gg=$gg+$ss['0'];
		      
                   }else{
		     
		      
		    $gg=$gg+$valo->hours;
		    
                   }
		    }else{
		       $gg=$gg+0;  
		    }
		     if($valo->work==0){
		         
		       ?>
		       <td class="yellow1"  style="width: 50px;"></td>
		      
		       <?php
		        
		  
		     
		    }else{
		        
		     
		      ?>
		       <td class="sky1" style="width: 50px;"></td>
		      
		       <?php   
		    }
		    
		    ?>
		     <td>{{$valo->day_tot}}</td>
		     
		      <td>@if($valo->start_time!='' && $valo->work!=0) {{date('h:i A',strtotime($valo->start_time))}}          @endif</td>
		       <td>  @if($valo->end_time!=''  && $valo->work!=0) {{date('h:i A',strtotime($valo->end_time))}}          @endif</td>
		     
		      <td>@if($valo->hours!='') {{$valo->hours}} @else 0 @endif</td>
		    </tr>
		     
		    <?php
		    
  }
	   
  ?>
  <tr>
      <td></td>
      <?php
      $totmin=0;
$main=0;
   if($min<60){
       $totmin=$min;
   }else{
       
$main = floor($min / 60);
   }
      ?>
        
         <td  colspan="2">Total</td>
         <td>{{$od0}}</td>
      <td></td><td></td>
         
         <td>{{($gg+$main)}} @if($min<60) :{{$totmin}} @else :0 @endif</td>
  </tr>
  </tbody>
	</table>
</body>
</html>