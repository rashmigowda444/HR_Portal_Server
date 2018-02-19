<?php
  include('config.php');
  session_start();
?>
<?php
$q = intval($_GET['q']);
$id = $_SESSION['empid'];


 $sql="select * from tekhub_user_leave where leave_id='".$q."' and emp_id='".$id."' and leave_id!='4'";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  while($row= mysqli_fetch_array($retval)){
echo $row['leave_balance'];
    
}
 mysqli_close($conn);
 ?>