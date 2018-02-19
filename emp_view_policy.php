<?php
  include('emp_header.php');
  
?>
<script type="text/javascript">
  document.getElementById('jsform').submit();
</script>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PHP Live MySQL Database Search</title>
<style type="text/css">
<style>
.view input {
  border:0;
  background:0;
  outline:none !important;
}
</style>
<style type="text/css">
    body{
        font-family: Arail, sans-serif;
    }
    /* Formatting search box */
    .search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

</head>
<body>
<div class="row" >

  <div class="well" id="headingwell">
  <div class="col-md-10">
  <h3 id="headingdash">Policies and procedures
  
  </div>
 
  <div class="col-md-2" style="margin-top: -15px;">
  <form method="post" action="emp_policy_download.php" enctype="multipart/form-data">  
  <button type="submit" name="download" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-download-alt"></span> Download
        </button></form>
		</div>
 </div> 
<div class="well" id="contentwell">

    <div class="row">
	
		
       <div class="col-md-10"> 
       
	 <p>  This employee handbook is a summary of policies, procedures and practices related to
human resource management at TEKVITY.
TEKVITY wishes to maintain a work environment that fosters personal and professional
growth for all employees. Maintaining such an environment is the responsibility of every
staff person. Because of their role, managers and supervisors have the additional
responsibility to lead in a manner which fosters an environment of respect for each
person.  
      

	   
	   <?php 
	   $sql="select * from tekhub_upload_files"; // where filename='emp_policy.pdf'";

  $retval=mysqli_query($conn,$sql);
	$count=mysqli_num_rows($retval);
	if($count>=1)
{
		
		if(!$retval)
      {
die('Could not fetch data: ' . mysqli_error($conn));
      }
   
    while($row1= mysqli_fetch_array($retval,MYSQLI_ASSOC))
	{  $file_url=$row1['target_path'];
       $filename1=$row1['filename'];
	   $url_full=$file_url.$filename1;
     
	}  echo"  <a href='view_policy_pdf.php?url=$url_full'>VIEW MORE.</a> </p> ";
		 
         }
		 echo "<form  method='post'  action='view_policy_pdf.php?url=$file_url' enctype='multipart/form-data'> "; ?>
        </form> 
		
		
		<a href="emp_dashboard.php"><button type="submit" class="btn" >Back</button></a>
		</div>
		
		
    
   

</div>
</div>
<br><br><br><hr id="hrline">   

</body>
</html>

<?php ob_start();
include('footer.php');
?>  
