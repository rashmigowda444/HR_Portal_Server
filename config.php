<?php
	$dbhost = 'localhost';
	$dbuser = 'th_appuser';
//$dbpass = '13Tekvity';
$dbpass = 'th_apppass';
	$dbname = 'tekhub';
	//$dbname = 'shoppercrux';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if(! $conn )
	{
	die('Could not connect: hello ' . mysqli_error());
	}
?>
