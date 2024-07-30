<?php
$master_module='';
$payroll_menu='';
$employee='';
$report='';
//dd($Roledata);
// dd($Roledata);
?>


        <div class="sidebar left ">
            <div class="user-panel">
              										
              <div class="pull-left info">
               
                
              </div>
            </div>
            <ul class="list-sidebar bg-defoult">
              <li> <a href="{{url('settingdashboard')}}" class="collapsed" > <i class="fa fa-th-large"></i> <span class="nav-label"> Dashboards </span> <span class="fa fa-chevron-left pull-right"></span> </a>
              
            </li>
           
            <li> <a href="{{url('settings/company')}}" class="collapsed" > <i class="fa fa-bar-chart-o"></i> <span class="nav-label">Company</span> <span class="fa fa-chevron-left pull-right"></span> </a>
            
          </li>
          <li> <a href="#" data-toggle="collapse" data-target="#dashboard" class="collapsed" > <i class="fa fa-th-large"></i> <span class="nav-label"> HCM Master </span> <i class="las la-angle-right"></i> </a>
              <ul class="sub-menu collapse" id="dashboard">
               
                <li><a href="{{url('settings/vw-department')}}"><i class="las la-check-circle"></i> Department</a></li>
                <li><a href="{{url('settings/vw-designation')}}"><i class="las la-check-circle"></i> Designation</a></li>
                <li><a href="{{url('settings/vw-grade')}}"><i class="las la-check-circle"></i> Grade</a></li>
                <li><a href="{{url('settings/vw-employee-type')}}"><i class="las la-check-circle"></i> Employee Type</a></li>
                <li><a href="{{url('settings/vw-grade')}}"><i class="las la-check-circle"></i> Paylevel</a></li>
                
              </ul>
            </li>
          
       <li> <a href="#" data-toggle="collapse" data-target="#payroll" class="collapsed" > <i class="fa fa-th-large"></i> <span class="nav-label"> Payroll </span> <i class="las la-angle-right"></i> </a>
              <ul class="sub-menu collapse" id="payroll">
               
                <li><a href="{{url('settings/ratelist')}}"><i class="las la-check-circle"></i> Rate Master</a></li>
                
              </ul>
            </li>
           
        
     
    </ul>
    </div>