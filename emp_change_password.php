<?php
include('emp_header.php');
?>
<script type="text/javascript">
  var check = function() {
  if (document.getElementById('newpassword').value ==
    document.getElementById('confirmpassword').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Not matching';
  }
}
</script>

<div class="row" >
  	<div class="well" id="headingwell">
  		<h3 id="headingdash">Apply Leave</h3>
  	</div>

	<div class="well" id="contentwell">
	<form method="post" name="formchange" >
		<div class="row" >
		  <div class="col-md-3">
		  	<label> Current Password </label>
		  </div>
		  <div class="col-md-9">
		  	<input name="currentpass" id="field" type="password"  required>
		  </div>
		</div><br>


		<div class="row" >
		  <div class="col-md-3">
		  	<label> New Password </label>
		  </div>
		  <div class="col-md-9">
		  	<input name="newpass" id="newpassword" type="password" onkeyup='check();' style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;" required>  	
		  </div>
		</div><br>

		<div class="row" >
		  <div class="col-md-3">
		  	<label> Confirm New Password </label>
		  </div>
		  <div class="col-md-9">
		  	<input name="confirmpass" id="confirmpassword" type="password" onkeyup='check();' style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;" required>  <span id='message'></span>	
		  </div>
		</div>

		<br><br><hr id="hrbef">
  		<input type="submit" id="btnSubmit" class="btn btn-default" value="Submit">&emsp;&emsp;
  		<a href="emp_dashboard.php"><input type="button"  class="btn btn-default"   value="Back"></input></a>
	</form>
	</div>
</div><br><hr id="hrline">


<?php
$emp_id=$_SESSION['empid'];
if (isset($_POST['currentpass']))
{
	$currentpass=$_POST['currentpass'];
	$oldpass=md5($currentpass);
	$newpass=$_POST['newpass'];
	$new=md5($newpass);
	$confirmpass=$_POST['confirmpass'];

	$pass="";
	if($oldpass!='')
	{
		$sql="SELECT * FROM tekhub_add_employee where emp_id=$emp_id";
		$retval=mysqli_query($conn,$sql);
		if(!$retval)
		{
			die('Could not fetch data: ' . mysqli_error($conn));
		}
		while($row= mysqli_fetch_array($retval)){
			$pass=$row['emp_pass'];
		}
		if($oldpass==$pass&&$newpass==$confirmpass)
		{
			$sql1="Update tekhub_add_employee set emp_pass='$new' where emp_id=$emp_id";
			$retval1=mysqli_query($conn,$sql1);
			if(!$retval1)
			{
				die('Could not update data: ' . mysqli_error($conn));
			}
			echo'<script>alert("Password updated successfully")</script>';
			echo'<script>window.location="employee_login.php";</script>';
		}
		else{
			echo'<script>alert("Password entered is wrong, please check your password and try again")</script>';
		}
	}
}
?>


<?php
include('footer.php');
?>