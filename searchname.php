<?php
  include('config.php');
?>
<?php
    
    //get search term
    $searchTerm = $_GET['term'];
    
$sql = "Select * from tekhub_add_employee WHERE emp_name LIKE '%".$searchTerm."%' ORDER BY emp_name ASC";
  $retval=mysqli_query($conn,$sql);
  if(!$retval)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }
while($row1= mysqli_fetch_array($retval,MYSQLI_ASSOC)){
$data[] = $row1['emp_name'];
}
  echo json_encode($data);
?>