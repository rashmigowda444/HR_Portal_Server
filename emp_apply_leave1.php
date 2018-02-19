<?php
include('emp_header.php');

?>

<script>
function showleave(str) {
  if (str=="") {
    document.getElementById("balance").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("balance").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","getleave.php?q="+str,true);
  
  xmlhttp.send();
}
</script>

<?php
$year= date("Y");
$emp_id=$_SESSION['empid'];
$date_holiday=array();

$holiday="select * from tekhub_user_holiday tuh join tekhub_add_employee tae on tuh.holiday_type_id=tae.emp_holiday_id  where tuh.year = $year and tae.emp_id=$emp_id";
$retval=mysqli_query($conn,$holiday);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  while($row= mysqli_fetch_array($retval)){
  $date_holiday[]=$row['date'];
  $holiday_date=json_encode($date_holiday);
  }
 
  $test=trim($holiday_date,'[ " " ]');
  $hol=str_replace('","',',',$test);

?>

<script>

var gon = [];

gon["holiday"] = "<?php echo $hol ?>".split(",");

document.write(gon["holiday"]);

// 2 helper functions - moment.js is 35K minified so overkill in my opinion
function pad(num) { return ("0" + num).slice(-2); }
function formatDate(date) { var d = new Date(date), dArr = [d.getFullYear(), pad(d.getMonth() + 1), pad(d.getDate())];return dArr.join('-');}

function calculateDays(first,last) {
  var aDay = 24 * 60 * 60 * 1000,
  daysDiff = parseInt((last.getTime()-first.getTime())/aDay,10)+1;

  if (daysDiff>0) {  
    for (var i = first.getTime(), lst = last.getTime(); i <= lst; i += aDay) {
      var d = new Date(i);
      if (d.getDay() == 6 || d.getDay() == 0 // weekend
      || gon.holiday.indexOf(formatDate(d)) != -1) {
          daysDiff--;
      }
    }
  }
  return daysDiff;
}

// ONLY using jQuery here because OP already used it. I use 1.11 so IE8+
$(document).ready(function(){

 var $datepicker1 =  $( "#datepicker1" );
    var $datepicker2 =  $( "#datepicker2" );

    $datepicker1.datepicker();
    $datepicker2.datepicker({
         onClose: function() {
 
var fromDate = $datepicker1.datepicker('getDate');
            var toDate = $datepicker2.datepicker('getDate');

            var days = calculateDays(fromDate,toDate);
    
    if (days <= 0) {
      alert("Please enter an end date after the begin date");
    }
    else {
xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("applied").innerHTML=this.responseText;
      
    }
  }

xmlhttp.open("GET","ltest.php?days="+days,true);
  xmlhttp.send();

    }
}
});

     
    });

</script>

<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Apply Leave</h3>
  </div>

<div class="well" id="contentwell">
<form method="post" action="<?php $_PHP_SELF ?>">
  <div class="row">
  <div class="col-md-2">
  <label>Leave Type  </label>
  </div>
  <?php 
  $sql="select * from tekhub_leaves";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"<div class='col-md-10'>
 <select  id='field' onchange='showleave(this.value)' name='leave_type'  required>
    <option >-----Select----</option>";
  while($row= mysqli_fetch_array($retval)){
  $leave_id=$row['leave_id'];
  $leave_type=$row['leave_type'];
 echo" <option value=".$leave_id.">". $leave_type . "</option>";
  }
    echo" </select>
  </div>
  </div><br>";
  ?>

<div class="row"   id="rowduration">
  <div class="col-md-2">
  <label>Leave Balance </label>
  </div>
  <div class="col-md-10">
  <div name="leave_bal" id="balance"></div>
  </div>
  </div><br>

<div id="error"></div>

<div id="demo"></div>
<div class="row" >
  <div class="col-md-2">
  <label> From Date </label>
  </div>
  <div class="col-md-10">
  <input name="fromdate"  id="datepicker1" type="text"  style="width:350px;" required>
  <span><img src="images/calendar.png" ></span>
  </div>
 </div><br>

<div class="row">
  <div class="col-md-2">
  <label>To Date </label>
  </div>
  <div class="col-md-10" id="colsel">
<input name="todate"  id="datepicker2" type="text"  style="width:350px;"  required>
  <span><img src="images/calendar.png" ></span>
  </div>
  </div><br>
<div id="days"></div>

<div id="applied" name="no_days" ></div>
  
<div class="row">
  <div class="col-md-2">
  <label>Reason </label>
  </div>
  <div class="col-md-10">
  <textarea name="reason" id="field"  rows="4" cols="50"  required></textarea>
  </div>
  </div><br><br><hr id="hrbef">
  <input type="submit" id="btn"  value="Submit" name="submit" >
</form>

</div>
</div><br><hr id="hrline">


<?php
include('footer.php');
?>


<?php
if(isset($_POST['submit']))
{ echo "hhhhh";
	echo $leave_type=$_POST['leave_type'];
	echo $from_date=$_POST['fromdate'];
	echo $to_date=$_POST['todate'];
	echo $no_days=$_SESSION['no_days'];
echo	$duration=$_POST['duration'];
	echo$reason=$_POST['reason'];
	echo $id=$_SESSION['empid'];
	$sql="select * from tekhub_user_leave where leave_id='$leave_type' and emp_id='$id'";
  $retval=mysqli_query($conn,$sql);
  
  while($row= mysqli_fetch_array($retval)){
$leave_balance=$row['leave_balance'];
    
}
	
	$leave_balance_new=($leave_balance-$no_days);
	$leave_balance_duration=($leave_balance-$duration);

	if($no_days <= $leave_balance){
		$leave="Select leave_id,leave_type,leave_entitlements from tekhub_leaves where leave_id='$leave_type'";
		$retval1=mysqli_query($conn,$leave);
		if(!$retval1)
			{
			die('Could not fetch data: ' . mysqli_error($conn));
			}
		while($row1= mysqli_fetch_array($retval1)){
			$leave_id = $row1['leave_id'];
			$leave_name = $row1['leave_type'];
			$leave_entitlements = $row1['leave_entitlements'];
			}
		if($leave_name!="LOP"){
		if(isset($_POST['duration'])){
			$sql1="INSERT INTO tekhub_apply_leave					  (emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance,leave_status_id) 	VALUES('$id','$leave_id','$from_date','$to_date','$duration','$reason','$duration','$leave_balance_duration','1')";
			$retval2=mysqli_query($conn,$sql1);
			if(!$retval2){
				die('could not enter data:'.mysqli_error($conn));
				}
			$user_duration="UPDATE tekhub_user_leave set leave_balance='$leave_balance_duration' where emp_id='$id' and 		leave_id='$leave_type'";
		$retval4=mysqli_query($conn,$user_duration);
			if(!$retval4){
				die('could not enter data:'.mysqli_error($conn));
				}
			echo '<script language="javascript"> alert("Added successfully")</script>';
			}
		else{
		$sql2="INSERT INTO tekhub_apply_leave		(emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance,leave_status_id) VALUES		('$id','$leave_id','$from_date','$to_date','0','$reason','$no_days','$leave_balance_new','1')";
		$retval3=mysqli_query($conn,$sql2);
		if(!$retval3){
			die('could not enter data:'.mysqli_error($conn));
			}
		$user="UPDATE tekhub_user_leave set leave_balance='$leave_balance_new'and leave_taken='$no_days' where emp_id='$id' and leave_id='$leave_type'";
		$retval4=mysqli_query($conn,$user);
		if(!$retval4){
			die('could not enter data:'.mysqli_error($conn));
			}
		echo '<script language="javascript"> alert("Added successfully")</script>';
		}
	}
	else{
		$lop=$leave_entitlements+$no_days;
		$lop_duration=$leave_entitlements+$duration;
		if(isset($_POST['duration'])){
			
			$sql1="INSERT INTO tekhub_apply_leave					  (emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance,leave_status_id) 	VALUES('$id','$leave_id','$from_date','$to_date','$duration','$reason','$duration','$lop_duration','1')";
			$retval2=mysqli_query($conn,$sql1);
			if(!$retval2){
				die('could not enter data:'.mysqli_error($conn));
				}
			$user_duration="UPDATE tekhub_user_leave set leave_balance='$lop_duration' where emp_id='$id' and 		leave_id='$leave_type'";
		$retval4=mysqli_query($conn,$user_duration);
			if(!$retval4){
				die('could not enter data:'.mysqli_error($conn));
				}
			echo '<script language="javascript"> alert("Added successfully")</script>';
			}
		else{
		$sql2="INSERT INTO tekhub_apply_leave		(emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance,leave_status_id) VALUES		('$id','$leave_id','$from_date','$to_date','0','$reason','$no_days','$lop','1')";
		$retval3=mysqli_query($conn,$sql2);
		if(!$retval3){
			die('could not enter data:'.mysqli_error($conn));
			}
		$user="UPDATE tekhub_user_leave set leave_balance='$lop' where emp_id='$id' and leave_id='$leave_type'";
		$retval4=mysqli_query($conn,$user);
		if(!$retval4){
			die('could not enter data:'.mysqli_error($conn));
			}
		echo '<script language="javascript"> alert("Added successfully")</script>';
		}
		}
	}
	
	
	else{
		echo '<script language="javascript"> alert("Insufficient leave balance"+leave+leave_applied)</script>';
	}
}

?>


</body>
</html>