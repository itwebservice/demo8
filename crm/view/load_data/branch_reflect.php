<?php
include "../../model/model.php";
$emp_id = $_POST['emp_id'];

$sq_user = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$emp_id'"));
$query = "select * from branches where 1";
if($emp_id != ''){
  $query .= " and branch_id = '$sq_user[branch_id]'";
}
$query .= " order by branch_name";
$sq_branch = mysqlQuery($query);
?>
<option value=''>Branch</option>
<?php
while($row_branch = mysqli_fetch_assoc($sq_branch)){

  ?>
  <option value="<?=  $row_branch['branch_id'] ?>"><?= $row_branch['branch_name'] ?></option>
  <?php
} 
?>