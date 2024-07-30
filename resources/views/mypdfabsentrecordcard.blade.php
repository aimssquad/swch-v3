<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<!-- CSS Files -->

<style>
    @page {
  size: A4 landscape;
  margin:30px;

}
body{min-height:100%;}
.print:last-child {
     page-break-after: always
}
.even_clor tr:noth-child(odd){
    background-color:#ecebfd;
}

</style>
</head>




<body style="min-height:100% !important;page-break-inside: avoid;">
<div class="table-calender-bg" style="text-align: center;">

<table class="table-calender-header" style="color: #000;margin:20px 0;width:100%">

<tr><td colspan="3"><h1 style="text-align:center;">ABSENCE RECORD CARD</h1></td></tr>

<tr class="table-calender-text">


  <!-- <p>Employment Type:  &nbsp;  &nbsp; &nbsp; &nbsp; Employee Code:  &nbsp;  &nbsp; &nbsp; &nbsp; Employee Name:  &nbsp;  &nbsp; &nbsp; &nbsp; Year:   </p> -->
 <!--<img src="http://workpermitcloud.co.uk/hrms/public/{{ $com_logo }}" alt="" width="130"/>-->

  <!--<td style="color: #000;font-size: 20px;float: left;padding-right: 100px;"><span style="color:#06b3e7">{{ $com_name }} </span> </td>

  <td style="color: #000;font-size: 20px;float: left;padding-right: 100px;"><span style="color:#06b3e7">{{ $address }}<br />{{$addresssub}}</span> </td>-->
  <td style="color: #000;font-size: 16px;"><span style="color:#000"><b>Department :</b></span> <span>{{$employeenmae->emp_department}}</span></td>
  <td style="color: #000;font-size: 16px;"><span style="color:#000"><b>Designation :</b></span> <span>{{$employeenmae->emp_designation}}</span></td>


  <td style="color: #000;font-size: 16px;float: left;"><span style="color:#000"><b>Employee Code:</b></span>  <span>{{$employeenmae->emp_code}}</span></td>
  </tr>
  <tr>
  <td style="color: #000;font-size: 16px;"><span style="color:#000"><b>Employee Name:</b></span>  <span>{{$employeenmae->emp_fname}}   {{$employeenmae->emp_mname}}   {{$employeenmae->emp_lname}}</span></td>
  <td style="color: #000;font-size: 16px;"><span style="color:#000"><b>Year:</b></span> <span>{{ $year_value}}</span></td>
</tr>
</table>

<table border="1" class="table-calender" style="border-collapse:collapse;text-align: center;width: 100%;margin: 0 auto;border:1px solid #000;">



  <tr style="background: #d27eff; padding-top:5px; padding-bottom:5px;">
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

  {!! $resultnew !!}
</table>
	<table class="even_clor" width="80%" style="margin:20px auto;border:none !important;">
	   <tr>

	          <td style="border:none !important;"><p style="color:#5bbb5c;">A :  Authorised  Absence</p></td>
	         <td style="border:none !important;"><p style="color:#742d5b">H :  Holiday</p></td>
	          <td style="border:none !important;"><p>L : Leave</p></td>
	          <td style="border:none !important;"><p style="color:#a29b9b">Off : Offday</p></td>
			   </tr>
			    <tr>
	        <td style="border:none !important;"><p style="color:#35b0f3">P : Present</p></td>



	                <td style="border:none !important;"><p style="color:#c4952c;">PH :  Public Holiday</p></td>
	                 <td style="border:none !important;"><p style="color:red;">U :  Unauthorized Absent</p></td>
					   <td style="border:none !important;"><p style="color:#3678b8">SL : Sick Leave</p></td>
					   </tr>
	    </table>
</div>


</body>


<!-- Bootstrap Notify -->

</html>
