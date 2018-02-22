
<?php
  include('header_admin.php');
?>

<script type="text/javascript">
    function ShowHideDiv() {
        var field1 = document.getElementById("field1");
        
        divreason.style.display = field1.value == "3" ? "block" : "none";
    }
</script>
<script>
function update()
{
	

	var x=document.getElementById("field1").value;
	if(x==0)
	{
		alert("Please select the  Status"); 
		return 0;
	}
		
}

</script>

<div class="row" id="leave_div">
  <div class="well" id="headingwell">
  <h3 id="headingdash">Leave Details</h3>
  </div>

  <div class="well" id="contentwell">
<?php
$eid=$_GET['eid'];
$lid=$_GET['lid'];

$sql="Select * from tekhub_apply_leave as A join tekhub_employee_personal_details as B on A.emp_id=B.emp_id join tekhub_leaves as C on A.leave_id=C.leave_id  where A.emp_id=$eid and apply_leave_id=$lid ";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not update data:'.mysqli_error($conn));
  }
echo "
<form method='post'>
<table class='table table-striped'>
    <thead>
      <tr>
<th>Emp ID </th>
<th>Emp Name </th>
<th>Leave Type</th>
<th>From</th>
<th>To</th>
<th>Days</th>
<th>Reason</th>
<th>Status</th>
</tr>
</thead>";

while($row= mysqli_fetch_array($retval)){
$emp_id=$row['emp_id'];
$emp_name=$row['emp_name'];
$leave_type=$row['leave_type'];
$from_date=$row['from_date'];
$to_date=$row['to_date'];
$no_of_days=$row['no_of_days'];
$reason=$row['comment'];
$leave_balance=$row['leave_balance'];
$leave_id=$row['leave_id'];

}
echo "

<tbody>
<tr>
<td>$emp_id</td>
<td>$emp_name</td>
<td>$leave_type</td>
<td>$from_date</td>
<td>$to_date</td>
<td>$no_of_days</td>
<td>$reason</td>
<td> "; 
$sql='select * from tekhub_leave_status';
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"

 <select  class='form-control' id='field1' name='leave_status' onchange = 'ShowHideDiv()'>
    <option value='0'>-----Select----</option>";
  while($row= mysqli_fetch_array($retval)){
  $leave_status_id=$row['leave_status_id'];
  $leave_status_name=$row['leave_status_name'];
 echo" <option value=".$leave_status_id.">". $leave_status_name . "</option>";
  }
    echo" </select>
</td>
<td>
    <button id='submit' class='btn btn-default' name='btnsubmit' onclick='update()' type='submit'>Update</button>
 </td></tr>
</tbody>
</table>
<div id='divreason' style='display: none;'>
    <label>Reason:</label>
    <textarea class='form-control'  name='comment'></textarea><br>
</div>
 <a href='admin_update_leaves_notification.php?eid=$eid&leave_id=$lid'><input type='button'  class='btn btn-default' value='Back'></input></a>
</form>";


$eid = isset($_REQUEST['eid']) ? $_REQUEST['eid'] : "0";
$lid = isset($_REQUEST['lid']) ? $_REQUEST['lid'] : "0";
if(isset($_POST['leave_status'])) {

$leave_status=$_POST['leave_status'];
if($leave_status==0)
{exit;
}
$comment=$_POST['comment'];


$sql1="Update tekhub_apply_leave set leave_status_id='$leave_status',reason_cancel='$comment' where emp_id='$eid' and apply_leave_id='$lid' ";
  $retval1=mysqli_query($conn,$sql1);
  	  
  if( $leave_status==3)
  { $leave_balance_add=$leave_balance+$no_of_days;
	  $sql2="UPDATE tekhub_user_leave set  leave_balance=$leave_balance_add  WHERE emp_id=$eid and leave_id=$leave_id ";
	   $retval2=mysqli_query($conn,$sql2);
	    if(!$retval2){
  die('could not update data:'.mysqli_error($conn));
     }
	  
  }
  if(!$retval1){
  die('could not update data:'.mysqli_error($conn));
  }
else{
echo "<script>
alert('updated successfully');
window.location='admin_update_leaves_notification.php?eid=$eid&leave_id=$lid';
</script>";
}
}
 mysqli_close($conn);h3
 
?>

</div>
</div><br><hr id="hrline">
<?php
  include('footer.php');
?>

