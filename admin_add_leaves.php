<?php
  include('header_admin.php');
?>
<script>
function validateForm() {
    var name = document.forms["myForm"]["emp_name"].value;
	
    if (name =="select") { 
        alert("please select name");
        return false;
    }
	var leave_type=document.forms["myForm"]["leave_type"].value;
	
	
    if (leave_type =="select") { 
        alert("please select leave type");
        return false;
    }
	var addleaves=document.forms["myForm"]["addleaves"].value;
	
	
    if (addleaves =="") { 
        alert("please enter number of leaves");
        return false;
    }
}
</script>
<script>
function apply(){

 var leave_applied=document.getElementById("txthin").innerHTML;
 var leave=document.getElementById("txtHint").innerHTML;
   
 if(leave_applied>leave){
alert("insufficient leave balance");
}
else{
}
 }
 
</script>

<div class="row" >


  <div class="well" id="headingwell">
  <h3 id="headingdash">Apply Leave</h3>
  </div>

<div class="well" id="contentwell">
<form method="post" name="myForm" onsubmit="return validateForm()" >
  <div class="row">
  <div class="col-md-2">
  <label>Employee Name</label>
  </div>
  <?php 
  $sqlforempname="select * from tekhub_employee_personal_details";
   $retvalforempname=mysqli_query($conn,$sqlforempname);
    if(!$retvalforempname){
		die('could not enter data:'.mysqli_error());
  }
   echo"<div class='col-md-10'>
 <select  id='field'  name='emp_id_name' class='form-control'  required>
 
    <option value='select'>-----Select----</option>
	<option >All</option>";
  while($row= mysqli_fetch_array($retvalforempname)){
  $emp_name=$row['emp_name']; 
  $emp_id=$row['emp_id'];
  echo  $emp_name;
 echo" <option value=".$emp_id.">". $emp_name . "</option>";
  }
    echo" </select>
  </div>
  <br>";
  
  ?></br></br>
  
  
  <div class="col-md-2">
  <label>Leave Type  </label>
  </div>
  <?php 
  $sql="select * from tekhub_leaves WHERE leave_type!='All'";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"<div class='col-md-10'>
 <select  id='leave_type'  style='width:350px;height:35px;border-radius:5px;border:none;background-color:white;' name='leave_type'  required>
 
    <option value='select' >-----Select----</option>";
  while($row= mysqli_fetch_array($retval)){
  $leave_id=$row['leave_id'];
  $leave_type=$row['leave_type'];
 echo" <option value=".$leave_id.">". $leave_type . "</option>";
  }
    echo" </select>
  </div>
  <br>";
  ?>
</br></br>

  <div class="col-md-2">
  <label>Add Leave Days </label>
  </div>
   <div class="col-md-10">
 <input type="number"  min="1" style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;"  name="norofdays" id="addleaves" ></br>
  </div>
  <div><br><br><hr id="hrbef"> 
  <input type="submit"  value="Submit" class= "btn btn-default" name="submit" >
  &emsp;&emsp;
  <a href="admin_dashboard.php"><input type="button" class="btn btn-default" value="Back "></input></a>
  
  
  </div>
  
  
  
  </div>
<br> </form>

</div></div><br><hr id="hrline">


<?php
include('footer.php');
?>


<?php
if(isset($_POST['submit']))
{ 
$emp_id=$_POST['emp_id_name'];
$leave_id=$_POST['leave_type'];
$nor_of_days=$_POST['norofdays'];
//if(isset($_POST['submit']))
	if($emp_id!="All")
{  $leave_balance;
	$sqlfor_existing_value=" select * from tekhub_user_leave WHERE emp_id=".$emp_id." and leave_id=".$leave_id."";
 $sqlfor_existing_value_return=mysqli_query($conn,$sqlfor_existing_value);
 	if(!$sqlfor_existing_value_return) 
    {
die('Could not fetch data: ' . mysqli_error($conn));
    }
else
{
			 
 while($row= mysqli_fetch_array($sqlfor_existing_value_return,MYSQLI_ASSOC))
     {
     $leave_balance=$row['leave_balance'];
	 $leave_entitle=$row['leave_entitlements'];
 
	 }

$leave_add=$leave_balance+$nor_of_days;
$leave_entitle_add=$leave_entitle+$nor_of_days;
	
$sql1="UPDATE `tekhub_user_leave` set leave_balance=".$leave_add.",leave_entitlements=".$leave_entitle_add." WHERE emp_id=".$emp_id." and leave_id=".$leave_id."";
$retval2=mysqli_query($conn,$sql1);
if(!$retval2)
{
die('could not enter data:'.mysqli_error($conn));
}
else
   {
echo '<script language="javascript"> alert("Added successfully")</script>';
?>  <script>  document.location="admin_dashboard.php";  </script>
 <?php

   }
}
} else {  //leave id 5 setting up
$sqlfor_existing_value="select * from tekhub_user_leave where leave_id=".$leave_id."";
 $sqlfor_existing_value_return=mysqli_query($conn,$sqlfor_existing_value);
if(!$sqlfor_existing_value_return) 
    {
die('Could not fetch data: ' . mysqli_error($conn));
    }
else
{
			 
 while($row= mysqli_fetch_array($sqlfor_existing_value_return,MYSQLI_ASSOC))
     {
     $leave_balance=$row['leave_balance'];
	 $emp_id_add_all_bal=$row['emp_id'];
    $leave_balance;   
 $leave_balance=$leave_balance+$nor_of_days;
  $leave_entitle=$row['leave_entitlements'];
 $leave_entitle_add=$leave_entitle+$nor_of_days;
$sqlfor_add_all_members="update tekhub_user_leave set leave_balance=".$leave_balance.",leave_entitlements=". $leave_entitle_add."
where leave_id=".$leave_id." and emp_id=".$emp_id_add_all_bal."";
 $sqlfor_add_all_members_return=mysqli_query($conn,$sqlfor_add_all_members);
 	if(!$sqlfor_add_all_members_return) 
    {
die('Could not fetch data: ' . mysqli_error($conn));
    }
else
{   
 
 $leave_balance=0; 
  
 }  
 }
}
echo '<script language="javascript"> alert("Added successfully")</script>';
?>
<script>  document.location="admin_dashboard.php";  </script> <?php
 }
}
      
?>

</body>
</html>
