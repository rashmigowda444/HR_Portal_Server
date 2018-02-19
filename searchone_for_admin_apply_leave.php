<?php
  include('config.php');
 // session_start();
?><?php   
session_start();

if (isset($_POST['select']))
	{
    $leave_id = $_POST['select'];    // get data
    $name=$_POST['name']; 
	if($name==null)
	{exit;
	}
if($leave_id !=0)
{
 $sql="select * from tekhub_user_leave as a 
 INNER JOIN tekhub_employee_personal_details as b on a.emp_id=b.emp_id where a.leave_id='$leave_id' and emp_name='$name'";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  while($row= mysqli_fetch_array($retval)){
echo $row['leave_balance'];
    $emp_id=$row['emp_id'];
  } // echo $_SESSION['emp_id2'];
  if(isset($_SESSION['emp_id2']))
{ unset($_SESSION['emp_id2']);
//echo $_SESSION['emp_id2'];
}
$_SESSION['emp_id2']=$emp_id; 



 mysqli_close($conn);
}
	else
	{
	$sql="select sum(a.leave_balance) as newbal from tekhub_user_leave as a INNER JOIN tekhub_employee_personal_details as b on a.emp_id=b.emp_id where emp_name='$name'";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  while($row= mysqli_fetch_array($retval)){ $_SESSION['emp_id2']=$emp_id;
echo $row['newbal'];
  }

 mysqli_close($conn);
}
		
	}	
?>