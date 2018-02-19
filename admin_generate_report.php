<?php
  include('header_admin.php');
?>
<script>
var xport = {
  _fallbacktoCSV: true,  
  toXLS: function(tableId, filename) {   
    this._filename = (typeof filename == 'undefined') ? tableId : filename;
    
    //var ieVersion = this._getMsieVersion();
    //Fallback to CSV for IE & Edge
    if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
      return this.toCSV(tableId);
    } else if (this._getMsieVersion() || this._isFirefox()) {
      alert("Not supported browser");
    }

    //Other Browser can download xls
    var htmltable = document.getElementById(tableId);
    var html = htmltable.outerHTML;

    this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls'); 
  },
  toCSV: function(tableId, filename) {
    this._filename = (typeof filename === 'undefined') ? tableId : filename;
    // Generate our CSV string from out HTML Table
    var csv = this._tableToCSV(document.getElementById(tableId));
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv" });

    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {      
      this._downloadAnchor(URL.createObjectURL(blob), 'csv');      
    }
  },
  _getMsieVersion: function() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }
    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }

    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }

    // other browser
    return false;
  },
  _isFirefox: function(){
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }
    
    return 0;
  },
  _downloadAnchor: function(content, ext) {
      var anchor = document.createElement("a");
      anchor.style = "display:none !important";
      anchor.id = "downloadanchor";
      document.body.appendChild(anchor);

      // If the [download] attribute is supported, try to use it
      
      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
  },
  _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;

    return slice
      .call(table.rows)
      .map(function(row) {
        return slice
          .call(row.cells)
          .map(function(cell) {
            return '"t"'.replace("t", cell.textContent);
          })
          .join(",");
      })
      .join("\r\n");
  }
};
</script>
<script>
function validateForm() {
    
	var leave_type=document.forms["myForm"]["fieldleavetype"].value;
	
	
    if (leave_type =="select") { 
	
        alert("please select leave type");
        return false;
    }
	
}
</script>
<script>
function validateFormsec() {
    
	var leave_typesec=document.forms["myFormsec"]["fieldleavetypesec"].value;
	
	
    if (leave_typesec =="select") { 
        alert("please select leave type");
        return false;
    }fieldleavetypedate
	var fieldleavetypedate=document.forms["myFormsec"]["fieldleavetypedate"].value;
    if (fieldleavetypedate =="select") { 
        alert("please select year");
        return false;
    }
	
}
</script>
<script>
$(document).ready(function() {
  $('#field').on('change.div1', function() {
    $("#emp").toggle($(this).val() == 'div1');
     $("#leave").toggle($(this).val() == 'div2');
  }).trigger('change.states');
});
</script>
<script>
$(function() {
    $( "#field1" ).autocomplete({
        source: 'search.php'
    });
});
</script>
<script type="text/javascript">
        $(function() {
  var start_year = new Date().getFullYear();

  for (var i = start_year; i > start_year - 2; i--) {
    $(".year").append('<option value="' + i + '">' + i + '</option>');
  }
});
    </script>
<div class="row" >
  <div class="well" id="headingwell">
  <h3 id="headingdash">Generate Leave Report</h3>
  </div>
  <div class="well" id="contentwell">
  <div class="row">
  <div class="col-md-3">
  <label >
 <font style="font-size:20px;"> Generate For :</font></label>
  </div>
  <div class="col-md-9">
  <select class="form-control" id="field" name="sel">
    <option disabled="disabled" selected="selected">-----Select-----</option>
    <option value="div1">Employee</option>
    <option value="div2">Leave Type</option>
  </select></br>
  </div> <div >&emsp;
  <a href="admin_dashboard.php"><input type="button"  class="btn btn-default" value="Back"></input></a> </div>
  </div>
</div>
</div><br>
<div class="row" name="div1" id="emp" style="display:none">
  <div class="well" id="headingwell">
  <h3 id="headingdash">Fetch Leaves</h3>
  </div>
  <div class="well" id="contentwell">
  <form method="post" name="myForm" onsubmit="return validateForm()">
  <table class="table table-striped">
    <thead>
      <tr style="font-size:20px;">
<th>Employee Name:</th>
<th>Leave Type:</th>
<th>Year:</th>
</tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="field1" name="emp_name" required></td>
<td><?php 
  $sql="select * from tekhub_leaves";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"
 <select id='fieldleavetype' class='form-control'  name='leave_type'  required>
    <option value='select'>-----Select----</option>
  <option value='0'>All</option>";
  while($row= mysqli_fetch_array($retval)){
  $leave_id=$row['leave_id'];
  $leave_type=$row['leave_type'];
 echo" <option value=".$leave_id.">". $leave_type . "</option>";
  }
    echo" </select>";
  ?></td>
<td><select name="year" class="form-control year" id="yearid" required >
<option value="">--select--</option>
</select></td>
      </tr>
    
    </tbody>
</table>
<hr>
<input type="submit" name="sub1" class="btn btn-default" value="Submit" >&emsp;&emsp;
<input type="reset"  class="btn btn-default" value="Reset"></input>
</form>
</div>
</div>
<div class="row" name="div2" id="leave" style="display:none">
  <div class="well" id="headingwell">
  <h3 id="headingdash">Fetch Leaves</h3>
  </div>  
<div class="well" id="contentwell">
  <form method="post" name="myFormsec" onsubmit="return validateFormsec()">
  
    <table><tr><th><label> <font style="font-size:20px;"> Leave Type:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</font></label></th>
   <td>
  <?php 
  $sql="select * from tekhub_leaves";
  $retval=mysqli_query($conn,$sql);
  if(!$retval){
  die('could not enter data:'.mysqli_error());
  }
  echo"
  <select id='fieldleavetypesec' style='width:350px;height:35px;border-radius:5px;border:none;background-color:white;' class='form-control'  name='leave_type'  required>
    <option value='select'>-----Select----</option>
	<option value='0'>All</option>";
  while($row= mysqli_fetch_array($retval)){
 $leave_id=$row['leave_id'];
  $leave_type=$row['leave_type'];
 echo" <option value=".$leave_id.">". $leave_type . "</option>";
  }
    echo" </select>
  
  "; 	echo"</td><th><label><font style='font-size:20px;'> &emsp;Year:&emsp;</label></th><td>";
		$sqlforyear="SELECT DISTINCT year(year) as olydate FROM  tekhub_user_leave";
		$retvalforyear=mysqli_query($conn,$sqlforyear);
		if(!$retvalforyear){
      die('could not enter data:'.mysqli_error());
                }
		echo "<select class='form-control' id='fieldleavetypedate' name='year1' style='width:350px;height:35px;border-radius:5px;border:none;background-color:white;'  required> <option value='select'>select </option>";		
		while($row1= mysqli_fetch_array($retvalforyear))
		{  $year=$row1['olydate'];
		echo"
		<option>$year </option>";
        }
         echo"
      </select></td></tr></table>";  
  ?> </br>
<input type="submit" name="sub2" class="btn btn-default" value="Submit"> &emsp;&emsp;
<input type="reset"  class="btn btn-default" value="Reset"></input></a>
</form>
</div>
</div><br>
<br>
<?php
if (isset($_POST['sub1'])) 
{   
echo "<div class='row' id='leave_div'>
  <div class='well' id='headingwell'>
  <h3 id='headingdash'>Leave Details</h3>
  </div>

  
  <div class='well' id='contentwell'> ";
	 $emp_name1=$_POST['emp_name'];	
 $year1=$_POST['year'];
 $leave_type=$_POST['leave_type'];
$sql_for_id ="SELECT * FROM `tekhub_employee_personal_details` WHERE emp_name='$emp_name1'";
  $retval1=mysqli_query($conn,$sql_for_id);
  if(!$retval1)
  {
die('Could not fetch data: ' . mysqli_error($conn));
  }

while($row= mysqli_fetch_array($retval1,MYSQLI_ASSOC))
{
    $emp_id=$row['emp_id'];
     $emp_namee=$row['emp_name'];
}    
     if($leave_type==0)
{   

echo "<table class='table table-bordered view' id='leave_report'>
    <thead>
      <tr bgcolor='	#A52A2A'> 
	  <th><font color='#ffffff'>Employee Name
	  </font></th> 
	  <th><font color='#ffffff'>Employee id</font></th>
		<th><font color='#ffffff'>Leave Type</font></th><th><font color='#ffffff'>Leave Entitlements</font></th>
        <th><font color='#ffffff'>Leave Balance</font></th>
      </tr>
    </thead>
    <tbody>";
	$sql1="SELECT * FROM `tekhub_leaves` as a
	INNER join tekhub_user_leave as b on a.leave_id=b.leave_id 
	INNER JOIN tekhub_add_employee as d on d.emp_id=b.emp_id
	WHERE d.emp_id='$emp_id'  and year(b.year)='$year1' GROUP BY b.leave_id";
	
	$retval1=mysqli_query($conn,$sql1);
	$count=mysqli_num_rows($retval1);
	if($count>=1)
	{}

else {echo '<script language="javascript"> alert("NO Data found")</script>';}

	if(!$retval1) 
		{  
die('Could not fetch data: ' . mysqli_error($conn));
         }
  while($row= mysqli_fetch_array($retval1,MYSQLI_ASSOC))
     {  
    	  echo"
	 <tr>
<td>{$row['emp_name']}</td> <td>{$row['emp_id']}</td> <td>{$row['leave_type']}</td><td>{$row['leave_entitlements']}</td><td>{$row['leave_balance']}</td>      </tr>";

	 }//while end
	 echo "</tbody></table>";
	?>  <form method="post">
	   <button id="btnExport"  class="btn" onclick="javascript:xport.toCSV('leave_report');">Export</button> </form> <?php
	 }//if end
	 else
	 {  echo "<table class='table table-bordered view' id='leave_report'>
    <thead>
      <tr bgcolor='	#A52A2A'>
	  <th><font color='#ffffff'>Employee Name:</font></th>
        <th><font color='#ffffff'>Emplyee Id:</font></th>
		<th><font color='#ffffff'>Leave Type:</font></th><th><font color='#ffffff'>Leave Entitile</font></th>
        <th><font color='#ffffff'>Leave Balance</font></th>
      </tr>
    </thead>
    <tbody>";
	      $sql1="SELECT * FROM `tekhub_leaves` as a 
		 INNER join tekhub_user_leave as b on a.leave_id=b.leave_id 
		 INNER JOIN tekhub_employee_personal_details as d on d.emp_id=b.emp_id 
		 WHERE b.emp_id='$emp_id' and year(b.year)=$year1 and b.leave_id='$leave_type'";
	
	$retval1=mysqli_query($conn,$sql1);
	$count=mysqli_num_rows($retval1);
	if($count>=1)
	{}

else {echo '<script language="javascript"> alert("NO Data found")</script>';}

	if(!$retval1) 
		{  
die('Could not fetch data: ' . mysqli_error($conn));
         }
  while($row= mysqli_fetch_array($retval1,MYSQLI_ASSOC))
     {  
      	  echo " 
	 <tr><td>{$row['emp_name']}</td>
<td>{$row['emp_id']} </td>                                
<td>{$row['leave_entitlements']}</td>
<td>{$row['leave_type']}</td><td>{$row['leave_balance']}</td>      </tr>";

	 }//while end
	 echo "</tbody></table>";
	
?>	  <form method="post">
	   <button id="btnExport"  class="btn" onclick="javascript:xport.toCSV('leave_report');">Export</button> </form>
	<?php 	 
	 }
}
elseif (isset($_POST['sub2'])) 
{ echo "<div class='row' id='leave_div'>
  <div class='well' id='headingwell'>
  <h3 id='headingdash'>Leave Details</h3>
  </div>

  <div class='well' id='contentwell'> ";

 $leave_type=$_POST['leave_type'];
$year1=$_POST['year1'];
 $leave_type;
 if($leave_type!=0)
 {	 
$sql="Select * from tekhub_user_leave as A inner join tekhub_employee_personal_details as B on A.emp_id=B.emp_id INNER 
JOIN tekhub_leaves as c on c.leave_id=A.leave_id where c.leave_id='$leave_type' and year(A.year)='$year1'";

  $retval=mysqli_query($conn,$sql);
	$count=mysqli_num_rows($retval);
	if($count>=1)
{    if(!$retval)
      {
die('Could not fetch data: ' . mysqli_error($conn));
      }
    echo "<table class='table table-bordered view' id='leave_report'>
    <thead>
      <tr bgcolor='	#A52A2A'>
	  <th><font color='#ffffff'>Employee Name<font></th>
        <th><font color='#ffffff'>Employee Id<font></th>
        
		<th><font color='#ffffff'>Leave Type</font></th><th><font color='#ffffff'>Leave Entitile</font></th>
        <th><font color='#ffffff'>Leave Balance</font></th>
      </tr>
    </thead>
    <tbody>";
    while($row1= mysqli_fetch_array($retval,MYSQLI_ASSOC))
	{  $emp_id_no_of_days=$row1['emp_id'];
	 
echo "<tr>
        <td>{$row1['emp_name']}</td><td> {$row1['emp_id']} </td>
		<td>{$row1['leave_type']}</td><td>{$row1['leave_entitlements']}</td>
        <td>{$row1['leave_balance']}</td>";
       
      echo "</tr>";
	}
	
	}
	else
	{
  echo '<script language="javascript"> alert("Result Not found")</script>';
	}

    echo "</tbody>
  </table>";
  
 }else
 {
$sql="Select * from tekhub_user_leave as A inner join tekhub_employee_personal_details as B on A.emp_id=B.emp_id INNER JOIN tekhub_leaves as c on c.leave_id=A.leave_id where year(A.year)='$year1' ORDER BY A.emp_id ASC";

  $retval=mysqli_query($conn,$sql);
	$count=mysqli_num_rows($retval);
	if($count>=1)
{    if(!$retval)
      {
die('Could not fetch data: ' . mysqli_error($conn));
      }
    echo "<table class='table table-bordered view' id='leave_report'>
    <thead>
      <tr bgcolor='	#A52A2A'>
	  <th><font color='#ffffff'>Employee Name<font></th>
        <th><font color='#ffffff'>Employee Id<font></th>
        
		<th><font color='#ffffff'>Leave Type</font></th><th><font color='#ffffff'>Leave Entitile</font></th>
        <th><font color='#ffffff'>Leave Balance</font></th>
      </tr>
    </thead>
    <tbody>";
    while($row1= mysqli_fetch_array($retval,MYSQLI_ASSOC))
	{  $emp_id_no_of_days=$row1['emp_id'];
	 
echo "<tr>
        <td>{$row1['emp_name']}</td><td> {$row1['emp_id']} </td>
		<td>{$row1['leave_type']}</td><td>{$row1['leave_entitlements']}</td>
        <td>{$row1['leave_balance']}</td>";   
      echo "</tr>";
	}
	}
	else
	{
  echo '<script language="javascript"> alert("Result Not found")</script>';
	}

    echo "</tbody>
  </table>";
  
	 
	 
 }
  ?>
  <form method="post">
	   <button id="btnExport" class="btn" onclick="javascript:xport.toCSV('leave_report');">Export</button> </form> <?php
}
 mysqli_close($conn);
  ?>
  </div>
</div>
<hr id="hrline">
<?php

  include('footer.php');
?>