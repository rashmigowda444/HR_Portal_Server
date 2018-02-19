<?php
include('header_admin.php');

?>

<script type="text/javascript">

function searchone(str)
{

var xmlhttp;
var emp_name= document.getElementById("field1").value;
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

  xmlhttp.open("POST", "searchone.php", true);          
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");            
  xmlhttp.send(the_data);       


  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4) {
      document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
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

function getInfo(str1) {
	
  if (str1=="") {
    document.getElementById("field1").innerHTML="";
	
    return;
  } 
  
  if (window.XMLHttpRequest) {
    
    xmlhttp=new XMLHttpRequest();
  } else { 
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("field1").innerHTML=this.responseText;
    }
  }
  
  
  xmlhttp.open("GET","getleaves.php?r="+ str1 + "&q=" + str,true);
  
  xmlhttp.send();
}
</script>
<?php
$year= date("Y");
//$emp_id=$_SESSION['empid'];
$date_holiday=array();

	

$holiday="select * from tekhub_user_holiday tuh join tekhub_add_employee tae on tuh.holiday_type_id=tae.emp_holiday_id  where tuh.year = $year";
	
$retval=mysqli_query($conn,$holiday);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  while($row= mysqli_fetch_array($retval)){
  $date_holiday[]=$row['date'];
  $holiday_date=json_encode($date_holiday);
  }
  $test=trim($holiday_date,'[ " " ]');
  echo "<br>";
	
?>
<script>
var gon = [];
gon["holiday"] = "<?php echo $test ?>".split('","');
document.write(gon["holiday"]);

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
      document.getElementById("txthin").innerHTML=this.responseText;
      
    }
  }

xmlhttp.open("GET","ltest1.php?days="+days,true);
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
alert("insufficient leave balance");
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

</script>
 <div class="row">
<div class="col-md-2">
  <label>Employee name  </label>
  </div>



 <div class='col-md-10'>
 <div class='search-box'>
        <input type='text' autocomplete='off' placeholder='Search Name...' name='emp_name'  id="field1" <!--onchange="getInfo(this.value)"--></td>
<p id="demo"></p>		
</form>
        <div class='result'></div>
    </div>
	</div>
	</div>
 
</br></br>


<script type="text/javascript">
    function getInfo(str1){
        var emp_name=document.getElementById('emp_name');
        emp_name.value=str1;
    }
</script>

<script>
$(function() {
    $( "#field1" ).autocomplete({
        source: 'searchname.php'
		
    });
});
</script>


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
 <select  id='field' onchange='searchone(this.value)' name='leave_type'  required>
    <option >-----Select----</option>
	<option value='0'>All</option>";
  while($row= mysqli_fetch_array($retval)){
  $leave_id=$row['leave_id'];
  $leave_type=$row['leave_type'];
 echo" <option value=".$leave_id.">". $leave_type . "</option>";
  }
    echo" </select>
  </div>
  </div><br>";
  ?> 
 
 
 
  <input type="submit"  />
  
<div class="row"   id="rowduration">
  <div class="col-md-2">
  <label>Leave Balance </label>
  </div>
  <div class="col-md-10">
  <div name="leave_bal" id="txtHint"></div>
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

 <div id="txthin" name="no_days" ></div>
  
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
if(isset($_POST['sub1'])){
	echo "1dddd";
	$emp_name=$_POST['emp_name'];
	
$leave_type=$_POST['leave_type'];
$leave_balance=$_POST['leave_bal'];
$from_date=$_POST['fromdate'];
$to_date=$_POST['todate'];
$no_days=$_POST['no_days'];
$duration=$_POST['duration'];
$reason=$_POST['reason'];
//$id=$_POST['emp_id'];
echo $from_date;
echo $to_date;
$from=date_create($from_date);
$to=date_create($to_date);
$diff= date_diff($from,$to);
$days=$diff->format("%d");
echo $days;

$sql="select * from tekhub_user_leave where leave_id='$leave_type' and emp_name='$emp_name'";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  while($row= mysqli_fetch_array($retval)){
$leave_balance=$row['leave_balance'];
    
}
$leave_balance_new=$leave_balance-$days;
if($days < $leave_balance){
$leave="Select leave_id from tekhub_leaves where leave_id='$leave_type'";
$retval1=mysqli_query($conn,$leave);
if(!$retval1)
{
die('Could not fetch data: ' . mysqli_error($conn));
}
while($row1= mysqli_fetch_array($retval1)){
$leave_id = $row1['leave_id'];
}
if(isset($_POST['duration'])){
$sql1="INSERT INTO tekhub_apply_leave(emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance) VALUES('$id','$leave_id','$from_date','$to_date','$duration','$reason','$duration','$leave_balance')";
$retval2=mysqli_query($conn,$sql1);
if(!$retval2){
die('could not enter data:'.mysqli_error($conn));
}
echo '<script language="javascript"> alert("Added successfully")</script>';
}
else{
$sql2="INSERT INTO tekhub_apply_leave(emp_id,leave_id,from_date,to_date,duration,comment,no_of_days,leave_balance) VALUES('$id','$leave_id','$from_date','$to_date','0','$reason','$days','$leave_balance_new')";
$retval3=mysqli_query($conn,$sql2);
if(!$retval3){
die('could not enter data:'.mysqli_error($conn));
}
$user="UPDATE tekhub_user_leave set leave_balance='$leave_balance_new' where emp_id='$id' and leave_id='$leave_type'";
$retval4=mysqli_query($conn,$user);
if(!$retval4){
die('could not enter data:'.mysqli_error($conn));
}
echo '<script language="javascript"> alert("Added successfully")</script>';
}
}
else{
echo '<script language="javascript"> alert("Insufficient leave balance")</script>';
}
}
?>


</body>
</html>
