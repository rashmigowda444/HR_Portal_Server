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


$sql1 = "Select * from tekhub_employee_personal_details as A join tekhub_apply_leave as B on A.emp_id=B.emp_id  join tekhub_leaves as C on B.leave_id=C.leave_id  join tekhub_leave_status as D on D.leave_status_id = B.leave_status_id where A.emp_id='$empid' ";
  $retval1=mysqli_query($conn,$sql1);
  if(!$retval1)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }

echo "

<table class='table table-striped'>
<thead>
<tr>
<th>Employee Name </th>
<th>Leave Type</th>
<th>From Date</th>
<th>To Date</th>
<th>No Of Days</th>
<th>Reason</th>
<th>Status</th>
<th>Cancel Reason</th>
</tr>
</thead>";

if(mysqli_num_rows($retval1)==0)
{

	echo "<script> alert('No data found leaves not yet applied') </script>";
	
} 	
else
{
while($row= mysqli_fetch_array($retval1)){
 $emp_name=$row['emp_name'];
$leave_type=$row['leave_type'];
$from_date=$row['from_date'];
$to_date=$row['to_date'];
$no_of_days=$row['no_of_days'];
$comment=$row['comment'];
$reason_cancel=$row['reason_cancel'];
$status=$row['leave_status_name'];


echo "
		<tbody>
		<tr>
		<td>$emp_name</td>
		<td>$leave_type</td>
		<td>$from_date</td>
		<td>$to_date</td>
		<td>$no_of_days</td>
		<td>$comment</td>
		<td>$status</td>
		<td>$reason_cancel</td>
		";
} }
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


