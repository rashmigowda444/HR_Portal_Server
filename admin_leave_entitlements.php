<?php
  include('header_admin.php');
?>
<script>
$(function() {
    $( "#field1" ).autocomplete({
        source: 'search.php'
    });
});
</script>
<script>
function validateForm() {
    var x = document.forms["myForm"]["type_leave"].value;
	
    if (x =="select") { 
        alert("please select leave type");
        return false;
    }
}
</script>
<script type="text/javascript">
        $(function() {
  var start_year = new Date().getFullYear();

  for (var i = start_year; i > start_year - 2; i--) {
    $(".year").append('<option value="' + i + '">' + i + '</option>');
  }
});
</script>

<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash"> Leave Entitlements</h3>
  </div>
 <div class="well" id="contentwell">
 <form method="post" name="myForm" onsubmit="return validateForm()">
  <table class="table table-striped">
    <thead>
      <tr>
<th>Employee Name </th>
<th>Leave Type</th>
<th>Year</th>
</tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" name="name" id="field1" required></td>
<td><?php 
  $sql="select * from tekhub_leaves";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"
 <select id='type_leave' class='form-control'  name='leave_type'  required>
    <option value='select'>-----Select----</option>
<option value='0'>All</option>";
  while($row= mysqli_fetch_array($retval)){
  $leave_id=$row['leave_id'];
  $leave_type=$row['leave_type'];
 echo" <option value=".$leave_id.">". $leave_type . "</option>";
  }
    echo" </select>";
  ?></td>
<td><select name="year" class="form-control year" id="field1" required >
<option value="">--select--</option>

</select></td>
      </tr>
    
    </tbody>
</table>
<hr>
<input type="submit" name="sub" class="btn" value="Submit" >&emsp;&emsp;
<a href="admin_dashboard.php"><input type="button"  class="btn" value="Back"></a>
<br><br>
</form > 

<?php
if (isset($_POST['sub'])) {
  $name=$_POST['name'];

 $leave_type=$_POST['leave_type'];
 $year=$_POST['year'];

$sql = "select emp_id from tekhub_employee_personal_details where emp_name='$name'";

$retval=mysqli_query($conn,$sql);
$numrow=mysqli_num_rows($retval);
if($numrow==0)
{ echo " <script> alert('No Record found'); </script>"; 
exit;
	
}
  if(!$retval)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }
while($row= mysqli_fetch_array($retval,MYSQLI_ASSOC)){
	 $emp_id=$row['emp_id'];
}

if($leave_type=='0')
{ 
  
 $sql1 = "SELECT * FROM `tekhub_leaves` as a 
 INNER join tekhub_user_leave as b on a.leave_id=b.leave_id INNER
 JOIN tekhub_employee_personal_details as d
 on d.emp_id=b.emp_id WHERE b.emp_id='$emp_id' and year(b.year)='$year' GROUP BY b.leave_id "; 
 
  $retval1=mysqli_query($conn,$sql1);
  if(!$retval1)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }
	
echo "<table class='table table-bordered'>
    <thead>
      <tr bgcolor='	#A52A2A'>
        <th><font color='#ffffff'>Employee Id</font></th>
        <th><font color='#ffffff'>Employee Name</font></th>
        <th><font color='#ffffff'>Leave Type</font></th>
		<th><font color='#ffffff'>Leave Entitlements</font></th>
		
		<th><font color='#ffffff'>Leave Balance</th>
      </tr>
    </thead>
    <tbody>";
    while($row1= mysqli_fetch_array($retval1,MYSQLI_ASSOC)){
			 $leave_type; 
			 $leave_type_new=$row1['leave_id'];
			
		
		
      echo "<tr>
	  
        <td>{$row1['emp_id']}</td>
        <td>{$row1['emp_name']}</td>
		<td>{$row1['leave_type']}</td>
		<td>{$row1['leave_entitlements']}</td>
        <td>{$row1['leave_balance']}</td>";
       
      echo "</tr>";
     
}
    echo "</tbody>
  </table>";

}
	
else{
	
  $sql2="select * from tekhub_employee_personal_details 
  as A join tekhub_user_leave as B on A.emp_id=B.emp_id join
  tekhub_leaves as D on B.leave_id=D.leave_id where A.emp_id='$emp_id' and year(B.year)='$year' 
  and B.leave_id='$leave_type' GROUP by D.leave_id";
 
 $retval2=mysqli_query($conn,$sql2);
  if(!$retval2)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }
	
echo "<table class='table table-bordered'>
    <thead>
      <tr bgcolor='	#A52A2A'>
        <th><font color='#ffffff'>Employee Id</font></th>
        <th><font color='#ffffff'>Employee Name</font></th>
        <th><font color='#ffffff'>Leave Type</font></th>
		<th><font color='#ffffff'>Leave Entitlements</font></th>
		
		<th><font color='#ffffff'>Leave Balance</th>
      </tr>
    </thead>
    <tbody>";
    while($row2= mysqli_fetch_array($retval2,MYSQLI_ASSOC)){
		//for leave taken
		
$sqlfornorofdays="SELECT sum(no_of_days) as newone FROM `tekhub_apply_leave` WHERE leave_id=".$leave_type." and emp_id=".$emp_id."";
	 $retval_nor_of_days=mysqli_query($conn,$sqlfornorofdays);
	 $count_nor_day=mysqli_num_rows($retval_nor_of_days);
	 if($count_nor_day>=1)
	 {
	
	 while($row3= mysqli_fetch_array($retval_nor_of_days,MYSQLI_ASSOC))
     {
	  	 $emp_nor_of_days=$row3['newone'];
		 
	 }
	 }
      echo "<tr>
        <td>{$row2['emp_id']}</td>
        <td>{$row2['emp_name']}</td>
		<td>{$row2['leave_type']}</td>
		<td>{$row2['leave_entitlements']}</td>
		
        <td>{$row2['leave_balance']}</td>";
       
      echo "</tr>";
     
}
    echo "</tbody>
  </table>"; 
}
	

	
}
 mysqli_close($conn);

?>

</div>
</div>
<br><hr id="hrline">
 
<?php
  include('footer.php');
?>
