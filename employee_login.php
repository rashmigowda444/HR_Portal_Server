<?php
  include('header.php');
  
?>

<body>

<div class="well" id="divwell">
	<a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Tekvity" id="logo" height="70" width="250"></a><br><br>
 <div class="well" id="insidewell">

	<form method="post">
	<div class="divhead">
	<h3>LOGIN PANEL</h3>
	</div><br><br>

	<div class="input-group">
        <input type="email" name="email" class="form-control" placeholder="Email ID" required>
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-user"></i>
          </button>
        </div>
      </div><br>

      <div class="input-group">
        <input type="password" name="pass" class="form-control" placeholder="Password" required>
        <div class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-lock"></i>
          </button>
        </div>
      </div><br><br>

      <div class="input-group">
        <input type="submit" class="form-control" placeholder="Login" value="Login" id="send">
        </div>
	</form>
	</div>
</div><br>

<?php
include('footer.php');
?>


  
<?php
if(isset($_POST['email'])){
    
$email=$_POST['email'];
$password=$_POST['pass'];
$password1=md5($password);
$email1=$pass1="";
if($email!=''&& $password!='')
{
$sql="SELECT emp_id,emp_email,emp_pass,emp_name FROM tekhub_add_employee where emp_email='$email' and emp_pass='$password1'";
$retval=mysqli_query($conn,$sql);
if(!$retval)
{
die('Could not fetch data: ' . mysqli_error());
}
while($row= mysqli_fetch_array($retval)){
$user=$row['emp_name'];
$email1=$row['emp_email'];
$pass1=$row['emp_pass'];
$id=$row['emp_id'];
}
if($email1==$email && $pass1==$password1){



$_SESSION['CurrentUser']=$user;
$_SESSION['admin']="0";
$_SESSION['empid']=$id;
echo'<script>
window.location="emp_dashboard.php";
</script>';
}
else
{
echo'<script>alert("Please check your name or password and try again")</script>';
}
}
}

mysqli_close($conn);
?>

</body>