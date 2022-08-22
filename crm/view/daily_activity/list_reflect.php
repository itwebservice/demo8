<?php 
include "../../model/model.php";
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$branch_status = $_POST['branch_status'];
$emp_id = $_SESSION['emp_id'];
$role_id = $_SESSION['role_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];

$query = "select * from daily_activity where 1 ";
if($from_date!="" && $to_date !=''){
  $from_date = date('Y-m-d',strtotime($from_date));
  $to_date = date('Y-m-d',strtotime($to_date));
  $query .=" and activity_date between '$from_date' and '$to_date'  ";
}
include "../../model/app_settings/branchwise_filteration.php";
?>
<table class="table table-hover mg_bt_10" id="acitvity_table" cellspacing="0" style="margin: 20px 0 !important;">
  <thead>
    <tr class="active table-heading-row">
      <th>S_No.</th>
      <th>User_Name</th>
      <th>Activity_Date</th>
      <th>Activity_type</th>
      <th>Time_taken</th>
      <th>Description</th>
    </tr>  
  </thead>  
  <tbody>
    <?php
    $count=0;
    $sq = mysqlQuery($query);
    while($row=mysqli_fetch_assoc($sq))
    {
      $sq_emp  = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$row[emp_id]'"));
      $count++;
      ?>
      <tr>
        <td><?php echo $count ?></td>
        <td><?= ($row['emp_id'] == '0') ? 'Admin' : $sq_emp['first_name'].' '.$sq_emp['last_name']?></td>
        <td><?php echo date('d-m-Y',strtotime($row['activity_date'])); ?></td>
        <td><?php echo $row['activity_type']; ?></td>
        <td><?php echo $row['time_taken']; ?></td>
        <td><?php echo $row['description']; ?></td>
      </tr> 
      <?php 
    }  
    ?>
  </tbody>  
</table>
<script type="text/javascript">
$('#acitvity_table').dataTable({
  "pagingType": "full_numbers"
});
</script>