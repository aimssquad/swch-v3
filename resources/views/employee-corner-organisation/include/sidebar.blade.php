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
									Employee Corner
									<span class="user-level">@if(Session::get('user_type_new')=='employee')
                            	
							<?php
							
					
				  
					   	$usemail = Session::get('user_email_new'); 
					   
    					 $users_id = Session::get('users_id_new'); 
    					 $dtaem=DB::table('users')      
                 
                          ->where('id','=',$users_id) 
                          ->first();
        				  
        				  $enplit=DB::table('employee')      
                          ->where('emid','=',$dtaem->emid) 
                          ->where('emp_code','=',$dtaem->employee_id) 
                          ->first();
        				  ?>
                            	  <?php 
                           function my_simple_crypt( $string, $action = 'encrypt' ) {
                            // you may change these values to your own
                            $secret_key = 'bopt_saltlake_kolkata_secret_key';
                            $secret_iv = 'bopt_saltlake_kolkata_secret_iv';
                         
                            $output = false;
                            $encrypt_method = "AES-256-CBC";
                            $key = hash( 'sha256', $secret_key );
                            $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
                         
                            if( $action == 'encrypt' ) {
                                $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
                            }
                            else if( $action == 'decrypt' ){
                                $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
                            }
                         
                            return $output;
                        }
                        ?>	
                                
							{{$enplit->emp_fname }}   {{$enplit->emp_mname }}  {{$enplit->emp_lname }}
							@endif
                                </span>
									<span class="caret"></span>
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
					<ul class="nav nav-primary">
						<li class="nav-item active">
							<a href="{{url('employeecornerorganisationdashboard')}}">
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
					
						<li class="nav-item">
							<a data-toggle="collapse" href="#sidebarLayouts">
								<i class="fas fa-th-list"></i>
								<p>Employee Access Value</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayouts">
								<ul class="nav nav-collapse">
								
									<li>
										<a href="{{url('employee-corner-organisation/user-profile')}}">
											<span class="sub-item">View Profile</span>
										</a>
									</li>
								
									<li>
										<a href="{{url('employee-corner/holiday')}}">
											<span class="sub-item">Holiday Calender</span>
										</a>
									</li>
									<li>
										<a href="{{url('employee-corner/work-update')}}">
											<span class="sub-item">Daily Work Update</span>
										</a>
									</li>
										@if(Session::get('user_type')=='employee')
									<li>
										<a href="{{url('employee-corner/leave-apply')}}">
											<span class="sub-item">Leave application</span>
										</a>
									</li>
									@endif
									<li>
										<a href="{{url('employee-corner/attendance-status')}}">
											<span class="sub-item">Attendance Status</span>
										</a>
									</li>
								    
									
									@if(Session::get('user_type_new')=='employee')
									@if(!empty($enplit->verify_status))  @if($enplit->verify_status == "approved")
									<!--<li>-->
									<!--	<a href="{{url('employee-corner-organisation/holiday')}}">-->
									<!--		<span class="sub-item">Holiday Calender</span>-->
									<!--	</a>-->
									<!--</li>-->
								
									<li>
										<a href="{{url('employee-corner-organisation/attendance-status')}}">
											<span class="sub-item">Attendance Status</span>
										</a>
									</li>
										<li>
										<a href="{{url('employee-corner-organisation/change-of-circumstances')}}">
											<span class="sub-item">Change Of Circumstances
</span>
										</a>
									</li>
									@if($enplit->emp_status=='CONTRACTUAL' || $enplit->emp_status=='FULL TIME'  || $enplit->emp_status=='PART TIME')
									<li>
										<a href="{{url('employee-corner-organisation/contract-agreement')}}">
											<span class="sub-item">Contract Agreement
</span>
										</a>
									</li>
									@endif
										@endif
											@endif
												@endif
								</ul>
							</div>
						</li>
					
						
						
						
						
						
						
					</ul>
				</div>
			</div>
		</div>