<?php
  include('header.php');
?>


<body class="body">
<div class="well" id="divwell">
	<a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Tekvity" id="logo" height="70" 
       width="250"></a><br><br>
    <div class="well" id="insidewell">

	<form method="post">
	<div class="divhead">
	<h3>LOGIN PANEL</h3>
	</div><br><br>

	<div class="input-group">
        <input type="text" name="name" class="form-control" placeholder="Username" required>
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
        <input type="submit" class="form-control" placeholder="Submit" id="send">
        </div>
	</form>
	</div>
</div><br>

<?php
  include('footer.php');
?>


<?php
if(isset($_POST['name'])){
    
$name=$_POST['name'];
$password=$_POST['pass'];
$password1=md5($password);
$name1=$pass1="";
if($name!=''&& $password1!='')
{
$sql="SELECT admin_name,admin_pass FROM tekhub_admin where admin_name='$name' and admin_pass='$password1'";
$retval=mysqli_query($conn,$sql);
if(!$retval)
{
die('Could not fetch data: ' . mysqli_error($conn));
}
while($row= mysqli_fetch_array($retval)){
$name1=$row['admin_name'];
$pass1=$row['admin_pass'];
}
if($name1==$name && $pass1==$password1){
$_SESSION['CurrentUser']=$name1;
$_SESSION['admin']="1";
echo'<script>
window.location="admin_dashboard.php";
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
