<?php
include('header_admin.php');
	
?>

<script type="text/javascript">
function searchone(str)
{
var xmlhttp;
var emp_name= document.getElementById("field1").value;
if(emp_name=="")
{ alert("please choose name");
}
var the_data = ''
    + 'select=' + window.encodeURIComponent(str)
    + '&name=' + window.encodeURIComponent(emp_name);
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.open("POST", "searchone_for_admin_apply_leave.php", true);          
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");            
  xmlhttp.send(the_data);       
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4) {
      document.getElementById("balance").innerHTML = xmlhttp.responseText;
    }
  }
}

$(function() {
$('form').each(function() {
    $('input').keypress(function(e) {
        // Enter pressed?
        if(e.which == 10 || e.which == 13) {
            this.form.submit();
        }
    });

    $('input[type=submit]').hide();
   });
});
</script>
<script>
function validatetodate() { 
	
	 var fromdate1=document.getElementById("datepicker1").value;
	 if(fromdate1==''||fromdate1==null)
	 {
		 alert("please Select Leave from the date");
		 return false;
	 }
	
}
</script>
<script>
function validatefromdate() { 
	var startDate = document.getElementById("datepicker1").value;
    var endDate = document.getElementById("datepicker2").value;

    if ((Date.parse(startDate) > Date.parse(endDate))) {
        alert("From Date should be lesser than To Date");
        document.getElementById("datepicker1").value =null;
    } 
	
}
</script>
<script>
function showleave(str) {
	var searchtext11= document.getElementById("emp_name").value;
	
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
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
      document.getElementById("txtHint").innerHTML=this.responseText;
    }
  }
  var  the_data = 'select='+str+'text='+searchtext11;
  xmlhttp.open("POST", "getleaves.php", true);          
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");            
  xmlhttp.send(the_data);
}

</script>
<script>
$(function() {
    $( "#field1" ).autocomplete({
        source: 'searchname.php'
		
    });
});
</script>
<script>
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
	   document.getElementById("datepicker2").value=null;
    }
    else {
		 if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) { 
      document.getElementById("applied").innerHTML=this.responseText;
	  
	  
	   var returned_string = this.responseText;
	  
        
		 var numdays=returned_string.charAt(0);
		
		 var leave_type=document.forms["myForm"]["field"].value; 
         var emp_name=document.forms["myForm"]["field1"].value;
		 if(emp_name==null)
		 {
			 alert("please choose name");
		 }
if(leave_type==null)
		 {
			 alert("please select leave type");
		 }
	 if(numdays>2 && leave_type==1)
	 {
		 alert("Cannot take more than two leaves please contact hr team");
	 }
	 else
	 {
		if(numdays>3 && leave_type==3)
	 {
		 alert("Cannot take more than two leaves please contact hr team");
	 } 
	 }
      
    }
  }
xmlhttp.open("GET","ltest_admin.php?days="+days,true);
  xmlhttp.send();

    }
}
});   
    });
</script>
<script>
function apply(){
var leave_applied=document.getElementById("txthin").innerHTML;
 var leave=document.getElementById("txtHint").innerHTML;
    if(leave_applied>leave){
alert("insufficient leave balance.");
}
else{
}
 }
 
</script>
<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Apply Leave</h3>
  </div>

<div class="well" id="contentwell">
<form method="post">

<div class="row">
<div class="col-md-2">
  <label>Employee name  </label>
  </div>
 <div class='col-md-10'>
 <div class='search-box'>
        <input type='text' autocomplete='off' placeholder='Search Name...' name='emp_name'  onchange="getname(this)" id="field1" 
		
		style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;"
		required> </td>
<p id="demo"></p>		

       <div class='result'></div>
    </div>
	</div>
	</div></br></br>	

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
 <select required id='field' onchange='searchone(this.value)' class='leaveid' name='leave_type' required>
    <option value=''>-----Select----</option>";
  while($row= mysqli_fetch_array($retval)){
  $leave_id=$row['leave_id'];
  $leave_type=$row['leave_type'];
 echo" <option value=".$leave_id.">". $leave_type . "</option>";
  }
    echo" </select>
  </div>
  </div><br>";
  ?>

  <?php	 $emp_id=911;
  if(isset( $_SESSION['0.5']))
  {
  }
if(isset($_SESSION['emp_id2']))
{     
$emp_id=$_SESSION['emp_id2'];
}
$year= date("Y");

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
//document.write(gon["holiday"]);
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
	    document.getElementById("datepicker2").value="";
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
  <input name="fromdate"  id="datepicker1" type="text" onchange="validatefromdate()" style="width:350px;" required>
  <span><img src="images/calendar.png" ></span>
  </div>
 </div><br>

<div class="row">
  <div class="col-md-2">
  <label>To Date </label>
  </div>
  <div class="col-md-10" id="colsel">
<input name="todate"  id="datepicker2" type="text" onchange="validatetodate()" style="width:350px;"  required>
  <span><img src="images/calendar.png" ></span>
  </div>
  </div><br>
<div id="days"></div>
<div class="row"   id="rowduration">
  <div class="col-md-2">
  <label>No Of Days </label>
  </div>
  <div class="col-md-10">
  <div id="applied" name="no_days" ></div>
  </div>
  </div><br>
<div class="row">
  <div class="col-md-2">
  <label>Reason </label>
  </div>
  <div class="col-md-10">
  <textarea name="reason" style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;" rows="4" cols="50" rows="4" cols="50"  required></textarea>
  </div>
  </div><br><br> 
  <div class="row">
   
 <button  class="btn btn-default"  type="submit">submit</button>
&emsp;&emsp;<a href="admin_dashboard.php"><input type="button"   class="btn btn-default"  value="Back"></input></a>

  
 
 </div>

 <hr id="hrbef">
  
</form>

</div>
</div><br><hr id="hrline">
<?php
include('footer.php');
?>

<?php
if(isset($_POST['leave_type']))
{   $leave_type=$_POST['leave_type'];
  	$from_date=$_POST['fromdate'];
	$to_date=$_POST['todate'];
	$no_days=$_SESSION['no_days'];

	$lop_duration=$no_days;
if(isset($_POST['duration']))
{$duration=$_POST['duration'];
} else{ $duration=1;
}
	$reason=$_POST['reason'];
	$id=$_SESSION['emp_id2'];
	if($leave_type==1 && $no_days>2)
{
echo "<script >alert('Cannot taken morethan two Casual leaves please contact hr team')</script>";
exit;
}
else if($leave_type==3 && $no_days>2)
{
echo "<script >alert('Cannot taken morethan two Sick leaves please contact hr team')</script>";
exit;
}


$sql_for_date_compare="select * from tekhub_apply_leave WHERE 
(from_date='$from_date' or    to_date='$to_date' ) and emp_id='$id' and leave_id='$leave_type'";
  $retval_for_date=mysqli_query($conn,$sql_for_date_compare);

while($row_date= mysqli_fetch_array($retval_for_date)){
	$from_date_db = $row_date['from_date'];
	$to_date_db = $row_date['to_date'];
	echo $from_date_db;
	if($from_date==$from_date_db||$from_date==$to_date_db||$to_date==$from_date_db||$to_date==$to_date_db )
	{
		echo "<script> alert('Leave already taken for this  date, please check the date and try again   '); </script>";
	exit;
	}

}
	$sql="select * from tekhub_user_leave where leave_id='$leave_type' and emp_id='$id'";
  $retval=mysqli_query($conn,$sql);
  
  while($row= mysqli_fetch_array($retval)){ 
 $leave_balance=$row['leave_balance'];

    
} 
 $leave_balance_new=($leave_balance-$no_days);

	 $leave_balance_duration=($leave_balance-$duration);
     if($no_days <= $leave_balance){ 
	 
		$leave="Select * from tekhub_leaves as A join tekhub_user_leave as B on A.leave_id=B.leave_id where A.leave_id='$leave_type'";
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
			echo '<script language="javascript"> alert("Applied successfully")</script>';
			exit;
			}
		else{ 
		$sql2="INSERT INTO tekhub_apply_leave		(emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance,leave_status_id) VALUES		('$id','$leave_id','$from_date','$to_date','0','$reason','$no_days','$leave_balance_new','1')";
		$retval3=mysqli_query($conn,$sql2);
		if(!$retval3){
			die('could not enter data:'.mysqli_error($conn));
			}
		$user="UPDATE tekhub_user_leave set leave_balance='$leave_balance_new' where emp_id='$id' and leave_id='$leave_type'";
		$retval4=mysqli_query($conn,$user);
		if(!$retval4){
			die('could not enter data:'.mysqli_error($conn));
			}
		echo '<script language="javascript"> alert("Applied successfully")</script>';
		exit;
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
			echo '<script language="javascript"> alert("Applied successfully")</script>';
			exit;
			
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
		echo '<script language="javascript"> alert("Applied successfully")</script>';
		exit;
		}
		}
	}
	else if($no_days == 1 && $duration<=$leave_balance)
	{
    $sql2="INSERT INTO tekhub_apply_leave (emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance,leave_status_id) VALUES ('$id','$leave_type','$from_date','$to_date','$duration','$reason','$no_days','$leave_balance','1')";
    $retval3=mysqli_query($conn,$sql2);
    if(!$retval3){
      die('could not enter data:'.mysqli_error($conn));
    }
    $user="UPDATE tekhub_user_leave set leave_balance='$leave_balance_duration' where emp_id='$id' and leave_id='$leave_type'";
    $retval4=mysqli_query($conn,$user);
    if(!$retval4){
      die('could not enter data:'.mysqli_error($conn));
    }
    echo '<script language="javascript"> alert("Applied successfully")</script>';
   exit;
  }
	
	
	if($leave_type==4) 
{ 
$sql2="INSERT INTO tekhub_apply_leave (emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance,leave_status_id)
VALUES ('$id','$leave_id','$from_date','$to_date','0','$reason','$no_days','$leave_balance_new','1')";

$retval2=mysqli_query($conn,$sql2);
if(!$retval2){
die('could not enter data:'.mysqli_error($conn));
}
$user_duration="UPDATE tekhub_user_leave set leave_taken='$lop_duration' where emp_id='$id' and leave_id='$leave_type'";
$retval4=mysqli_query($conn,$user_duration);
if(!$retval4){
die('could not enter data:'.mysqli_error($conn));
}
echo '<script language="javascript"> alert("Applied successfully")</script>';
exit;
}



else{
echo '<script language="javascript"> alert("Insufficient leave balance")</script>';
}

	
}

?>

</body>
</html>
