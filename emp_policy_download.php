<?php 
include('config.php');
?>
<?php
if(isset($_POST['download']))
{$sql="select * from tekhub_upload_files";//  where filename='emp_policy.pdf'";
$retval=mysqli_query($conn,$sql);
	$count=mysqli_num_rows($retval);
	if($count>=1)
{		if(!$retval)
      {
die('Could not fetch data: ' . mysqli_error($conn));
      }
      while($row1= mysqli_fetch_array($retval,MYSQLI_ASSOC))
	{  $file_url=$row1['target_path'];
           $filename_from_db=$row1['filename'];
	}
// $filePath='C:/xampp/htdocs/123/uploads/'.$filename_from_db;//emp_policy.pdf';//$file_url;
  $filePath=$file_url.$filename_from_db;
if(!empty($filePath) && file_exists($filePath)){
    // Define headers
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename_from_db");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
    echo "d";
    // Read the file
    readfile($filePath);
    exit;
}else{echo 'The file does not exist.';}



	
}
}

?>