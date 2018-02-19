<?php
  include('header_admin.php');
?>




<div class="row" id="leave_div">
  <div class="well" id="headingwell">
  <h3 id="headingdash">Leave Details</h3>
  </div>

  <div class="well" id="contentwell">
<?php

$sql1 = "Select * from tekhub_apply_leave as A join tekhub_employee_personal_details as B on A.emp_id=B.emp_id join tekhub_leaves as C on A.leave_id=C.leave_id where A.leave_status_id=1";
  $retval1=mysqli_query($conn,$sql1);
  if(!$retval1)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }
echo "

<table class='table table-striped'>
    <thead>
      <tr>
<th> Employee ID </th>
<th>Employee Name </th>
<th>Leave Type</th>
<th>From Date</th>
<th>To Date</th>
<th>No Of Days</th>
</tr>
</thead>";

while($row= mysqli_fetch_array($retval1)){
$emp_id=$row['emp_id'];
$emp_name=$row['emp_name'];
$leave_type=$row['leave_type'];
$app_leave_id=$row['apply_leave_id'];
$from_date=$row['from_date'];
$to_date=$row['to_date'];
$no_of_days=$row['no_of_days'];

echo "
<tbody>
<tr>
<td>$emp_id</td>
<td>$emp_name</td>
<td>$leave_type</td>
<td>$from_date</td>
<td>$to_date</td>
<td>$no_of_days</td>


<td>
    <a href='update_leave.php?eid=$emp_id&lid=$app_leave_id'><button id='submit'>Edit</button></a>
 </td>";
 
echo"
      </tr>";
    }
   echo" </tbody> 
    
</table>

"; $count=mysqli_num_rows( $retval1);
  if($count==0)
  {
	  echo "<script> alert('No Record found'); </script> ";
  } echo " <a href='admin_dashboard.php'><button type='submit' class='btn' >Back</button></a>";

  

  ?>
  </div>
</div><br><hr id="hrline">


<?php
  include('footer.php');
?>
