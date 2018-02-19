<?php
  include('header_admin.php');
?><?php
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style type="text/css">
<style>
.view input {
  border:0;
  background:0;
  outline:none !important;
}
</style>
</head>
<body>
<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Policies and procedures
  </div>
<div class="well" id="contentwell" >
 <div class="row" >
  <form  method="post" enctype="multipart/form-data">
 <div class="col-md-2">
 <label>  Select File to Upload:</label><br><br><br>
 <input type="submit" name="submit" value="Upload" class="btn btn-deafalt"/>&emsp;
				<a href="admin_dashboard.php"><input type="button"  class="btn btn-deafalt" value="Back"></input></a>
 </div> 
 <div class="col-md-8"> 
 <input type="file" name="file1" />
 <br><br>
<br><br>
 </div> 
  </form>
  </div>
    </div>  
	</div>
	</div>
<br><hr id="hrline">   

</body>
</html>

<?php
if (isset($_POST['submit']))
{  $filename = $_FILES['file1']['name'];
    if( $filename=="")
	{ echo " <script> alert('please choose the file'); </script> ";
	}
  //upload file
    if($filename != '')
    {  
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = ['pdf', 'txt', 'doc', 'docx'];
            //check if file type is valid
        if (in_array($ext, $allowed))
        {  
            // get last record id
            $sql = 'select max(id) as id from tekhub_upload_files';
            $result = mysqli_query($conn, $sql);
            if (count($result) > 0)
            { 
               $row = mysqli_fetch_array($result);
				 $id_last=($row['id']+1);
		   }
            else 
               
            //set target directory
			chmod('./uploads/',0777);
            $path = "./uploads/";   
			//chmod('C:/xampp/htdocs/123/uploads/',0777);
			 //$path = 'C:/xampp/htdocs/123/uploads/';
             $file_url=$path;
            $created = @date('Y-m-d H:i:s');
           // move_uploaded_file($_FILES['file1']['tmp_name'],($path . $filename));
			move_uploaded_file($_FILES['file1']['tmp_name'], "$path/$filename");
            
            // insert file details into databasetarget_path
        $sql = "INSERT INTO tekhub_upload_files(filename, created,target_path) VALUES('$filename', '$created','$file_url')";
           $returnval=mysqli_query($conn, $sql);
		   if($returnval==1){
		   echo "<script> alert('file uploaded successfully'); </script>"; 
		    
		 ?>  <script>
           document.location="admin_dashboard.php";
             </script>
		   <?php
		   }
		   else{ echo "<script> alert('error'); </script>";  }
			
        }
        else
        {
   
			echo "<script> alert('please upload only pdf and documents'); </script>";
        }
    }
    else {}
       
}
?>

<?php
include('footer.php');
?>  
