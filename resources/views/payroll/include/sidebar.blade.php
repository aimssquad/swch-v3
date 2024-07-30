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
					  Payroll
					  <!--<span class="user-level">Attendance</span>-->
					  <!--<span class="caret"></span>-->
				   </span>
				</a>
				<div class="clearfix"></div>
				<div class="collapse in" id="collapseExample">
				   <ul class="nav">
					  <li>
						 @if(Session::get('admin_userp_user_type')=='user')
						 <a href="{{url('mainuesrLogout')}}">
						 @else
						 <a href="{{url('mainLogout')}}">
						 @endif
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
			 <li class="nav-item @if (Request::Segment(2)=='dashboard') active @endif">
				<a href="{{url('payroll/dashboard')}}">
				   <i class="fas fa-home"></i>
				   <p>Dashboard</p>
				</a>
			 </li>
			 <!--<li class="nav-item">
				<a href="company.php">
					<i class="fas fa-layer-group"></i>
					<p>Company</p>
					
				</a>
				
				</li>-->
			 <li class="nav-item @if (Request::Segment(2)=='vw-montly-coop') active @endif">
				<a data-toggle="collapse" href="#sidebarLayouts">
				   <i class="fas fa-user"></i>
				   <p>Payroll Master </p>
				   <span class="caret"></span>
				</a>
				<div class="collapse" id="sidebarLayouts">
				   <ul class="nav nav-collapse">
					<?php 
					if( $usetype=='employee'){
					if(in_array('79', $arrrole))
					{
					
					?>	
				 <li class="@if (Request::Segment(2)=='vw-montly-coop') active @endif">
					<a href="{{url('payroll/vw-montly-coop')}}">
					<span class="sub-item">Generat Monthly Co.Operative</span>
					</a>
				 </li>
				 <?php
					}else{
					?>
				 <?php
					}
						}else{
						?>
				 <li class="@if (Request::Segment(2)=='vw-montly-coop') active @endif">
					<a href="{{url('payroll/vw-montly-coop')}}">
					<span class="sub-item">Genearte Monthly Co.Operative</span>
					</a>
				 </li>
				 <?php	
					}
					?>
					  <?php 
					  if( $usetype=='employee'){
					  if(in_array('79', $arrrole))
					  {
					  
					  ?>	
				   <li class="@if (Request::Segment(2)=='vw-montly-itax') active @endif">
					  <a href="{{url('payroll/vw-montly-itax')}}">
					  <span class="sub-item">Generate Monthly Income Tax </span>
					  </a>
				   </li>
				   <?php
					  }else{
					  ?>
				   <?php
					  }
						  }else{
						  ?>
				   <li class="@if (Request::Segment(2)=='vw-montly-itax') active @endif">
					  <a href="{{url('payroll/vw-montly-itax')}}">
					  <span class="sub-item">Generate Monthly Income Tax</span>
					  </a>
				   </li>
				   <?php	
					  }
					  ?>
					  <?php 
					  if( $usetype=='employee'){
					  if(in_array('79', $arrrole))
					  {
					  
					  ?>	
				   <li class="@if (Request::Segment(2)=='vw-montly-allowances') active @endif">
					  <a href="{{url('payroll/vw-montly-allowances')}}">
					  <span class="sub-item">Generate Monthly Allowances</span>
					  </a>
				   </li>
				   <?php
					  }else{
					  ?>
				   <?php
					  }
						  }else{
						  ?>
				   <li class="@if (Request::Segment(2)=='vw-montly-allowances') active @endif">
					  <a href="{{url('payroll/vw-montly-allowances')}}">
					  <span class="sub-item">Generate Monthly Allowances</span>
					  </a>
				   </li>
				   <?php	
					  }
					  ?>
					  <?php 
					  if( $usetype=='employee'){
					  if(in_array('79', $arrrole))
					  {
					  
					  ?>	
				   <li class="@if (Request::Segment(2)=='vw-montly-overtime') active @endif">
					  <a href="{{url('payroll/vw-montly-overtime')}}">
					  <span class="sub-item">Genearte Monthly Overtimes</span>
					  </a>
				   </li>
				   <?php
					  }else{
					  ?>
				   <?php
					  }
						  }else{
						  ?>
				   <li class="@if (Request::Segment(2)=='vw-montly-overtime') active @endif">
					  <a href="{{url('payroll/vw-montly-overtime')}}">
					  <span class="sub-item">Genearte Monthly Overtimes</span>
					  </a>
				   </li>
				   <?php	
					  }
					  ?>
					  <?php 
					  if( $usetype=='employee'){
					  if(in_array('79', $arrrole))
					  {
					  
					  ?>	
				   <li class="@if (Request::Segment(2)=='vw-payroll-generation') active @endif">
					  <a href="{{url('payroll/vw-payroll-generation')}}">
					  <span class="sub-item">Payroll Generation</span>
					  </a>
				   </li>
				   <?php
					  }else{
					  ?>
				   <?php
					  }
						  }else{
						  ?>
				   <li class="@if (Request::Segment(2)=='vw-payroll-generation') active @endif">
					  <a href="{{url('payroll/vw-payroll-generation')}}">
					  <span class="sub-item">Payroll Generation</span>
					  </a>
				   </li>
				   <?php	
					  }
					  ?>
					    <?php 
						if( $usetype=='employee'){
						if(in_array('79', $arrrole))
						{
						
						?>	
					 <li class="@if (Request::Segment(2)=='vw-payroll-generation-all-employee') active @endif">
						<a href="{{url('payroll/vw-payroll-generation-all-employee')}}">
						<span class="sub-item">Generate All Employee Payroll</span>
						</a>
					 </li>
					 <?php
						}else{
						?>
					 <?php
						}
							}else{
							?>
					 <li class="@if (Request::Segment(2)=='vw-payroll-generation-all-employee') active @endif">
						<a href="{{url('payroll/vw-payroll-generation-all-employee')}}">
						<span class="sub-item">Generate All Employee Payroll</span>
						</a>
					 </li>
					 <?php	
						}
						?>
						 <?php 
						 if( $usetype=='employee'){
						 if(in_array('79', $arrrole))
						 {
						 
						 ?>	 
					  <li class="@if (Request::Segment(2)=='vw-process-payroll') active @endif">
						 <a href="{{url('payroll/vw-process-payroll')}}">
						 <span class="sub-item">Process Employee Payroll</span>
						 </a>
					  </li>
					  <?php
						 }else{
						 ?>
					  <?php
						 }
							 }else{
							 ?>
					  <li class="@if (Request::Segment(2)=='vw-process-payroll') active @endif">
						 <a href="{{url('payroll/vw-process-payroll')}}">
						 <span class="sub-item">Process Employee Payroll</span>
						 </a>
					  </li>
					  <?php	
						 }
						 ?>
						  <?php 
						  if( $usetype=='employee'){
						  if(in_array('79', $arrrole))
						  {
						  
						  ?>	 
					   <li class="@if (Request::Segment(2)=='pf-opening-balance') active @endif">
						  <a href="{{url('payroll/pf-opening-balance')}}">
						  <span class="sub-item">PF Opening Balance</span>
						  </a>
					   </li>
					   <?php
						  }else{
						  ?>
					   <?php
						  }
							  }else{
							  ?>
					   <li class="@if (Request::Segment(2)=='pf-opening-balance') active @endif">
						  <a href="{{url('payroll/pf-opening-balance')}}">
						  <span class="sub-item">PF Opening Balance</span>
						  </a>
					   </li>
					   <?php	
						  }
						  ?>

						  <?php 
						  if( $usetype=='employee'){
						  if(in_array('79', $arrrole))
						  {
						  
						  ?>	 
					   <li class="@if (Request::Segment(2)=='vw-adjustment-payroll-generation') active @endif">
						  <a href="{{url('payroll/vw-adjustment-payroll-generation')}}">
						  <span class="sub-item">Salary Adjustment (Payroll)</span>
						  </a>
					   </li>
					   <?php
						  }else{
						  ?>
					   <?php
						  }
							  }else{
							  ?>
					   <li class="@if (Request::Segment(2)=='vw-adjustment-payroll-generation') active @endif">
						  <a href="{{url('payroll/vw-adjustment-payroll-generation')}}">
						  <span class="sub-item">Salary Adjustment (Payroll)</span>
						  </a>
					   </li>
					   <?php	
						  }
						  ?>

						<?php 
						if( $usetype=='employee'){
						if(in_array('79', $arrrole))
						{

						?>	 
						<li class="@if (Request::Segment(2)=='vw-voucher-payroll-generation') active @endif">
						<a href="{{url('payroll/vw-voucher-payroll-generation')}}">
						<span class="sub-item">Voucher (Payroll)</span>
						</a>
						</li>
						<?php
						}else{
						?>
						<?php
						}
							}else{
							?>
						<li class="@if (Request::Segment(2)=='vw-voucher-payroll-generation') active @endif">
						<a href="{{url('payroll/vw-voucher-payroll-generation')}}">
						<span class="sub-item">Voucher (Payroll)</span>
						</a>
						</li>
						<?php	
						}
						?>

						<?php 
						if( $usetype=='employee'){
						if(in_array('79', $arrrole))
						{

						?>	 
						<li class="@if (Request::Segment(2)=='vw-yearly-bonus') active @endif">
						<a href="#">
						<span class="sub-item">Bonus Generation</span>
						</a>
						</li>
						<?php
						}else{
						?>
						<?php
						}
							}else{
							?>
						<li class="@if (Request::Segment(2)=='vw-yearly-bonus') active @endif">
						<a href="#">
						<span class="sub-item">Bonus Generation</span>
						</a>
						</li>
						<?php	
						}
						?>

						<?php 
						if( $usetype=='employee'){
						if(in_array('79', $arrrole))
						{

						?>	 
						<li class="@if (Request::Segment(2)=='vw-voucher-payroll-generation') active @endif">
						<a href="#">
						<span class="sub-item">Yearly Employee Encashments</span>
						</a>
						</li>
						<?php
						}else{
						?>
						<?php
						}
							}else{
							?>
						<li class="@if (Request::Segment(2)=='vw-voucher-payroll-generation') active @endif">
						<a href="#">
						<span class="sub-item">Yearly Employee Encashments</span>
						</a>
						</li>
						<?php	
						}
						?>
						  
				   </ul>
				</div>
			 </li>
			 <li class="nav-item @if (Request::Segment(2)=='report-monthly-attendance') active @endif">
				<a data-toggle="collapse" href="#sidebarReport">
				   <i class="fas fa-user"></i>
				   <p>Report Module </p>
				   <span class="caret"></span>
				</a>
				<div class="collapse" id="sidebarReport">
				   <ul class="nav nav-collapse">
					  <?php 
						 if( $usetype=='employee'){
						 if(in_array('79', $arrrole))
						 {
						 
						 ?>	
					  <li class="@if (Request::Segment(2)=='report-monthly-attendance') active @endif">
						 <a href="{{url('#')}}">
						 <span class="sub-item">Employee Pay Card</span>
						 </a>
					  </li>
					  <?php
						 }else{
						 ?>
					  <?php
						 }
							 }else{
							 ?>
					  <li class="@if (Request::Segment(2)=='report-monthly-attendance') active @endif">
						 <a href="{{url('#')}}">
						 <span class="sub-item">Employee Pay Card</span>
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