<?php
  include('config.php');
  session_start();

   if(isset($_SESSION["CurrentUser"]) && $_SESSION["admin"] == "0")
{

}else{
echo '<script>window.location="employee_login.php";</script>';

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

</head>


<body class="body">
<div id="divtop">
<ul id="ultopnav">
  <li id="litoplogo"><a href="emp_dashboard.php"><img src="images/logo.png" alt="Tekvity" height="70" width="250"></a></li>
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
     <li><a href="emp_change_password.php">Change Password</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
     </li>
</ul>
</div><hr id="hrline"><br>
