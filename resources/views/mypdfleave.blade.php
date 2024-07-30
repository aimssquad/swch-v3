<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SWCH</title>
<style>
@media print {
   body {
      -webkit-print-color-adjust: exact;
   }
}
tr:nth-child(even) {
    background-color: #ecebfd;
}
td, th {
    padding: 5px;
}
.header {
    width: 100%;
    display: flex;
    justify-content: space-between;
}
.logo {
    border: 2px solid #d00eff;
}
.logo img {
    width: 130px;
}
.address {
    text-align: right;
    font-size: 15px;
    margin: 0;
}
.title {
    font-size: 20px;
    margin: 0;
}
</style>
</head>

<body style="webkit-print-color-adjust: exact;">

<div class="header">
    <div class="logo">
        <img src="https://skilledworkerscloud.co.uk/hrms/img/logo.png" alt="" />
    </div>
    <div class="address">
        <p>{{ $address }}<br />{{$addresssub}}</p>
        <p class="title">Leave Register Of {{ $year_value }}</p>
    </div>
</div>

<table style="width:100%;font-family:cambria">
    <tr>
        <th colspan="2" style="width:90%; background-color: #fff;"><h2>{{ $com_name }}</h2></th>
    </tr>
</table>

<table border="1" style="width:100%;font-family:cambria;border-collapse:collapse;margin-top:30px">
    <thead>
        <tr>
            <th  style="font-size: 11px;">Sl No.</th>
            <th  style="font-size: 11px;">EMPLOYEE ID</th>
            <th  style="font-size: 11px;">EMPLOYEE NAME</th>
            <th style="font-size: 11px;">DESIGNATION</th>
            <th style="font-size: 11px;">Leave Type</th>
            <th style="font-size: 11px;">No of Leave</th>
            <th style="font-size: 11px;">Leave Status</th>
         </tr>
    </thead>
    
     <tbody>
        <?php $i=0; foreach($employeelist as $ls){ $i++;?>
      <tr>
        <td style="font-size: 10px;"><?php echo $i; ?></td>
        <td style="font-size: 10px;"><?php echo $ls->emp_code; ?></td>
        <td style="font-size: 10px;"><?php echo $ls->emp_fname; ?> <?php echo $ls->emp_mname; ?> <?php echo $ls->emp_lname; ?></td>
        <td style="font-size: 10px;"><?php echo $ls->emp_designation; ?></td>
        <td style="font-size: 10px;"><?php echo $ls->leave_type_name; ?></td>
        <td style="font-size: 10px;"><?php echo $ls->total_leave; ?></td>
        @if($ls->status=="APPROVED")
         <td style="font-size: 10px; color:blue"><?php echo $ls->status; ?></td>
         @endif
          @if($ls->status=="NOT APPROVED")
         <td style="font-size: 10px; color:red"><?php echo $ls->status; ?></td>
         @endif
      </tr>
       <?php } ?>
    </tbody>
</table>
</body>
</html>
