<!doctype html>
<html>
<head>
	<title>SWCH</title>
	<style type="text/css">
		
	</style>
</head>

<body style="">
	<table style="width: 900px;margin:auto; font-family: cambria;">
		<thead>
			<tr>
				<th style="width: 100px"><img src="https://workpermitcloud.co.uk/hrms/public/img/logo.png" alt="" width="80"></th>
				<th>
					<h2 style="margin-bottom: 0;font-size: 30px;">WorkPermit Cloud</h2>
					<!--<h5 style="margin: 0;font-size: 20px;">Company Address Goes Here....</h5>-->
					<p style="margin:0;">Phone Number : 020 8087 2343,   Email- info@workpermitcloud.co.uk</p>
						<h5 style="margin: 0;font-size: 20px;">Billing Report</h5>
				</th>
			</tr>
		</thead>
	</table>

	<table border="1" style="border:1px solid #e1e1e1;	text-align:center;width: 900px;margin:auto; font-family: cambria;margin-top: 30px;border-collapse: collapse;">
		<thead style="background: #26b8f8;color: #fff;">
			<tr>
				<th style="padding: 6px;font-size: 18px;">Sl. No.</th>
				<th style="padding: 6px;font-size: 18px;">Invoice No.</th>
				<th style="padding: 6px;font-size: 18px;">Bill to</th>
				<th style="padding: 6px;font-size: 18px;">Bill Amount</th>
				<th style="padding: 6px;font-size: 18px;">Payment Recieved</th>
				<th style="padding: 6px;font-size: 18px;">Due Amount</th>
					<th style="padding: 6px;font-size: 18px;">Status</th>
				<th style="padding: 6px;font-size: 18px;">Bill Date</th>
					<th style="padding: 6px;font-size: 18px;">License Applied</th>
			</tr>
		</thead>
		<tbody>
		    <?php
		       $totam=0;
      $topayre=0;  
         $totdue=0;
		    	if($leave_allocation_rs)
		{$f=1;
			foreach($leave_allocation_rs as $leave_allocation)
			{
			    $pass=DB::Table('payment')
		        
				 ->where('in_id','=',$leave_allocation->in_id) 
				 ->select(DB::raw('sum(re_amount) as amount'))
				->first(); 
					$passreg=DB::Table('registration')
		        
				 ->where('reg','=',$leave_allocation->emid) 
			
		         
				->first();
			
						if(!empty($pass->amount)){
						  
    $due=$pass->amount;
}else{
    $due='0';
}

$totam=$totam+$leave_allocation->amount;
$topayre=$topayre+$due;

$totdue=$totdue+$leave_allocation->due;
$pabillsts=DB::Table('hr_apply')
			
				  ->where('licence','=','Granted') 
		          ->where('emid','=',$leave_allocation->emid) 
				->first(); 
				if(!empty($pabillsts)){
				    $ffd='Granted';
				}else{
				      $ffd='Not Granted';
				}
if($or_name==''){

			    ?>
			<tr>
				<td style="padding: 5px;"><?=$f;?></td>
				<td style="padding: 5px;"><?=$leave_allocation->in_id;?></td>
				<td style="padding: 5px;"><?=$passreg->com_name ?></td>
				<td style="padding: 5px;"><?=$leave_allocation->amount;?></td>
				<td style="padding: 5px;"><?=$due?></td>
				<td style="padding: 5px;"><?=$leave_allocation->due;?></td>
				<td style="padding: 5px;"><?=strtoupper($leave_allocation->status)?></td>
				<td style="padding: 5px;"><?=date('d/m/Y',strtotime($leave_allocation->date))?></td>
					<td style="padding: 5px;">
							         {{$ffd}}</td>
			</tr>
<?php
$f++;
    
}if($or_name!='' &&  $or_name==$leave_allocation->emid){
       ?>
    	<tr>
				<td style="padding: 5px;"><?=$f;?></td>
				<td style="padding: 5px;"><?=$leave_allocation->in_id;?></td>
				<td style="padding: 5px;"><?=$passreg->com_name ?></td>
				<td style="padding: 5px;"><?=$leave_allocation->amount;?></td>
				<td style="padding: 5px;"><?=$due?></td>
				<td style="padding: 5px;"><?=$leave_allocation->due;?></td>
				<td style="padding: 5px;"><?=strtoupper($leave_allocation->status)?></td>
				<td style="padding: 5px;"><?=date('d/m/Y',strtotime($leave_allocation->date))?></td>
					<td style="padding: 5px;">
							       {{$ffd}}</td>
			</tr>
<?php
$f++;
    
}
}
		}
		
		?>
		
		</tbody>
			<tfoot>
												     <?php

    ?>	<tr>
													  <td></td>
      
													  <td></td>
      	
        
         <td  >Total :</td>
      
         <td>		 <?php

 echo $totam;?></td>
  <td> <?php

 echo $topayre;?></td>
         <td> <?php
 echo $totdue;?></td>
<?php

?>
  <td></td>
      
													  <td></td>
													  <td></td>
													  	</tr>
													</tfoot>
	</table>
</body>
</html>