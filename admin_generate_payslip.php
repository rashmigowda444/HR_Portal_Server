<?php
  include('header_admin.php');
  date_default_timezone_set('GMT');
?>

<script type="text/javascript">
	$(function() {
	  var start_year = new Date().getFullYear();

	  for (var i = start_year; i > start_year - 2; i--) {
	    $("#year").append('<option value="' + i + '">' + i + '</option>');
	  }
	});
</script>

<div class="row" >
  	<div class="well" id="headingwell">
  		<h3 id="headingdash">Generate Payslip</h3>
  	</div>

	<div class="well" id="contentwell">
		<form method="POST" action="fetch_payslip.php">
			<div class="row">
			  <div class="col-md-2">
			  	<label>Select Year : </label>
			  </div>
			  <div class="col-md-6">
				<select name="year" class="form-control" id="year" style="width:350px;height:35px;border-radius:5px;border:none;background-color:white;" required>
					<option value='' >-----Select----</option>
				</select>
			  </div>
			</div><br>

			<div class="row">
			  <div class="col-md-2">
			  	<label>Select Month : </label>
			  </div>
			  <?php 
			  $sql="select * from tekhub_month";
			  $retval=mysqli_query($conn,$sql);
			  if(!$retval){
			  die('could not enter data:'.mysqli_error());
			  }
			  echo"<div class='col-md-6'>
			  <select name='leave_month' class='form-control' id='field' required>
			      <option value='' >-----Select----</option>";
				  while($row= mysqli_fetch_array($retval)){
				  $month_value=$row['month_value'];
				  $month_name=$row['month_name'];
				 echo" <option value=".$month_value.">". $month_name . "</option>";
				  }
			 echo" </select>
			  </div>
			</div><br><br><hr id='hrbef'>";
			  ?>

			<button type="submit" id="btn" class="btn">Submit</button>&emsp;&emsp;
				<a id="a-btn" href="admin_dashboard.php"><button type="button" id="btn" class="btn">Back</button></a>
		</form>
	</div>

</div><br><hr id="hrline">


<?php
  include('footer.php');
?>