<?php
  include('header_admin.php');
?>

<script type="text/javascript">
	$(function() {
    $( "#field1" ).autocomplete({
        source: 'searchname.php'
		
    });
   });
</script>

<div class="row" >
  	<div class="well" id="headingwell">
  		<h3 id="headingdash"><div class="row">Edit Employee
  <span style="float:right;"> 
  <a href="admin_dashboard.php">
  <img src="images\backarrow.png" style="width:35px;hieght:30px;margin-top:-9px;margin-right:8px;"> </a> </span>
  
  	</div></h3>
 </div>

<div class="well" id="contentwell">
		<form method="POST" action="edit_employee.php">

			<div class="row">
			 	<div class="col-md-2">
			  	<label>Employee Name : </label>
			  	</div>
			  	<div class="col-md-6">
				<input type="text" class="form-control" placeholder="Search Name..." name="name" id="field1" style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;" required>
				</div>
			</div><br>

			<div class="row">
			 	<div class="col-md-2">
			  	<label>Status : </label>
			  	</div>
			  	<div class="col-md-6">
				<select style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;" required name="en">
					<option value="1">Enable</option>
					<option value="0">Disable</option>
				</select>
				</div>
			</div><br>

			<button type="submit" id="btn" class="btn">Submit</button>&emsp;&emsp;
			<button type="reset" id="btn" class="btn">Reset</button>

		</form>
</div>




<br><br><br><br>
<br><br><br>
<br><br>
<hr id="hrline">
<?php
include('footer.php');
?>