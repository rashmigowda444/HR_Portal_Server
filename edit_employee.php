<?php
  include('config.php');
  session_start();
  if(isset($_SESSION["CurrentUser"]) && $_SESSION["admin"] == "1")
  {}
  else{
    echo '<script>window.location="admin_login.php";</script>';
  }
  date_default_timezone_set('GMT');

if(isset($_POST['name'])||isset($_POST['en'])){
  $name= $_POST['name'];
  $status= $_POST['en'];

  $sql1 = "update tekhub_add_employee set status='$status' where emp_name = '$name'";
 // $result = mysqli_query($conn, $sql);

  if(mysqli_query($conn, $sql1))
  {
  	echo "<script>alert('Updated Successful')</script>";
  	echo "<script>window.location='admin_edit_employee_details.php'</script>";
  }
  else
  {
  	echo "<script>alert('Update Failed')</script>";
  	echo "<script>window.location='admin_edit_employee_details.php'</script>";
  }
}
?>



