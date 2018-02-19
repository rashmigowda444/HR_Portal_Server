<?php
  include('config.php');
  session_start();
     
  if(isset($_POST['year'])){
    $year=$_POST['year'];
    $month=$_POST['leave_month'];

    $sql="Select * from tekhub_employee_salary ";
    $retval=mysqli_query($conn,$sql);
      if(!$retval)
      {
        die('could not retreive data:'.mysqli_error($conn));
      }

      while($row= mysqli_fetch_array($retval)){
        $id=$row['emp_id'];
        $ctc=$row['ctc'];
        $income=$row['income_tax'];
        $ctc_month=$ctc/12;
        

    $sql1= " Select * from tekhub_employee_allowances";
    $retval1=mysqli_query($conn,$sql1);
      if(!$retval1)
      {
        die('could not retreive data:'.mysqli_error($conn));
      }

      while($row1= mysqli_fetch_array($retval1)){
        $basic_salary=(($row1['basic_salary']*$ctc)/100)/12;
        $conveyance=$row1['conveyance']/12;
        $house=(($row1['house_rent'] * $ctc) / 100)/12;
        $medical=$row1['medical']/12;
        $special=$ctc_month-($basic_salary+$conveyance+$house+$medical);
        $professional=$row1['professional_tax'];
      }
    

    $gross= "";
    $net="";
    $gross=$basic_salary + $conveyance + $house + $medical + $special;
    $net=$gross-$professional-$income;
    
    
    $sql3="Insert into tekhub_employee_payment_details(emp_id,basic_salary,conveyance,house_rent,medical,special,professional_tax,gross_earnings,net_pay,income_tax,pay_month,pay_year) values('$id','$basic_salary','$conveyance','$house','$medical','$special','$professional','$gross','$net','$income','$month','$year')";
       $retval3=mysqli_query($conn,$sql3);
      if(!$retval3)
      {
        die('could not enter data:'.mysqli_error($conn));
      }
      else{
        echo "<script>alert('Payslip generated successfully')</script>";
        echo "<script>window.location.href = 'admin_generate_payslip.php'</script>";
      }
  }

}
?>




