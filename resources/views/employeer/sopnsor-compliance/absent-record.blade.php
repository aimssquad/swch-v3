<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<!-- CSS Files -->
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
	
</head>



<style>
.custom-template {
	position: fixed;
	top: 50%;
	transform: translateY(-50%);
	right: -325px;
	width: 325px;
	height: max-content;
	display: block;
	z-index: 1;
	background: #ffffff;
	transition: all .3s;
	z-index: 1003;
	box-shadow: -1px 1px 20px rgba(69, 65, 78, 0.15);
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
	transition: all .5s;
}

.custom-template.open {
	right: 0px;
}
.card-title span{
float: right;
    background: #1269db;
    color: #fff;
    padding: 5px 15px;border-radius:5px;
}
.card-title span a{color:#fff;}
.custom-template .custom-toggle {
	position: absolute;
	width: 45px;
	height: 45px;
	background: rgb(88, 103, 221);
	top: 50%;
	left: -45px;
	transform: translateY(-50%);
	display: flex;
	align-items: center;
	justify-content: center;
	text-align: center;
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
	border-right: 1px solid #177dff;
	cursor: pointer;
	color: #ffffff;
	box-shadow: -5px 5px 20px rgba(69, 65, 78, 0.21);
}

.custom-template .custom-toggle i {
	font-size: 20px;
	animation: 1.3s spin linear infinite;
}

.custom-template .title{
    padding: 15px;
    text-align: left;
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
    border-top-left-radius: 5px;
    border-bottom: 1px solid #ebedf2;
    background: #5867dd;
}

.custom-template .custom-content{
	padding: 20px 15px;
	max-height: calc(100vh - 90px);
	overflow: auto;
}

.custom-template .switcher {
	padding: 5px 0;
}

.custom-template .switch-block h4 {
	font-size: 13px;
	font-weight: 600;
	color: #444;
	line-height: 1.3;
	margin-bottom: 0;
	text-transform: uppercase;
}

.custom-template .btnSwitch {
	margin-top: 20px;
	margin-bottom: 25px;
}

.custom-template .btnSwitch button {
	border: 0px;
	height: 20px;
	width: 20px;
	outline: 0;
	margin-right: 10px;
	margin-bottom: 10px;
	cursor: pointer;
	padding: 0;
	border-radius: 50%;
	border: 2px solid #eee;
	position: relative;
	transition: all .2s;
}

.custom-template .btnSwitch button:hover{
	border-color: #0bf;
}

.custom-template .btnSwitch button.selected{
	border-color: #0bf;
}

.custom-template .img-pick {
	padding: 4px;
	min-height: 100px;
	border-radius: 5px;
	cursor: pointer;
}

.custom-template .img-pick img {
	height: 100%;
	height: 100px;
	width: 100%;
	border-radius: 5px;
	border: 2px solid transparent;
}

.custom-template .img-pick:hover img, .custom-template .img-pick.active img{
	border-color: #177dff;
}

.demo .btn, .demo .progress{
	margin-bottom: 15px !important;
}

.demo .form-check-label, .demo .form-radio-label{
	margin-right: 15px;
}

.demo .toggle, .demo .btn-group{
	margin-right: 15px;
}

.demo #slider{
	margin-bottom: 15px;
}

.table-typo tbody > tr > td{
	border-color: #fafafa;
}

.table-typo tbody > tr > td:first-child{
	min-width: 200px;
	vertical-align: bottom;
}

.table-typo tbody > tr > td:first-child p{
	font-size: 14px;
	color: #333;
}

.demo-icon {
	display: flex;
	flex-direction: row;
	align-items: center;
	margin-bottom: 20px;
	padding: 10px;
	transition: all .2s;
}

.demo-icon:hover{
	background-color: #f4f5f8;
	border-radius: 3px;
}

.demo-icon .icon-preview{
	font-size: 1.8rem;
	margin-right: 10px;
	line-height: 1;
	color: #333439;
}

body[data-background-color="dark"] .demo-icon .icon-preview {
	color: #969696;
}

.demo-icon .icon-class{
	font-weight: 300;
	font-size: 13px;
	color: #777;
}

body[data-background-color="dark"] .demo-icon .icon-class {
	color: #a9a8a8;
}

.form-show-notify .form-control{
	margin-bottom: 15px;
}

.form-show-notify label{
	padding-top: 0.65rem;
}

.map-demo {
	height: 300px;
}

#instructions li{
	padding: 5px 0;
}

.row-demo-grid{
	margin-bottom: 15px;
}

.row-demo-grid [class^="col"]{
	text-align: center;
}

.row-demo-grid [class^="col"] .card-body{
	background: #ddd;
}

.btnSwitch button[data-color="white"] {
	background-color: #fff;
}
.btnSwitch button[data-color="grey"] {
	background-color: #f1f1f1;
}
.btnSwitch button[data-color="black"] {
	background-color: #191919;
}
.btnSwitch button[data-color="dark"] {
	background-color: #1a2035;
}
.btnSwitch button[data-color="blue"] {
	background-color: #1572E8;
}
.btnSwitch button[data-color="purple"] {
	background-color: #6861CE;
}
.btnSwitch button[data-color="light-blue"] {
	background-color: #48ABF7;
}
.btnSwitch button[data-color="green"] {
	background-color: #31CE36;
}
.btnSwitch button[data-color="orange"] {
	background-color: #FFAD46;
}
.btnSwitch button[data-color="red"] {
	background-color: #F25961;
}
.btnSwitch button[data-color="dark2"] {
	background-color: #1f283e;
}
.btnSwitch button[data-color="blue2"] {
	background-color: #1269DB;
}
.btnSwitch button[data-color="purple2"] {
	background-color: #5C55BF;
}
.btnSwitch button[data-color="light-blue2"] {
	background-color: #3697E1;
}
.btnSwitch button[data-color="green2"] {
	background-color: #2BB930;
}
.btnSwitch button[data-color="orange2"] {
	background-color: #FF9E27;
}
.btnSwitch button[data-color="red2"] {
	background-color: #EA4d56;
}
.btnSwitch button[data-color="bg1"] {
	background-color: #fafafa;
}
.btnSwitch button[data-color="bg2"] {
	background-color: #fff;
}
.btnSwitch button[data-color="bg3"] {
	background-color: #f1f1f1;
}
/******************Absent Card Report************************/
.app-form-text h5{
  color: #6D7071;
  font-size: 14px;
}
.app-form-text h5 span{
  color: #6D7071;
  padding-left: 10px;


}





/*****************Daily-Attendance*****************************/
.table td, .table th {
    font-size: 14px!important;
    padding: 0 18px!important;
}


/********************Absent Record Card*******************/
/***********************************************/
                          /*Table*/
/****************************************************/
.table-calender-bg{
  text-align: center;	
}
.table-calender-text{
	color: #000;
}
.table-calender-text{
	text-align: left;
	padding-left: 134px;
}
.table-calender-header{
	color: #000;
	margin: 20px 0;
}
.table-calender-text h2 span{
	/*border-bottom: 1px solid #000;*/
}
.table-calender-text{
	float: left;
	margin: 20px 0;
	padding: 0px 3px 0px 134px;
}
.table-calender-text p{
	color: #000;
	font-size: 20px;
	float: left;
    padding-right: 100px;
}
.table-calender{
	text-align: center;
    width: 80%;
    margin: 0 auto;
}

.table-calender th,td{
 text-align: center;
 color: #000;
 font-weight: 600;
 width: 2%;
}
.tr-calender td{
	text-align: center;
	color: #000;
    font-weight: 600;
}

.mo{    background: #d4f3ff;}



/***********************************************************/
@media screen and (max-width: 550px){
	.table-typo tr td{
		display: flex;
		align-items: center;
		word-break: break-word;
	}

	.table-typo tr td:first-child p{
		margin-bottom: 0px;
	}
}

@media screen and (max-width: 576px){
	.custom-template .custom-content {
		overflow: auto;
	}
	.form-show-notify > .text-right, .form-show-validation > .text-right {
		text-align: left !important;
	}
}

@media screen and (max-width: 400px) {
	.custom-template {
		width: 85% !important;
		right: -85%;
	}
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  text-align: left;    
}

@page {
  size: A4 landscape;
}
</style>


<body style="height:100%;">
<div class="table-calender-bg">

<div class="table-calender-header">
<h1>ABSENCE RECORD CARD</h1>
</div>



<table class="table-calender">

<div class="table-calender-text">
  <!-- <p>Employment Type:  &nbsp;  &nbsp; &nbsp; &nbsp; Employee Code:  &nbsp;  &nbsp; &nbsp; &nbsp; Employee Name:  &nbsp;  &nbsp; &nbsp; &nbsp; Year:   </p> -->

  <p><span style="color:#06b3e7">Department :</span> <span style="border-bottom:1px dashed #000">{{$employeenmae->emp_department}}</span></p>
    <p><span style="color:#06b3e7">Designation :</span> <span style="border-bottom:1px dashed #000">{{$employeenmae->emp_designation}}</span></p>
  <p><span style="color:#06b3e7">Employee Code:</span>  <span style="border-bottom:1px dashed #000">{{$employeenmae->emp_code}}</span></p>
  <p><span style="color:#06b3e7">Employee Name:</span>  <span style="border-bottom:1px dashed #000">{{$employeenmae->emp_fname}}   {{$employeenmae->emp_mname}}   {{$employeenmae->emp_lname}}</span></p>
  <p><span style="color:#06b3e7">Year:</span> <span style="border-bottom:1px dashed #000">{{ $year_value}}</span></p>
</div>

  <tr style="background: #d0cccc;">
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
	<table width="80%" style="margin:20px auto;border:none !important;">
	    <tr>
	         
	          <td style="border:none !important;"><p>A :  Authorised  Absence</p></td>
	         <td style="border:none !important;"><p>H :  Holiday</p></td>
	          <td style="border:none !important;"><p>L : Leave</p></td>
	          <td style="border:none !important;"><p>Off : Offday</p></td>
			   </tr>
			    <tr>
	        <td style="border:none !important;"><p>P : Present</p></td>
	        
	          
	             
	                <td style="border:none !important;"><p>PH :  Public Holiday</p></td>
	                 <td style="border:none !important;"><p>U :  Unauthorized Absent</p></td>
					   <td style="border:none !important;"><p>SL : Sick Leave</p></td>
					   </tr>
	   
	    </table>
</div>


</body>


<!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
</html>