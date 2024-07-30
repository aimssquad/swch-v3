<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{ asset('assets/img/profile.png')}}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									Settings
									<!--<span class="user-level">HRMS</span>-->
									<!--<span class="caret"></span>-->
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									
									<li>
										<a href="{{url('mainLogout')}}">
											<span class="link-collapse">Logout</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php
							
						
				    $usetype = Session::get('user_type'); 
					if( $usetype=='employee'){
						$usemail = Session::get('user_email'); 
					 $users_id = Session::get('users_id'); 
					 $dtaem=DB::table('users')      
                 
                  ->where('id','=',$users_id) 
                  ->first();
							 $Roles_auth = DB::table('role_authorization')      
                   ->where('emid','=',$dtaem->emid) 
                  ->where('member_id','=',$dtaem->email) 
                  ->get()->toArray();
$arrrole=array();
			foreach($Roles_auth as $valrol){
				$arrrole[]=$valrol->menu;
			}	
			
				  }
				   
			
				  ?>
					<ul class="nav nav-primary">
						<li class="nav-item active">
							<a href="{{url('settingdashboard')}}">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
								<span class="caret"></span>
							</a>
							
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							
						</li>
						<!--<li class="nav-item">
							<a href="company.php">
								<i class="fas fa-layer-group"></i>
								<p>Company</p>
								
							</a>
							
						</li>-->
						<li class="nav-item">
							<a data-toggle="collapse" href="#sidebarLayouts">
								<i class="fas fa-th-list"></i>
								<p>HCM Master</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayouts">
								<ul class="nav nav-collapse">
								
									
									<li>
										<a href="{{url('settings/vw-grade')}}">
											<span class="sub-item">Grade</span>
										</a>
									</li>
								
<?php 
									
									if( $usetype=='employee'){
if(in_array('55', $arrrole))
{
	
	?>
	<li>
										<a href="{{url('settings/vw-department')}}">
											<span class="sub-item">Department</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
		<li>
										<a href="{{url('settings/vw-department')}}">
											<span class="sub-item">Department</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>













<?php 
									
									if( $usetype=='employee'){
if(in_array('56', $arrrole))
{
	
	?>	<li>
										<a href="{{url('settings/vw-designation')}}">
											<span class="sub-item">Designation</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
		<li>
										<a href="{{url('settings/vw-designation')}}">
											<span class="sub-item">Designation</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>


<?php 
									
									if( $usetype=='employee'){
if(in_array('57', $arrrole))
{
	
	?>		<li>
										<a href="{{url('settings/vw-employee-type')}}">
											<span class="sub-item">Employment Type</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
		<li>
										<a href="{{url('settings/vw-employee-type')}}">
											<span class="sub-item">Employment Type</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>


<?php 
									
									if( $usetype=='employee'){
if(in_array('58', $arrrole))
{
	
	?>		<li>
										<a href="{{url('settings/vw-paygroup')}}">
											<span class="sub-item">Pay Group</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
		<li>
										<a href="{{url('settings/vw-paygroup')}}">
											<span class="sub-item">Pay Group</span>
										</a>
									</li>
									
						
				<?php	
									}
									
?>

									
				
<?php 
									
									if( $usetype=='employee'){
if(in_array('59', $arrrole))
{
	
	?>			<li>
										<a href="{{url('settings/vw-annualpay')}}">
											<span class="sub-item">Annual Pay</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
		<li>
										<a href="{{url('settings/vw-annualpay')}}">
											<span class="sub-item">Annual Pay</span>
										</a>
									</li>
						
				<?php	
									}
									
?>

								
		

<?php 
									
									if( $usetype=='employee'){
if(in_array('60', $arrrole))
{
	
	?>				<li>
																				<a href="{{url('settings/vw-bank')}}">
											<span class="sub-item">Bank Master</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
			<li>
																				<a href="{{url('settings/vw-bank')}}">
											<span class="sub-item">Bank Master</span>
										</a>
									</li>
						
				<?php	
									}
									
?>

			
<?php 
									
									if( $usetype=='employee'){
if(in_array('61', $arrrole))
{
	
	?>				<li>
									<a href="{{url('settings/vw-tax')}}">
											<span class="sub-item">Tax Master</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
			<li>
									<a href="{{url('settings/vw-tax')}}">
											<span class="sub-item">Tax Master</span>
										</a>
									</li>
						
				<?php	
									}
									
?>
	
									
				

<?php 
									
									if( $usetype=='employee'){
if(in_array('62', $arrrole))
{
	
	?>					<li>
									<a href="{{url('settings/vw-pay-type')}}">
											<span class="sub-item">Payment Type</span>
										</a>
									</li>
									
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
			<li>
									<a href="{{url('settings/vw-pay-type')}}">
											<span class="sub-item">Payment Type</span>
										</a>
									</li>
				<?php	
									}
									
?>
	
								
								
								
			
				
								
									
									
									
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a  data-toggle="collapse" href="#forms">
								<i class="fas fa-pen-square"></i>
								<p>Payroll</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="forms">
								<ul class="nav nav-collapse">
								
								<?php 
									
									if( $usetype=='employee'){
if(in_array('65', $arrrole))
{
	
	?>					<li>
										<a href="{{url('settings/payitemlist')}}">
											<span class="sub-item">Pay Item</span>
										</a>
									</li>
				<?php
}else{
	?>
				
				<?php
}
									}else{
									?>
				<li>
										<a href="{{url('settings/payitemlist')}}">
											<span class="sub-item">Pay Item</span>
										</a>
									</li>
				<?php	
									}
									
?>
	
						
								
								</ul>
							</div>
						</li>
						
						
						
						
						
						
					</ul>
				</div>
			</div>
		</div>