<li class="nav-item">
    <a data-toggle="collapse" href="#sidebarLayouts">
       <i class="fas fa-user"></i>
       <p>Report Module </p>
       <span class="caret"></span>
    </a>
    <div class="collapse" id="sidebarLayouts">
       <ul class="nav nav-collapse">
          <?php 
             if( $usetype=='employee'){
             if(in_array('79', $arrrole))
             {
             
             ?>	
          <li>
             <a href="{{url('attendance/upload-data')}}">
             <span class="sub-item">Upload Attendance</span>
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
             <a href="{{url('attendance/upload-data')}}">
             <span class="sub-item">Upload Attendance</span>
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
          <li>
             <a href="{{url('attendance/generate-data')}}">
             <span class="sub-item">Generate Attendance</span>
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
             <a href="{{url('attendance/generate-data')}}">
             <span class="sub-item">Generate Attendance</span>
             </a>
          </li>
          <?php	
             }
             
             ?>
          <?php 
             if( $usetype=='employee'){
             if(in_array('51', $arrrole))
             {
             
             ?>	
          <li>
             <a href="{{url('attendance/daily-attendance')}}">
             <span class="sub-item">Daily Attendance</span>
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
             <a href="{{url('attendance/daily-attendance')}}">
             <span class="sub-item">Daily Attendance</span>
             </a>
          </li>
          <?php	
             }
             
             ?>
          <?php 
             if( $usetype=='employee'){
             if(in_array('53', $arrrole))
             {
             
             ?>	
          <li>
             <a href="{{url('attendance/attendance-report')}}">
             <span class="sub-item">Attendance Report</span>
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
             <a href="{{url('attendance/attendance-report')}}">
             <span class="sub-item">Attendance History</span>
             </a>
          </li>
          <?php	
             }
             
             ?>
          <?php 
             if( $usetype=='employee'){
             if(in_array('52', $arrrole))
             {
             
             ?>	
          <li>
             <a href="{{url('attendance/process-attendance')}}">
             <span class="sub-item">Process Attendance</span>
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
             <a href="{{url('attendance/process-attendance')}}">
             <span class="sub-item">Process Attendance</span>
             </a>
          </li>
          <?php	
             }
             
             ?>
          <?php 
             if( $usetype=='employee'){
             if(in_array('84', $arrrole))
             {
             
             ?>	
          <li>
             <a href="{{url('attendance/absent-report')}}">
             <span class="sub-item">Absent Report</span>
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
             <a href="{{url('attendance/absent-report')}}">
             <span class="sub-item">Absent Report</span>
             </a>
          </li>
          <?php	
             }
             
             ?>
       </ul>
    </div>
 </li>