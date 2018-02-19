<?php
  include('header_admin.php');
?>


<div class="row" id="rowdash">
    <h1 id="h1head">Welcome To Admin Portal</h1>
    <h4 id="h4head">Here is a glimpse of the features available on the portal:</h4><br><br>
      <?php
        $sql2="SELECT * from tekhub_apply_leave as a inner JOIN tekhub_employee_personal_details as b on a.emp_id=b.emp_id INNER JOIN tekhub_leaves as c on a.leave_id=c.leave_id WHERE a.leave_status_id=1";
        $result=mysqli_query($conn, $sql2);
        $count=mysqli_num_rows($result);
      ?>
      <div class="notification" style="position:absolute;background-color:white;right:140px; margin-top:-115px;">
          <span id="notification-count"><?php  if($count>0) { echo $count; } ?></span><img src="images/notification.png" data-toggle="modal" data-target="#myModal" width="50px" />
      </div>    
    </h4><br><br>
  
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="left:500px; width:300px;">
      <div class="modal-content">
        <div class="modal-header" style="background-color:beige;"></br> 
          <?php
            echo "<h3  style='background-color:brown; height:35px;color:white;'> Applied Leaves</h3><br>";
            $sql="SELECT * from tekhub_apply_leave as a inner JOIN tekhub_employee_personal_details as b on a.emp_id=b.emp_id INNER JOIN tekhub_leaves as c on a.leave_id=c.leave_id WHERE a.leave_status_id=1";
            $result=mysqli_query($conn, $sql);
            $response='';
            $count=0;
            while($row=mysqli_fetch_array($result)) {
              $count=$count+1;
			   $emp_id_forleave=$row['emp_id'];
			    $emp_leave_id=$row['apply_leave_id']; 
			   
            echo "<a href='admin_update_leaves_notification.php?eid=$emp_id_forleave&leave_id=$emp_leave_id' style='text-decoration:none;'>".$count.".&nbsp;&nbsp;".$row['emp_name']."<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Applied for the ".$row['leave_type']."<hr id='hrline'>  </a>"; 
            }
          ?>   
        </div>
        <div class="modal-footer" style="background-color:beige;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
   
  

   <div class="col-md-6" id="colleftcont">

      <div class="row">
        <div class="col-md-2">
          <img src="images/empsearch.png" alt="Tekvity" id="dashimg">
        </div>
        <div class="col-md-10">
          <h3>Employee Directory</h3>
          <p>Find out coordinates of your colleagues….all compiled in an online directory.</p>
          <a id="a-btn" href="add_employee.php"><button type="button" class="btn">Add Employee</button></a> 
          <a id="a-btn" href="admin_edit_employee_details.php"><button type="button" class="btn">Edit Employee</button></a>    
        </div>
      </div><hr>
  
    <div class="row">
      <div class="col-md-2">
        <img src="images/payslip.png" alt="Tekvity" id="dashimg">
      </div>
      <div class="col-md-10">
        <h3>Pay Slip</h3>
        <p>Add salary for new employees for generating pay slips</p>
        <a id="a-btn" href="add_employee_payslip.php"><button type="button" class="btn">Add Employee</button></a>
        <a id="a-btn" href="admin_generate_payslip.php"><button type="button" class="btn">Generate Payslip</button></a>
        <a id="a-btn" href="admin_view_payslip.php"><button type="button" class="btn">View Payslip</button></a>
      </div>
    </div><hr>
  

    <div class="row">
      <div class="col-md-2">
        <img src="images/notice.png" alt="Tekvity" id="dashimg">
      </div>
      <div class="col-md-10">
        <h3>Notice Board</h3>
        <p>Get Updates about all the latest activities in the company, including all the important annoucements.</p>
      </div>
    </div><hr>

    <div class="row">
      <div class="col-md-2">
        <img src="images/policy.png" alt="Tekvity" id="dashimg">
      </div>
      <div class="col-md-10">
        <h3> Policies & Procedures</h3>
        <p>HR Policies & Procedures or Forms & Formats, all the information you often require is made available round 
      the clock!</p>
        <a id="a-btn" href="admin_upload_document.php"><button type="button" class="btn">Upload Policy & procedure</button></a> 
      </div>
    </div><hr>

    <div class="row">
      <div class="col-md-2">
        <img src="images/reward.png" alt="Tekvity" id="dashimg">
      </div>
      <div class="col-md-10">
        <h3> Rewards Recognitions</h3>
        <p>It is always important to showcase and appreciate efforts of our valuable team members. Well, we have 
      dedicated a space for the same!</p>
      </div>
    </div><hr>


    <div class="row">
      <div class="col-md-2">
        <img src="images/discussion.png" alt="Tekvity" id="dashimg">
      </div>
      <div class="col-md-10">
        <h3>Discussion Forum</h3>
        <p>Share knowledge, Have discussions on things that matter to you in the Company. After all, sharing is 
        caring!</p>
      </div>
    </div><hr>

    <div class="row">
      <div class="col-md-2">
        <img src="images/gallery.png" alt="Tekvity" id="dashimg">
      </div>
      <div class="col-md-10">
        <h3>Picture Gallery</h3>
        <p>Good times are forever! Relish all the beautiful moments of togetherness in this section.</p>
      </div>
    </div><hr>

    <div class="row">
      <div class="col-md-2">
        <img src="images/celebration.png" alt="Tekvity" id="dashimg">
      </div>
      <div class="col-md-10">
        <h3>Celebrations</h3>
        <p>Never miss out on the birthdays, wedding anniversaries etc. of your colleagues so that you catch them in 
    advance for a treat :)</p>
      </div>
    </div><hr>

  
  </div>



<div class="col-md-6" id="colrightcont">

  <div class="row">
    <div class="col-md-2">
      <img src="images/leave.png" alt="Tekvity" id="dashimg">
    </div>
    <div class="col-md-10">
      <h3>Leave Management</h3>
      <p>Manage your leaves and keep a track of the same.</p>
      <a id="a-btn" href="admin_generate_report.php"><button type="button" class="btn">Generate Report</button></a>
      <a id="a-btn" href="admin_update_leaves.php"><button type="button" class="btn">Leave Status</button></a>
      <a id="a-btn" href="admin_leave_entitlements.php"><button type="button" class="btn">Entitlements</button></a><br><br>
      <a id="a-btn" href="admin_apply_leave.php"><button type="button" class="btn">Assign Leave</button></a>
      <a id="a-btn" href="admin_add_leaves.php"><button type="button" class="btn">Add Leave</button></a><br>
    </div>
  </div><hr>


  <div class="row">
    <div class="col-md-2">
      <img src="images/timesheet.png" alt="Tekvity" id="dashimg">
    </div>
    <div class="col-md-10">
      <h3>Timesheet Management</h3>
      <p>Manage your weekly timesheets and Keep track of the same </p><br>
    </div>
  </div><hr>


  <div class="row">
    <div class="col-md-2">
      <img src="images/exit.png" alt="Tekvity" id="dashimg">
    </div>
    <div class="col-md-10">
      <h3>Exit Management</h3>
      <p>Decided to leave for good? We will ensure you have a smooth exit. Just one request….Stay in touch!</p>
    </div>
  </div><hr>



  <div class="row">
    <div class="col-md-2">
      <img src="images/performance.png" alt="Tekvity" id="dashimg">
    </div>
    <div class="col-md-10">
      <h3>Performance Management</h3>
      <p>Keep a track of your performance assessment online through a comprehensive Performance Management module.
    </p>
    </div>
  </div><br><hr>



  <div class="row">
    <div class="col-md-2">
      <img src="images/leader.png" alt="Tekvity" id="dashimg">
    </div>
    <div class="col-md-10">
      <h3> Leadership Update</h3>
      <p>Management Gyaan, Business Updates or Valuable Experiences. Get all the important information directly from 
    the leadership.</p>
    </div>
  </div><hr>


  <div class="row">
    <div class="col-md-2">
      <img src="images/jobsearch1.png" alt="Tekvity" id="dashimg">
    </div>
    <div class="col-md-10">
      <h3>  Job Referrals</h3>
      <p>Keep an eye on the vacancies available within the Company and refer your friends for the same.</p>
    </div>
  </div><hr>

  
  <div class="row">
    <div class="col-md-2">
      <img src="images/suggestion.png" alt="Tekvity" id="dashimg">
    </div>
    <div class="col-md-10">
      <h3> Suggestion Box</h3>
      <p>Have a suggestion? Submit the same online. We welcome your suggestions and try to improvise.</p>
    </div>
  </div><hr>


</div>
</div><br><br><hr id="hrline">


<?php
  include('footer.php');
?>





