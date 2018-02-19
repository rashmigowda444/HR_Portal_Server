<?php
  include('config.php');
  session_start();
     if(isset($_SESSION["CurrentUser"]) && $_SESSION["admin"] == "0")
{

}else{
echo '<script>window.location="employee_login.php";</script>';

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tekhub</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Jura" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
  <link href="index.css" rel="stylesheet">
  

    <script type="text/javascript">
        $(function() {
  var start_year = new Date().getFullYear();

  for (var i = start_year; i > start_year - 2; i--) {
    $("#year").append('<option value="' + i + '">' + i + '</option>');
  }
});
    </script>
</head>

<body class="body">
<div id="divtop">
<ul id="ultopnav">
  <li id="litoplogo"><a href="index.php"><img src="images/logo.png" alt="Tekvity" height="70" width="250"></a></li>
  <li id="litopwelcome" class="dropdown">
  <a data-toggle="dropdown" style="text-decoration: none;">
  <?php

       if(isset($_SESSION['CurrentUser'])){
        echo 'Welcome '.'&nbsp;'.$_SESSION['CurrentUser'];
       }

       else{

       }
      
  ?><span class="caret"></span></button></a>

    <ul class="dropdown-menu">
     <li><a href="#">Change Password</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
     </li>
</ul>
</div><hr id="hrline">


<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">View Payslip</h3>
  </div>

<div class="well" id="contentwell">
<form method="POST" action="emp_generate_payslip.php">
<div class="row">
  <div class="col-md-2">
  <label>Select Year : </label>
  </div>
 <div class="col-md-6">
<select name="year" class="form-control" id="year" style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;
" required>
<option value='' >-----Select----</option>
</select>
</div>
</div>
<br>

<div class="row">
  <div class="col-md-2">
  <label>Select Month : </label>
  </div>
<?php 
  $sql="select * from tekhub_month";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"<div class='col-md-6'>
  <select name='leave_month' class='form-control' id='field' required>
    <option value='' >-----Select----</option>";
  while($row= mysqli_fetch_array($retval)){
  $month_value=$row['month_value'];
  $month_name=$row['month_name'];
 echo" <option value=".$month_value.">". $month_name . "</option>";
  }
 echo" </select>
  </div>
  </div><br><br><hr id='hrbef'>";
  ?>

<button type="submit" id="btn" class="btn">Submit</button>&emsp;&emsp;
<a id="a-btn" href="emp_dashboard.php"><button type="button" id="btn" class="btn">Back</button></a>
</form>
</div>

</div><br><hr id="hrline">

<div id="divfoot">
<h5><a href="http://tekvity.com/">Tekvity Pvt Ltd</a> © All Rights Reserved. 2017</h5>
</div>
</body>
</html>