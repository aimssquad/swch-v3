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
									Recruitment
									<!--<span class="user-level">HRMS</span>-->
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
                  			->get()
							->toArray();
						$arrrole=array();
						foreach($Roles_auth as $valrol){
							$arrrole[]=$valrol->menu;
						}	
			
				  	}
				   
			
				  	?>
					<ul class="nav nav-primary">
						<li class="nav-item active">
							<a href="{{url('recruitmentdashboard')}}">
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
								<i class="fas fa-user"></i>
								<p>Recruitment </p>
								<span class="caret"></span>
							</a>
							
							<div class="collapse" id="sidebarLayouts">
								<ul class="nav nav-collapse">
									
									<?php 
										
									if( $usetype=='employee'){
										if(in_array('35', $arrrole))
										{?>
										<li>
											<a href="{{url('recruitment/job-list')}}">
												<span class="sub-item">Job List</span>
											</a>
										</li>
									<?php
										}else{
									?>
									<li>
											<a href="{{url('recruitment/job-list')}}">
												<span class="sub-item">Job List</span>
											</a>
										</li>
					
									<?php
										}
									}else{
									?>
										<li>
											<a href="{{url('recruitment/job-list')}}">
												<span class="sub-item">Job List</span>
											</a>
										</li>
									<?php	
									}
									?>
									<?php 
									if( $usetype=='employee'){
										if(in_array('36', $arrrole))
										{
										?>
											<li>
												<a href="{{url('recruitment/job-post')}}">
													<span class="sub-item">Job Posting</span>
												</a>
											</li>
									
										<?php
										}else{
										?>
										<li>
												<a href="{{url('recruitment/job-post')}}">
													<span class="sub-item">Job Posting</span>
												</a>
											</li>
				
										<?php
										}
									}else{
									?>
											<li>
												<a href="{{url('recruitment/job-post')}}">
													<span class="sub-item">Job Posting</span>
												</a>
											</li>
									<?php	
									}
									
									?>
										
											<li>
												<a href="{{url('recruitment/job-published')}}">
													<span class="sub-item">Job Published</span>
												</a>
											</li>			
									<?php 
									if( $usetype=='employee'){
										if(in_array('37', $arrrole))
										{
	
									?>
											<li>
												<a href="{{url('recruitment/candidate')}}">
													<span class="sub-item">Job Applied</span>
												</a>
											</li>
									<?php
										}else{
									?>
									<li>
												<a href="{{url('recruitment/candidate')}}">
													<span class="sub-item">Job Applied</span>
												</a>
											</li>
				
									<?php
										}
									}else{
									?>
											<li>
												<a href="{{url('recruitment/candidate')}}">
													<span class="sub-item">Job Applied</span>
												</a>
											</li>
									<?php	
									}
									
									?>					
									<?php
									if( $usetype=='employee'){										
										if(in_array('38', $arrrole))
										{
	
									?>
											<li>
												<a href="{{url('recruitment/short-listing')}}">	<span class="sub-item">Short Listing</span>
												</a>
											</li>
									<?php
										}else{
									?>
				<li>
												<a href="{{url('recruitment/short-listing')}}">	<span class="sub-item">Short Listing</span>
												</a>
											</li>
									<?php
										}
									}else{
									?>
											<li>
												<a href="{{url('recruitment/short-listing')}}">	<span class="sub-item">Short Listing</span>
												</a>
											</li>
									<?php	
									}
									
									?>					
									<?php
									if( $usetype=='employee'){									
										if(in_array('40', $arrrole))
										{
	
									?>	
											<li>
												<a href="{{url('recruitment/interview')}}">	<span class="sub-item">Interview</span>
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
												<a href="{{url('recruitment/interview')}}">	<span class="sub-item">Interview</span>
												</a>
											</li>
									<?php	
									}
									
									?>										
									<?php 
									if( $usetype=='employee'){
										if(in_array('41', $arrrole))
										{
									?>
											<li>
												<a href="{{url('recruitment/hired')}}">	<span class="sub-item">Hired</span>
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
												<a href="{{url('recruitment/hired')}}">	<span class="sub-item">Hired</span>
												</a>
											</li>
									<?php	
									}
									?>						
										
									<?php 
									if( $usetype=='employee'){		
										if(in_array('77', $arrrole))
										{
									?>	
											<li>
												<a href="{{url('recruitment/offer-letter')}}">	<span class="sub-item">Generate Offer Letter</span>
												</a>
											</li>
									<?php
										}else{
									?>
				<li>
												<a href="{{url('recruitment/offer-letter')}}">	<span class="sub-item">Generate Offer Letter</span>
												</a>
											</li>
									<?php
										}
									}else{
									?>
											<li>
												<a href="{{url('recruitment/offer-letter')}}">	<span class="sub-item">Generate Offer Letter</span>
												</a>
											</li>
								
									<?php	
									}
									?>									
									
									<?php 
									if( $usetype=='employee'){
										if(in_array('42', $arrrole))
										{
									?>
											<li>
												<a href="{{url('recruitment/search')}}">	<span class="sub-item">Search</span>
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
												<a href="{{url('recruitment/search')}}">	<span class="sub-item">Search</span>
												</a>
											</li>
									<?php	
									}
									?>		
									<?php 
									if( $usetype=='employee'){
										if(in_array('42', $arrrole))
										{
									?>
											<li>
												<a href="{{url('recruitment/status-search')}}">	<span class="sub-item">Status Search</span>
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
												<a href="{{url('recruitment/status-search')}}">	<span class="sub-item">Status Search</span>
												</a>
											</li>
									<?php	
									}
									
									?>						
									<?php 
									if( $usetype=='employee'){		
										if(in_array('39', $arrrole))
										{
									?>	
											<li>
												<a href="{{url('recruitment/reject')}}">	<span class="sub-item">Rejected</span>
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
												<a href="{{url('recruitment/reject')}}">	<span class="sub-item">Rejected</span>
												</a>
											</li>
								
									<?php	
									}
									
									?>		
											<li>
												<a href="{{url('recruitment/message-centre')}}">	<span class="sub-item">Message Centre</span>
												</a>
											</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<!-- <a data-toggle="collapse" href="#sidebarInterview">
								<i class="fas fa-user"></i>
								<p>Mock Interview </p>
								<span class="caret"></span>
							</a> -->
							
							<div class="collapse" id="sidebarInterview">
								<ul class="nav nav-collapse">
									
									<?php 
										
									if( $usetype=='employee'){
										if(in_array('88', $arrrole))
										{?>
										<li>
											<a href="{{url('recruitment/interview-forms')}}">
												<span class="sub-item">Interview Forms</span>
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
											<a href="{{url('recruitment/interview-forms')}}">
												<span class="sub-item">Interview Forms</span>
											</a>
										</li>
									<?php	
									}
									?>
									<?php 
										
										if( $usetype=='employee'){
											if(in_array('88', $arrrole))
											{?>
											<li>
												<a href="{{url('recruitment/interviews')}}">
													<span class="sub-item">Interviews</span>
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
												<a href="{{url('recruitment/interviews')}}">
													<span class="sub-item">Interviews</span>
												</a>
											</li>
										<?php	
										}
										?>
									<?php 
										
										if( $usetype=='employee'){
											if(in_array('88', $arrrole))
											{?>
											<li>
												<a href="{{url('recruitment/capstone-assessment-report')}}">
													<span class="sub-item">Capstone Assessment Report</span>
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
												<a href="{{url('recruitment/capstone-assessment-report')}}">
													<span class="sub-item">Capstone Assessment Report</span>
												</a>
											</li>
										<?php	
										}
										?>
									<?php 
										
										if( $usetype=='employee'){
											if(in_array('88', $arrrole))
											{?>
											<li>
												<a href="{{url('recruitment/ca-assessment-report')}}">
													<span class="sub-item">Cognitive Ability Assessment Report</span>
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
												<a href="{{url('recruitment/ca-assessment-report')}}">
													<span class="sub-item">Cognitive Ability Assessment Report</span>
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