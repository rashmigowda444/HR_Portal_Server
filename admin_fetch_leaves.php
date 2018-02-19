<?php
  include('header_admin.php');
?>

<script type="text/javascript">
        $(function() {
  var start_year = new Date().getFullYear();

  for (var i = start_year; i < start_year + 2; i++) {
    $("#year").append('<option value="' + i + '">' + i + '</option>');
  }
});
 </script>

<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Fetch Leaves</h3>
  </div>
  <div class="well" id="contentwell">
  <form method="post">
  <div class="row">
  <div class="col-md-3">
  <label>Employee Id :</label>
  </div>
  <div class="col-md-9">
  <input name="id"  id="field" type="text" >
  </div>
  </div><hr>
<input type="submit" name="sub1" class="btn" value="Submit" >
</form>
</div>
</div><br>


<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Fetch Leaves</h3>
  </div>
<div class="well" id="contentwell">
  <form method="post">
  <div class="row">
  <div class="col-md-3">
  <label>Leave Type :</label>
  </div>
  <div class="col-md-9">
  <select class="form-control" id="field" name="sel">
    <option>-----Select-----</option>
    <option value="1">Casual Leave</option>
    <option value="2">Earned Leave</option>
    <option value="3">Sick Leave</option>
    <option value="4">LOP</option>
  </select>
  </div>
  </div><hr>
<input type="submit" name="sub2" class="btn" value="Submit">
</form>
</div>
</div><br>


<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Fetch Leaves</h3>
  </div>
<div class="well" id="contentwell">
<form method="POST">
<div class="row">
  <div class="col-md-3">
  <label>Select Year : </label>
  </div>
 <div class="col-md-9">
<select name="year" class="form-control" id="year" style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;"></select>
</div>
</div>
<br>
<div class="row">
  <div class="col-md-3">
  <label>Select Month : </label>
  </div>
<?php 
  $sql="select * from tekhub_month";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"<div class='col-md-9'>
  <select name='leave_month' class='form-control' id='field' required>
    <option >-----Select----</option>";
  while($row= mysqli_fetch_array($retval)){
  $month_value=$row['month_value'];
  $month_name=$row['month_name'];
 echo" <option value=".$month_value.">". $month_name . "</option>";
  }
 echo" </select>
  </div>
  </div><br><br><hr id='hrbef'>";
  ?>
<input type="submit" name="sub3" class="btn" value="Submit">
</form>
</div>
</div><br>


<div class="row" id="leave_div">
  <div class="well" id="headingwell">
  <h3 id="headingdash">Leave Details</h3>
  </div>

  <div class="well" id="contentwell">
<?php
if (isset($_POST['sub1'])) {
$id=$_POST['id'];
$leave_type=array();
$sql1 = "Select * from tekhub_user_leave as A join tekhub_leaves as B on A.leave_id=B.leave_id join tekhub_employee_personal_details as C on A.emp_id=C.emp_id where A.emp_id='$id'";
  $retval1=mysqli_query($conn,$sql1);
  if(!$retval1)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }


while($row= mysqli_fetch_array($retval1,MYSQLI_ASSOC)){
    $leave_type[]=$row['leave_type'];
$leave_balance[]=$row['leave_balance'];
$emp_id=$row['emp_id'];
$emp_name=$row['emp_name'];
}

echo "
<table class='table table-striped'>
    <thead>
      <tr>
<th> Employee ID </th>
<th>Employee Name </th>
<th>$leave_type[0]</th>
<th>$leave_type[1]</th>
<th>$leave_type[2]</th>
<th>$leave_type[3]</th>
</tr>
</thead>
<tbody>
<tr>
<td>$emp_id</td>
<td>$emp_name</td>
<td>$leave_balance[0]</td>
<td>$leave_balance[1]</td>
<td>$leave_balance[2]</td>
<td>$leave_balance[3]</td>
      </tr>
    
    </tbody>
</table>";

    }


elseif (isset($_POST['sub2'])) {
$leave=$_POST['sel'];
$sql = "Select * from tekhub_user_leave as A join tekhub_employee_personal_details as B on A.emp_id=B.emp_id where leave_id='$leave'";
  $retval=mysqli_query($conn,$sql);
  if(!$retval)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }
    echo "<table class='table table-striped'>
    <thead>
      <tr>
        <th>Employee Id</th>
        <th>Employee Name</th>
        <th>Leave Balance</th>
      </tr>
    </thead>
    <tbody>";
    while($row1= mysqli_fetch_array($retval,MYSQLI_ASSOC)){
      echo "<tr>
        <td>{$row1['emp_id']}</td>
        <td>{$row1['emp_name']}</td>
        <td>{$row1['leave_balance']}</td>";
       
      echo "</tr>";
     
}
    echo "</tbody>
  </table>";
}


elseif (isset($_POST['sub3'])) {
$year=$_POST['year'];
$month=$_POST['leave_month'];

$days="Select *,sum(no_of_days) as total from tekhub_apply_leave as A join tekhub_employee_personal_details as B on A.emp_id=B.emp_id where MONTH(date_created)='$month' and YEAR(date_created)='$year'";
$ret=mysqli_query($conn,$days);
  if(!$ret)
  {
die('could not fetch data:'.mysqli_error($conn));
  }
  echo "<table class='table table-striped'>
    <thead>
      <tr>
        <th>Employee Id</th>
        <th>Employee Name</th>
        <th>Leaves Taken</th>
      </tr>
    </thead>
    <tbody>";
  while($rowdays= mysqli_fetch_array($ret)){
  echo "<tr>
        <td>{$rowdays['emp_id']}</td>
        <td>{$rowdays['emp_name']}</td>
        <td>{$rowdays['total']}</td>";
       
      echo "</tr>"; 
 }
echo "</tbody>
  </table>";
}

  mysqli_close($conn);
  ?>
  </div>
</div><br><hr id="hrline">


<?php
  include('footer.php');
?>



