<?php
  include('emp_header.php');
?>



<div class="row" id="leave_div">
  <div class="well" id="headingwell">
  <h3 id="headingdash">Leave Details</h3>
  </div>

<div class="well" id="contentwell">
<?php
$empid=$_SESSION['empid'];


$sql1 = "Select * from tekhub_leaves as A join tekhub_user_leave as B on A.leave_id=B.leave_id join tekhub_employee_personal_details as C on C.emp_id=B.emp_id where C.emp_id='$empid'  ";
  $retval1=mysqli_query($conn,$sql1);
  if(!$retval1)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }

echo "

<table class='table table-striped'>
<thead>
<tr>
<th>Employee ID</th>
<th>Employee Name</th>
<th>Leave Type</th>
<th>Leave Entitlements</th>
<th>Leave Balance</th>
</tr>
</thead>";
while($row= mysqli_fetch_array($retval1)){
$id=$row['emp_id'];
$name=$row['emp_name'];
$leave_type=$row['leave_type'];
$entitle=$row['leave_entitlements'];
$balance=$row['leave_balance'];

echo "
		<tbody>
		<tr>
		<td>$id</td>
		<td>$name</td>
		<td>$leave_type</td>
		<td>$entitle</td>
		<td>$balance</td>
		
		";
}
echo"
      </tr>
 </tbody>
    
</table>

";


?>
<a href="emp_dashboard.php"><input type="button" class="btn btn-success"   value="Back "></input></a>
</div>
</div><br><hr id="hrline">


<?php
  include('footer.php');
?>


