<?php
  include('header.php');
   if(isset($_SESSION["CurrentUser"]) && $_SESSION["admin"] == "1")
{

}else{
echo '<script>window.location="admin_login.php";</script>';
}
?>


<body class="body">
<div id="divtop">
<ul id="ultopnav">
  <li id="litoplogo"><a href="admin_dashboard.php"><img src="images/logo.png" alt="Tekvity" height="70" width="250"></a></li>
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
    <li><a href="admin_change_password.php">Change Password</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
     </li>
</ul>
</div><hr id="hrline">
</body>
