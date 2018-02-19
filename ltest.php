<?php
  include('config.php');
  session_start();
?>
<?php
$q = intval($_GET['days']);
echo $q;
$_SESSION['no_days']=$q;
$id = $_SESSION['empid'];
echo'<div style="visibility:hidden;">
$q</div>';
if($q==1){
echo'
<div class="row"   id="rowduration" style="margin-left:-182px;margin-top:25px;">
  <div class="col-md-2">
  <label>Duration </label>
  </div>
  <div class="col-md-10">
  <select name="duration" id="field" onchange="report(this.value)" class="form-control" required>
    <option value="1">-----Select----</option>
    <option value="0.5">Half Day</option>
    <option value="1">Full Day</option>
    <option value="0.1">One Hour</option>
    <option value="0.2">Two Hour</option>
  </select>
  </div>
  </div><br>';
}
else{}
 mysqli_close($conn);
 ?>
