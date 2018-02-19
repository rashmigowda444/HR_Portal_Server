<?php
  include('header_admin.php');
?>

<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Add Employee</h3>
  </div>
  <div class="well" id="contentwell">
  <form method="post"> 
  <div class="row">
  <div class="col-md-3">
  <label>Employee Id :</label>
  </div>
  <div class="col-md-9">
  <input name="id"  id="field" type="text" required >
  </div>
  </div><br>
  <div class="row">
  <div class="col-md-3">
  <label>Employee Name :</label>
  </div>
  <div class="col-md-9">
  <input name="name"  id="field" type="text" required>
  </div>
  </div><br>
  <div class="row">
  <div class="col-md-3">
  <label>Employee Name :</label>
  </div>
  <div class="col-md-9">
  <input name="name"  id="field" type="text" required>
  </div>
  </div><br>
  <div class="row">
  <div class="col-md-3">
  <label>Employee Password :</label>
  </div>
  <div class="col-md-9">
  <input name="password"  id="field" type="password" required>
  </div>
  </div><br>
  <div class="row">
  <div class="col-md-3">
  <label>Employee Email :</label>
  </div>
  <div class="col-md-9">
  <input name="email"  id="field" type="text">
  </div>
  </div><br>
<div class="row">
  <div class="col-md-3">
  <label>Employee Holidays:</label>
  </div>
  <?php 
  $sql="select * from tekhub_holiday_type";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"<div class='col-md-9'>
 <select  id='field' name='holiday' required>
    <option >-----Select----</option>";
  while($row= mysqli_fetch_array($retval)){
  $holiday_id=$row['holiday_list_id'];
  $holiday_name=$row['holiday_name'];
 echo" <option value=".$holiday_id.">". $holiday_name . "</option>";
  }
    echo" </select>
  </div>";
  ?>
  </div><br><br><hr>

  <button type="submit" id="btn" class="btn">Add</button>&emsp;
  <a href="admin_dashboard.php"><input id="btn" type="button"  class="btn" value="Back"></input></a>
  </form>
  </div>
</div>
<?php
if(isset($_POST['id'])){
$id=$_POST['id'];
$name=$_POST['name'];
$pass=$_POST['password'];
$email=$_POST['email'];
$holiday=$_POST['holiday'];
$password= md5($pass);
$sql="INSERT INTO tekhub_add_employee(emp_id,emp_name,emp_pass,emp_email,emp_holiday_id) VALUES('$id','$name','$password','$email','$holiday')";
$retval=mysqli_query($conn,$sql);
if(!$retval){
die('could not enter data:'.mysqli_error($conn));
}
$sql2="INSERT INTO tekhub_employee_personal_details(emp_id,emp_name,email_id)VALUES('$id','$name','$email')";


$retval2=mysqli_query($conn,$sql2);
if(!$retval2){
die('could not enter data:'.mysqli_error($conn));
}


$leave="select * from tekhub_leaves";
$leave_out=mysqli_query($conn,$leave);
while($row= mysqli_fetch_array($leave_out))
{
 // $leave_balance=$row['leave_entitlements']; 
  $leave_id=$row['leave_id'];
  $user_leave="INSERT INTO tekhub_user_leave(emp_id,leave_id,leave_entitlements,leave_balance)VALUES('$id','$leave_id',0,0)";
  $leave_insert=mysqli_query($conn,$user_leave);
  if(!$leave_insert){
  die('could not enter data in leave:'.mysqli_error($conn));
                    }
  }
  $sql_addleaves1="UPDATE tekhub_user_leave SET leave_entitlements=4, leave_balance=4 WHERE leave_id=1 and emp_id=".$id."";
$sql_addleaves2="UPDATE tekhub_user_leave SET leave_entitlements=4,leave_balance=4 WHERE leave_id=3 and emp_id=".$id."";
$sql_addleaves1_retval=mysqli_query($conn,$sql_addleaves1);
$sql_addleaves2_retval=mysqli_query($conn,$sql_addleaves2);
if(!$sql_addleaves1_retval){
die('could not enter data:'.mysqli_error($conn));
}
if(!$sql_addleaves2_retval){
die('could not enter data:'.mysqli_error($conn));
}
  echo '<script language="javascript"> alert("Added successfully")</script>';
  }
?>
<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Employee Details</h3>
  </div>

  <div class="well" id="contentwell">

  <?php
  $sql1 = "Select * from tekhub_add_employee order by emp_id asc";
  $retval1=mysqli_query($conn,$sql1);
  if(!$retval1)
  {
  die('Could not fetch data: ' . mysqli_error($conn));
  }

    echo "<table class='table table-striped'>
    <thead>
      <tr>
        <th>Employee Id</th>
        <th>Employee Name</th>
        <th>Employee Email</th>
      </tr>
    </thead>
    <tbody>";
    while($row= mysqli_fetch_array($retval1,MYSQLI_ASSOC)){
      echo "<tr>
        <td>{$row['emp_id']}</td>
        <td>{$row['emp_name']}</td>
        <td>{$row['emp_email']}</td>";
       
      echo "</tr>";      
    }
    echo "</tbody>
  </table>";


  mysqli_close($conn);
  ?>
  
 </div>
</div><br><hr id="hrline">


<?php
  include('footer.php');
?>

