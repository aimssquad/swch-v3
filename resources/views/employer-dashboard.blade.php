<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
      <link rel="stylesheet" href="{{ asset('css/style.css')}}">
      <link rel="stylesheet" href="{{ asset('css/line-awesome.min.css')}}">
      <style>
         body{background: #f5f5f5;
    position: relative;}
         .dash-body .col-lg-2.col-xl-2.col-md-4.col-sm-6.col-12 {
         padding-left: 0;
         padding-right: 0;
         }
         /*header{background: #fff;}*/
         footer{background: #3d3e3e;}

      </style>
      <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
      <title>SWCH</title>
   </head>
   <body>
      <header class="topbar">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-3 col-2">
                  <a  href="{{ url('employerdashboard')}}">
                     <h2 style="color:#000;"><img src="{{ asset('img/logo.png')}}" alt="" width="200" style="    margin-top: 10px;"></h2>
                  </a>
               </div>
               <div class="col-md-9 col-10">
                  <ul class="right-optn" style="margin:0">

                     <li>
                        <a href="#">
                           @if(Session::get('admin_userp_user_type')=='user')
                           <?php
                           $email = Session::get("emp_email");
                           $Roledata = DB::table("registration")
                               ->where("status", "=", "active")
                               ->where("email", "=", $email)
                               ->first();
                           ?>
                           <h3>{{$Roledata->f_name }} {{$Roledata->l_name }}</h3>
                           <p>{{$email }}</p>
                           <p>{{$Roledata->p_no }}</p>
                           @elseif(Session::get('user_type')=='employer')
                           <?php
                           $email = Session::get("emp_email");
                           $Roledata = DB::table("registration")
                               ->where("status", "=", "active")
                               ->where("email", "=", $email)
                               ->first();
                           ?>
                           <h3>{{$Roledata->f_name }} {{$Roledata->l_name }}</h3>
                           <p>{{$email }}</p>
                           <p>{{$Roledata->p_no }}</p>
                           @else
                           <h3>{{$Roledata->emp_fname }} {{$Roledata->emp_mname }} {{$Roledata->emp_lname }}</h3>
                           <p>{{$Roledata->em_email }}</p>
                           <p>{{$Roledata->em_phone }}</p>
                           @endif
                        </a>
                     </li>
                     @if(Session::get('admin_userp_user_type')=='user')
                     <li><a href="{{url('mainuesrLogout')}}" title="Log Out"><i class="las la-power-off"></i></a></li>
                     @else
                     <li><a title="Log Out" href="{{url('mainLogout')}}"><i class="las la-power-off"></i></a></li>
                     @endif
                  </ul>
               </div>
            </div>
         </div>
      </header>
      <div class="dash-body">
         <div class="container-fluid">
            <div class="row">
               <?php
               //dd(Session::get('user_type'));
               ?>
               @if(Session::get('user_type')=='employee')
               <?php
               $member_id = Session::get("user_email");
               $member = Session::get("admin_userpp_member");
               //dd($member);
               //  dd($member);Session::put("employee_id", $request->employee_id);
               $Roles_auth = DB::table("role_authorization_admin_emp")
                   ->where("member_id", "=", $member)
                   ->get();
               //dd($Roles_auth);
               $arrrole = [];
               foreach ($Roles_auth as $valrol) {
                   $arrrole[] = $valrol->module_name;
               }
               //dd($arrrole);
               $Roles_auth_employee = DB::table("role_authorization")
                   ->where("member_id", "=", $member_id)
                   ->get();
               // dd($Roles_auth_employee);
               $arrrole_emp = [];
               foreach ($Roles_auth_employee as $valrol) {
                   $arrrole_emp[] = $valrol->module_name;
               }


               $emaiggl = Session::get("emp_email");

               $Roledataemil = DB::table("registration")

                   ->where("email", "=", $emaiggl)
                   ->where("status", "=", "active")
                   ->first();

               //   dd($Roledataemil);
               ?>
            <?php if (in_array("8", $arrrole)) { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("8", $arrrole)) { ?>
                  <a href="{{url('companydashboard')}}">
                  <?php } elseif (in_array("8", $arrrole_emp)) { ?>
                  <a href="{{url('companydashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon1.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Organisation Profile</div>
                     </div>
                  </a>
               </div>
               <?php } ?>
               <?php if (in_array("7", $arrrole)) { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if ($Roledataemil->verify == "approved") {
                          if (in_array("7", $arrrole)) { ?>
                  <a href="{{url('settingdashboard')}}">
                  <?php } elseif (in_array("7", $arrrole_emp)) { ?>
                  <a href="{{url('settingdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php
                      } else {
                           ?>
                  <a href="#">
                     <?php
                      }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon2.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Settings</div>
                     </div>
                  </a>
               </div>
               <?php } ?>
            <?php if (in_array("2", $arrrole)) { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if ($Roledataemil->verify == "approved") { ?>
                  <?php if (in_array("2", $arrrole)) { ?>
                  <a href="{{url('recruitmentdashboard')}}">
                  <?php } elseif (in_array("2", $arrrole_emp)) { ?>
                  <a href="{{url('recruitmentdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon3.png')}}" alt="" width="50">
                        </div>
                        <div class="dash-name">Recruitment</div>
                     </div>
                  </a>
               </div>

               <?php } ?>
               <?php if (in_array("1", $arrrole_emp)) { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if ($Roledataemil->verify == "approved") { ?>
                  <?php if (in_array("1", $arrrole_emp)) { ?>
                  <a href="{{url('employee/dashboard')}}">
                  <?php } elseif (in_array("1", $arrrole)) { ?>
                  <a href="{{url('employee/dashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon4.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Employee</div>
                     </div>
                  </a>
               </div>
               <?php } ?>

                <?php if (in_array("20", $arrrole_emp)) { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if ($Roledataemil->verify == "approved") { ?>
                  <?php if (in_array("20", $arrrole_emp)) { ?>
                  <a href="{{url('hrsupport/dashboard')}}">
                  <?php } elseif (in_array("1", $arrrole)) { ?>
                  <a href="{{url('hrsupport/dashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/hr-support.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Hr Support</div>
                     </div>
                  </a>
               </div>
               <?php } ?>



                <?php if (in_array("10", $arrrole)) { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if ($Roledataemil->verify == "approved") { ?>
                  <?php if (in_array("10", $arrrole)) { ?>
                  <a href="{{url('useraccessdashboard')}}">
                  <?php } elseif (in_array("10", $arrrole_emp)) { ?>
                  <a href="{{url('useraccessdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon5.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">User Access</div>
                     </div>
                  </a>
               </div>
            <?php } ?>



           <?php if (in_array("4", $arrrole)) { ?>
                <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if (
                          $Roledataemil->verify == "approved"
                      ) { ?>
                  <?php if (in_array("4", $arrrole)) { ?>
                  <a href="{{url('holidaydashboard')}}">
                  <?php } else if (in_array("4", $arrrole_emp)) { ?>
                   <a href="{{url('holidaydashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <!--<img src="{{ asset('img/dashicon11.png')}}" alt="" style="width:50px;">-->
                            <img src="{{ asset('img/dashicon7.png')}}" style="width:50px;">
                        </div>
                        <div class="dash-name">Holiday Management</div>
                     </div>
                  </a>
               </div>
               <?php } ?>

          <?php if (in_array("3", $arrrole)) { ?>
                <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if (
                          $Roledataemil->verify == "approved"
                      ) { ?>
                  <?php if (in_array("3", $arrrole)) { ?>
                  <a href="{{url('leavedashboard')}}">
                  <?php } else if (in_array("3", $arrrole_emp)) { ?>
                    <a href="{{url('leavedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <!--<img src="{{ asset('img/dashicon11.png')}}" alt="" style="width:50px;">-->
                            <img src="{{ asset('img/dashicon8.png')}}" style="width:50px;">
                        </div>
                        <div class="dash-name">Leave Management</div>
                     </div>
                  </a>
               </div>
             <?php } ?>


            <?php if (in_array("9", $arrrole)) { ?>
                <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if (
                          $Roledataemil->verify == "approved"
                      ) { ?>
                  <?php if (in_array("9", $arrrole)) { ?>
                 <a href="{{url('rotadashboard')}}">
                  <?php } else if (in_array("9", $arrrole_emp)) { ?>
                  <a href="{{url('rotadashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <!--<img src="{{ asset('img/dashicon11.png')}}" alt="" style="width:50px;">-->
                           <img src="{{ asset('img/dashicon15.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Rota</div>
                     </div>
                  </a>
               </div>
               <?php } ?>

            <?php if (in_array("6", $arrrole)) { ?>
                <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if (
                          $Roledataemil->verify == "approved"
                      ) { ?>
                  <?php if (in_array("6", $arrrole)) { ?>
                 <a href="{{url('attendancedashboard')}}">
                  <?php } else if (in_array("6", $arrrole_emp)) { ?>
                  <a href="{{url('attendancedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <!--<img src="{{ asset('img/dashicon11.png')}}" alt="" style="width:50px;">-->
                            <img src="{{ asset('img/dashicon10.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Attendance</div>
                     </div>
                  </a>
               </div>
               <?php } ?>






           <?php if (in_array("5", $arrrole)) { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledataemil->verify)) {
                      if (
                          $Roledataemil->verify == "approved"
                      ) { ?>
                  <?php if (in_array("5", $arrrole)) { ?>
                  <a href="{{url('leaveapprovedashboard')}}">
                  <?php } else if (in_array("5", $arrrole_emp)) { ?>
                  <a href="{{url('leaveapprovedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                  <?php } ?>
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon11.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Leave Approver</div>
                     </div>
                  </a>
               </div>
         <?php } ?>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <a href="{{url('user-check-employee')}}">
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon14.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Employee Corner</div>
                     </div>
                  </a>
               </div>

              <?php if (in_array("16", $arrrole_emp)) {  ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledataemil->verify)) {
                    if ($Roledataemil->verify == "approved") { ?>
                <?php if (in_array("16", $arrrole_emp)) { ?>
                  <a href="{{url('fileManagment/dashboard')}}">
                <?php } elseif (in_array("16", $arrrole)) { ?>
                  <a href="{{url('fileManagment/dashboard')}}">
                <?php } else { ?>
                <a href="#">
                <?php } ?>
                <?php } else { ?>
                <a href="#">
                   <?php }
                } ?>

                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/file-manager.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">File Manager</div>
                     </div>
                  </a>
               </div>
               <?php } ?>

               <?php if (in_array("17", $arrrole_emp)) {  ?>
                <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                 <?php if (!empty($Roledataemil->verify)) {
                     if ($Roledataemil->verify == "approved") { ?>
                 <?php if (in_array("17", $arrrole_emp)) { ?>
                   <a href="{{url('hrsupport/dashboard')}}">
                 <?php } elseif (in_array("17", $arrrole)) { ?>
                   <a href="{{url('hrsupport/dashboard')}}">
                 <?php } else { ?>
                 <a href="#">
                 <?php } ?>
                 <?php } else { ?>
                 <a href="#">
                    <?php }
                 } ?>

                      <div class="dash-inr">
                         <div class="dash-icon">
                            <img src="{{ asset('img/hr-support.png')}}" alt="" style="width:50px;">
                         </div>
                         <div class="dash-name">Hr Support</div>
                      </div>
                   </a>
                </div>
                <?php } ?>


               @else
               @if(Session::get('user_type')=='employer')<?php
            ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <a href="{{url('companydashboard')}}">
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon1.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Organisation Profile</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('settingdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon2.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Settings</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php
               //if(!empty($Roledata->verify)){  if($Roledata->verify == "approved" && $Roledata->licence == "yes"){
               ?>
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('recruitmentdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon3.png')}}" alt="" width="50">
                        </div>
                        <div class="dash-name">Recruitment</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('employee/dashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon4.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Employee</div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledata->verify)) {
                    if ($Roledata->verify == "approved") { ?>
                     <a href="{{url('circumtances/dashboard')}}">
                  <?php   } else { ?>
                <a href="#">
                  <?php }
                } ?>
                   <div class="dash-inr">
                      <div class="dash-icon">
                         <img src="{{ asset('img/change_circumstances.png')}}" alt="" style="width:50px;">
                      </div>
                      <div class="dash-name">Change Of Circumstances</div>
                   </div>
                </a>
             </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('useraccessdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon5.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">User Access</div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                                 <?php
               // if(!empty($Roledata->verify)){  if($Roledata->verify == "approved" && $Roledata->licence == "yes"){
               ?>
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('holidaydashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon7.png')}}" style="width:50px;">
                        </div>
                        <div class="dash-name">Holiday Management</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php
                  //if(!empty($Roledata->verify)){  if($Roledata->verify == "approved" && $Roledata->licence == "yes"){
                  ?>
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('leavedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon8.png')}}" style="width:50px;">
                        </div>
                        <div class="dash-name">Leave Management</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php
                     //if(!empty($Roledata->verify)){  if($Roledata->verify == "approved" && $Roledata->licence == "yes"){
                     ?>
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('rotadashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon15.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Rota</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php
                  //if(!empty($Roledata->verify)){  if($Roledata->verify == "approved" && $Roledata->licence == "yes"){
                  ?>
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('attendancedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon10.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Attendance</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php
                  //if(!empty($Roledata->verify)){  if($Roledata->verify == "approved" && $Roledata->licence == "yes"){
                  ?>
                  <?php if (!empty($Roledata->verify)) {
                      if ($Roledata->verify == "approved") { ?>
                  <a href="{{url('leaveapprovedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php }
                  } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon11.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Leave Approver</div>
                     </div>
                  </a>
               </div>
               {{-- <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <a href="{{url('payroll-home-dashboard')}}">
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon11a.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Payroll</div>
                     </div>
                  </a>
               </div> --}}



               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <a href="{{url('user-check-employee')}}">
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon14.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Employee Corner</div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledata->verify)) {
                    if ($Roledata->verify == "approved") { ?>
                 <a href="{{url('fileManagment/dashboard')}}">
                <?php } else { ?>
                <a href="#">
                   <?php }
                } ?>

                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/file-manager.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">File Manager</div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledata->verify)) {
                    if ($Roledata->verify == "approved") { ?>
                 <a href="{{url('hrsupport/dashboard')}}">
                <?php } else { ?>
                <a href="#">
                   <?php }
                } ?>

                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/hr-support.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Hr Support</div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledata->verify)) {
                    if ($Roledata->verify == "approved") { ?>
                 <a href="{{url('organogramdashboard')}}">
                <?php } else { ?>
                <a href="#">
                   <?php }
                } ?>

                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon6.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Organogram Chart</div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledata->verify)) {
                    if ($Roledata->verify == "approved") { ?>
                 <a href="{{url('billingorganizationdashboard')}}">
                <?php } else { ?>
                <a href="#">
                   <?php }
                } ?>

                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon12.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Billing</div>
                     </div>
                  </a>
               </div>


               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledata->verify)) {
                    if ($Roledata->verify == "approved") { ?>
                   <a href="{{url('task-management/dashboard')}}">
                <?php } else { ?>
                <a href="#">
                   <?php }
                } ?>
                   <div class="dash-inr">
                      <div class="dash-icon">
                         <img src="{{ asset('img/dashicon15.png')}}" alt="" style="width:50px;">
                      </div>
                      <div class="dash-name">Task Management </div>
                   </div>
                </a>
             </div>


              <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledata->verify)) {
                    if ($Roledata->verify == "approved") { ?>
                     <a href="{{url('performances')}}">
                  <?php   } else { ?>
                <a href="#">
                  <?php }
                } ?>
                   <div class="dash-inr">
                      <div class="dash-icon">
                         <img src="{{ asset('img/dashicon15.png')}}" alt="" style="width:50px;">
                      </div>
                      <div class="dash-name">Performance Management </div>
                   </div>
                </a>
             </div>



             <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (!empty($Roledata->verify)) {
                    if ($Roledata->verify == "approved") { ?>
                     <a href="{{url('dashboarddetails')}}">
                  <?php   } else { ?>
                <a href="#">
                  <?php }
                } ?>
                   <div class="dash-inr">
                      <div class="dash-icon">
                         <img src="{{ asset('img/dashicon13.png')}}" alt="" style="width:50px;">
                      </div>
                      <div class="dash-name">Sponsor Compliance</div>
                   </div>
                </a>
             </div>


               @else
               <?php
               $arrrole = [];
               foreach ($Roles_auth as $valrol) {
                   $arrrole[] = $valrol->module_name;
               } //dd($arrrole);
               ?>
            <?php if (!empty($Roledata->verify_status)) {
                   if ($Roledata->verify_status == "approved") { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("8", $arrrole)) { ?>
                  <a href="{{url('companydashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon1.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Organisation Profile</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("7", $arrrole)) { ?>
                  <a href="{{url('settingdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon2.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Settings</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("2", $arrrole)) { ?>
                  <a href="{{url('recruitmentdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon3.png')}}" alt="" width="50">
                        </div>
                        <div class="dash-name">Recruitment</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("1", $arrrole)) { ?>
                  <a href="{{url('employee/dashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon4.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Employee</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("10", $arrrole)) { ?>
                  <a href="{{url('useraccessdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon5.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">User Access</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("11", $arrrole)) { ?>
                  <a href="{{url('organogramdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon6.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Organogram Chart</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("4", $arrrole)) { ?>
                  <a href="{{url('holidaydashboard')}}">
                  <?php } else { ?>
                  <a href="{{url('holidaydashboard')}}">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon7.png')}}" style="width:50px;">
                        </div>
                        <div class="dash-name">Holiday Management</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("3", $arrrole)) { ?>
                  <a href="{{url('leavedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon8.png')}}" style="width:50px;">
                        </div>
                        <div class="dash-name">Leave Management</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("9", $arrrole)) { ?>
                  <a href="{{url('rotadashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon15.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Rota</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("6", $arrrole)) { ?>
                  <a href="{{url('attendancedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon10.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Attendance</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("5", $arrrole)) { ?>
                  <a href="{{url('leaveapprovedashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon11.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Leave Approver</div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <a href="#">
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon12.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Billing</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("12", $arrrole)) { ?>
                  <a href="{{url('documentsdashboard')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon13.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Documents</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <?php if (in_array("13", $arrrole)) { ?>
                  <a href="{{url('dashboarddetails')}}">
                  <?php } else { ?>
                  <a href="#">
                     <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon13.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Sponsor Compliance</div>
                     </div>
                  </a>
               </div>
               <?php }
            } ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <a href="{{url('employeecornerdashboard')}}">
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon14.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Employee Corner</div>
                     </div>
                  </a>
               </div>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (in_array("16", $arrrole)) { ?>
                    <a href="{{url('fileManagment/dashboard')}}">
                    <?php } else { ?>
                    <a href="#">
                       <?php } ?>

                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/file-manager.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">File Manager</div>
                     </div>
                  </a>
               </div>

               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                <?php if (in_array("17", $arrrole)) { ?>
                    <a href="{{url('hrsupport/dashboard')}}">
                    <?php } else { ?>
                    <a href="#">
                       <?php } ?>
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/hr-support.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Hr Support</div>
                     </div>
                  </a>
               </div>

               <?php if (!empty($Roledata->verify_status)) {
                   if ($Roledata->verify_status == "approved") { ?>
               <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
                  <a href="{{url('taskdashboard')}}">
                     <div class="dash-inr">
                        <div class="dash-icon">
                           <img src="{{ asset('img/dashicon15.png')}}" alt="" style="width:50px;">
                        </div>
                        <div class="dash-name">Tasks </div>
                     </div>
                  </a>
               </div>
            <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
               <a href="{{url('task-management/dashboard')}}">
                  <div class="dash-inr">
                     <div class="dash-icon">
                        <img src="{{ asset('img/dashicon15.png')}}" alt="" style="width:50px;">
                     </div>
                     <div class="dash-name">Task Management </div>
                  </div>
               </a>
            </div>
             <div class="col-lg-2 col-xl-2 col-md-3 col-sm-6 col-12 pl0 pr0">
               <a href="{{url('performances')}}">
                  <div class="dash-inr">
                     <div class="dash-icon">
                        <img src="{{ asset('img/dashicon15.png')}}" alt="" style="width:50px;">
                     </div>
                     <div class="dash-name">Performance Management </div>
                  </div>
               </a>
            </div>
               <?php }
               } ?>
               @endif
               @endif
            </div>
         </div>
      </div>
      </br></br></br></br>
      <footer>
         <div class="col-md-12">
            <p>&copy; <?php echo date('Y') ?> SWCH - HRMS | All Right Reserved |</p>
         </div>
      </footer>
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
   </body>
</html>
