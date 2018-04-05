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
        <span class="input-group-addon" style="color:white; background-color: brown">
          <i class="glyphicon glyphicon-user"></i>
        </span>        
        <input type="text" name="email" class="form-control" placeholder="Email ID/Emp ID" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$|[0-9]{1,3}" required style="width:320px;"> 
      </div><br>      

      <div class="input-group">        
        <span class="input-group-addon" style="color:white; background-color: brown">
          <i class="glyphicon glyphicon-lock"></i>
        </span>        
        <input type="password" name="pass" class="form-control" placeholder="Password" required style="width:320px;">      
      </div><br><br>

      <div class="input-group">
        <input type="submit" class="form-control" placeholder="Login" value="Login" id="send" name="submit">
        </div>
	</form>
	</div>
</div><br>

<?php
include('footer.php');
?>


  
<?php
if(isset($_POST['submit'])){
    
$email=$_POST['email'];
$password=$_POST['pass'];
$password1=md5($password);
$email1=$pass1="";
if($email!=''&& $password!='')
{
$sql="SELECT emp_id,emp_email,emp_pass,emp_name,status FROM tekhub_add_employee where emp_email='$email' or emp_id='$email' and emp_pass='$password1'";
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
$status=$row['status'];
}
if(($email1==$email || $id==$email) && $pass1==$password1 && $status=='1'){



$_SESSION['CurrentUser']=$user;
$_SESSION['admin']="0";
$_SESSION['empid']=$id;
echo'<script>
window.location="emp_dashboard.php";
</script>';
}
elseif (($email1==$email || $id==$email) && $pass1==$password1 && $status=='0') {
  echo "<script>alert('Account is disabled')</script>";
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
