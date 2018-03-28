<?php
  include('config.php');
  session_start();
  if(isset($_SESSION["CurrentUser"]) && $_SESSION["admin"] == "1")
  {}
  else{
    echo '<script>window.location="admin_login.php";</script>';
  }
  date_default_timezone_set('GMT');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tekhub</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css"   />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Jura" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
  <link href="index.css" rel="stylesheet">

<style>
#but{
height:30px;
float:right;
margin-top:20px;
margin-right:90px;
margin-left: 10px;
}
#back{
height:30px;
float:right;
margin-top:20px;
}
#back a{
color:black;
}
hr{
margin-top:0px !important;border-top:1px solid #000;
}
.table-bordered>tbody>tr>td{
border:1px solid #000 !important;
border-color:#000 !important;
line-height:0.8 !important;
}
 .table-bordered>thead>tr>th{
border:1px solid #000 !important;
border-color:#000 !important;
line-height:0.8 !important;
}
.table>tbody>tr>td{
line-height:0.8 !important;
border-top:none !important;
}
.table-bordered>thead>tr>th{
line-height:0.8 !important;
}
@media print{
#but{
display:none;
}
#back{
 display:none; 
}
}
@page{
size:auto;
margin:0;
}
</style>


<script>
function myFunction() {
    window.print();
}

</script>
</head>


<body>
  <button onclick="myFunction()" id="but">Download PDF</button>
  <button id="back"><a href="admin_view_payslip.php">Back</a></button>
  <br><br>
 
  <div class="container" id="html-content-holder" style="height:90%;width:90%;border:2px solid;background-color:#ffffff;margin-top:30px">
  <div>

 <?php
   if(isset($_POST['name'])){
  	$name=$_POST['name'];
    $year=$_POST['year'];
    $month=$_POST['month'];

    $sql="Select emp_id from tekhub_employee_personal_details where emp_name='$name'";
    $retval=mysqli_query($conn,$sql);
    if(!$retval)
    {
      die('could not fetch data:'.mysqli_error($conn));
    }
    while($row1= mysqli_fetch_array($retval))
    {
      $id=$row1['emp_id']; 
    }


    $days="Select sum(no_of_days) as total from tekhub_apply_leave where emp_id='$id' and MONTH(date_created)='$month' and YEAR(date_created)='$year'";
    $ret=mysqli_query($conn,$days);
    if(!$ret)
    {
      die('could not fetch data:'.mysqli_error($conn));
    } 
    while($rowdays= mysqli_fetch_array($ret))
    {
      $no_of_days=$rowdays['total']; 
    }


    $lopdays="Select sum(no_of_days) as loptotal from tekhub_apply_leave where emp_id='$id' and MONTH(date_created)='$month' and YEAR(date_created)='$year' and leave_id=4";
    $retlop=mysqli_query($conn,$lopdays);
    if(!$retlop)
    {
      die('could not fetch data:'.mysqli_error($conn));
    }
    while($rowdays= mysqli_fetch_array($retlop))
    {
      $lop_days=$rowdays['loptotal']; 
    }


    $name="Select * from tekhub_month where month_value='$month'";
  	$retmon=mysqli_query($conn,$name);
    if(!$retmon)
    {
      die('could not fetch data:'.mysqli_error($conn));
    }
    while($rowname= mysqli_fetch_array($retmon))
    {
      $month_name=$rowname['month_name']; 
    }



    $sqldays="SELECT * from tekhub_month where month_value=$month";
  	$retdays=mysqli_query($conn,$sqldays);
    if(!$retdays)
    {
      die('could not fetch data:'.mysqli_error($conn));
    }
    
    while($rowdays= mysqli_fetch_array($retdays))
    {
    $work_days=$rowdays['working_days']; 
    }
   


  $sql1 = "SELECT * 
  FROM tekhub_employee_personal_details AS personal
  JOIN tekhub_employee_bank_details AS bank ON personal.emp_id = bank.emp_id
  JOIN tekhub_employee_payment_details AS pay ON bank.emp_id = pay.emp_id
  WHERE pay.emp_id ='$id' and pay.pay_year='$year' and pay.pay_month='$month' limit 1";
    $retval1=mysqli_query($conn,$sql1);
    if(!$retval1)
    {
      die('could not fetch data:'.mysqli_error($conn));
    }
     $row_cnt = mysqli_num_rows($retval1);

  	if($row_cnt>0)
  	{

   	while($row= mysqli_fetch_array($retval1))
   	{

   $number=cal_days_in_month(CAL_GREGORIAN, $month, $year); 
   $income=number_format($row['income_tax'], 2, '.', ',');
   $basic=number_format($row['basic_salary'], 2, '.', ',');
   $conveyance=number_format($row['conveyance'], 2, '.', ',');
   $house=number_format($row['house_rent'], 2, '.', ',');
   $medical=number_format($row['medical'], 2, '.', ',');
   $special=number_format($row['special'], 2, '.', ',');
   $gross_earnings=number_format($row['gross_earnings'], 2, '.', ',');
   

   $lop_ded=($row['gross_earnings']/$work_days)*$lop_days;
   $lop = round($lop_ded);
   $lop=number_format($lop, 2, '.', ',');

   $gross= $row['professional_tax']+$row['income_tax']+$lop;
   $gross_deduc=number_format($gross, 2, '.', ',');
   $net=$row['net_pay']-$lop_ded;
   $net = round($net);
   $net_pay=number_format($net, 2, '.', ',');
   
	echo"

   <div class='row' >
   <div class='col-md-6' style='float:left;line-height:0.8;'>
   <img src='images/logo.png' alt='Tekvity' height='70' width='250' style='margin-top:20px;margin-left:10px;'>
   </div>
   <div class='col-md-6' style='float:right;'>
   <h2 style='font-family:Helvetica;'><b>TEKVITY PRIVATE LIMITED</b></h2>
   <h4 style='font-family:Helvetica;'>PaySlip for Month {$month_name} {$year}</h4>
   </div>
   </div><br><hr>


    <div id='content'>
    <div class='row'>
    <div class='col-md-6' style='float:left;width:50%;'>
    <table class='table'>
    <thead>
    
    </thead>
    <tbody>
     <tr>
        <td><b>EMP ID</b></td>
        <td>: {$row['emp_id']}</td>
     </tr>
     <tr>
        <td><b>EMP NAME</b></td>
        <td>: {$row['emp_name']}</td>
     </tr>
     <tr>
        <td><b>DOJ</b></td>
        <td>: {$row['date_of_joining']}</td>
     </tr>
     <tr>
        <td><b>DEPARTMENT</b></td>
        <td>: {$row['department']}</td>
     </tr>
     <tr>
        <td><b>DESIGNATION</b></td>
        <td>: {$row['designation']}</td>
     </tr>
     <tr>
        <td><b>PAN NUMBER</b></td>
        <td>: {$row['pan_number']}</td>
     </tr>
     </tbody>
     </table>
    </div>

   <div class='col-md-6' style='float:right;width:50%;'>
    <table class='table'>
    <thead>
    
    </thead>
    <tbody>
     <tr>
        <td><b>BANK NAME</b></td>
        <td>: {$row['bank_name']}</td>
     </tr>
     <tr>
        <td><b>NO OF DAYS</b></td>
        <td>: {$number}</td>
     </tr>
     <tr>
        <td><b>NO OF LEAVES TAKEN</b></td>
        <td>: {$no_of_days}</td>
     </tr>
     <tr>
        <td><b>LOP DAYS</b></td>
        <td>: {$lop_days}</td>
     </tr>
     <tr>
        <td><b>ACCOUNT NUMBER</b></td>
        <td>: {$row['account_number']}</td>
     </tr>
     
     </tbody>
     </table>
    </div>
    </div><hr>
    
    <div class='row'>
    <div class='col-md-6 col-sm-6 col-lg-6'style='float:left;'>
    <table class='table table-bordered'>
    <thead>
      <tr>
        <th>EARNINGS</th>
        <th>ACTUAL</th>
        <th>EARNED</th>
      </tr>
    </thead>
    <tbody>
     <tr>
        <td>Basic Pay</td>
        <td>$basic</td>
        <td>$basic</td>
      </tr>
      <tr>
        <td>Conveyance Allowance</td>
        <td>$conveyance</td>
        <td>$conveyance</td>
      </tr>
      <tr>
        <td>House Rent Allowance</td>
        <td>$house</td>
        <td>$house</td>
      </tr>
      <tr>
        <td>Medical Allowance</td>
        <td>$medical</td>
        <td>$medical</td>
      </tr>    
    <tr>
        <td>Special Allowance</td>
        <td>$special</td>
        <td>$special</td>
      </tr>
      <tr>
        <td><b>GROSS EARNINGS</b></td>
        <td><b>{$gross_earnings}</b></td>
        <td><b>{$gross_earnings}</b></td>
      </tr>
    </tbody>
    </table>
    
    </div>
   <div class='col-md-6 col-sm-6 col-lg-6'style='float:left;width:48%'>
    <table class='table table-bordered'>
    <thead>
      <tr>
        <th>DEDUCTIONS</th>
        <th>AMOUNT</th>
      </tr>
    </thead>
    <tbody>
     <tr>
        <td>Professional Tax</td>
        <td>{$row['professional_tax']}</td>
      </tr>
      <tr>
        <td>Income Tax</td>
        <td>$income</td>
      </tr>
      <tr>
      <td>LOP Deduction</td>
      <td>$lop </td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td>&nbsp; </td>
      </tr>
      <tr>
      <td>&nbsp;</td>
      <td>&nbsp; </td>
      </tr>
      <tr>
        <td><b>GROSS DEDUCTIONS</b></td>
        <td><b>$gross_deduc</b></td>
      </tr>
      
    </tbody>
    </table>
    </div>
    
    </div>
    
    <div class='row'>
    <div class='col-md-2 ' style='float:left;'>
    <label>NETPAY </label>
    </div>
    <div class='col-md-10 ' style='float:left;'>
    : <b>$net_pay</b>
    </div>
    </div>
   </div>
    
    ";
    
   $number =round($net);
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
          
    echo "<div class='row'>
    <div class='col-md-2' style='float:left;'>
    <label>INWORDS </label>
    </div>
    <div class='col-md-10' style='float:left;'>
    : <b>$result  Rupees Only </b>
    </div>
    </div>";
  
}
}


else{

echo'<script>alert("No payslip found for selected month and year")</script>';

echo'<script>window.location.href="admin_view_payslip.php"</script>';
}
}
mysqli_close($conn);
?>

</div>
</div><br>
<p style="text-align:center;font-family:Helvetica;">This is a computer generated document, hence no signature is required.</p><br>




</body>
</html>
