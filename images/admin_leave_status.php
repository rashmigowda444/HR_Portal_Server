<?php
  include('header_admin.php');
?>

<div class="row" id="leave_div">
  <div class="well" id="headingwell">
  <h3 id="headingdash">Leave Details</h3>
  </div>

  <div class="well" id="contentwell">
<?php
$sql1 = "Select * from tekhub_apply_leave as A join tekhub_employee_personal_details as B on A.emp_id=B.emp_id where A.leave_status_id=1 ";
  $retval1=mysqli_query($conn,$sql1);
  if(!$retval1)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }


while($row= mysqli_fetch_array($retval1,MYSQLI_ASSOC)){
$emp_id=$row['emp_id'];
$emp_name=$row['emp_name'];
$from_date=$row['from_date'];
$to_date=$row['to_date'];
$no_of_days=$row['no_of_days'];
}

echo "
<table class='table table-striped'>
    <thead>
      <tr>
<th> Employee ID </th>
<th>Employee Name </th>
<th>From Date</th>
<th>To Date</th>
<th>No Of Days</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<tr>
<td>$emp_id</td>
<td>$emp_name</td>
<td>$from_date</td>
<td>$to_date</td>
<td>$no_of_days</td>

<td>
<?php 
  $sql="select * from tekhub_leave_status";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"
<form method='post'>
 <select  id='field' name='status_type'  required>
    <option >-----Select----</option>";
  while($row= mysqli_fetch_array($retval)){
  $leave_status_id=$row['leave_status_id'];
  $leave_status_name=$row['leave_status_name'];
 echo" <option value=".$leave_status_id.">". $leave_status_name . "</option>";
  }
    echo" </select>
  </form>";
  ?>
</td>

      </tr>
    
    </tbody>
</table>";

    }

  ?>
  </div>
</div><br><hr id="hrline">

<?php
if(isset($_POST['id'])){
$status=$_POST['status_type'];
$sql="update tekhub_apply_leave set leave_status_id=$status where emp_id=$emp_id ";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not update data:'.mysqli_error($conn));
  }
else{
echo '<script language="javascript"> alert("Updated successfully")</script>';
}
?>

<?php
  include('footer.php');
?>
