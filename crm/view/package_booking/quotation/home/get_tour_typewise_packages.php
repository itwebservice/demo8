<?php
include '../../../../model/model.php';
$tour_type = $_POST['tour_type'];
$query = "SELECT package_id,package_name FROM `custom_package_master` WHERE 1 ";
if($tour_type != ''){
    $query .= " and tour_type ='$tour_type' ";
}
$sq_query = mysqlQuery($query);
?>
<option value="">Select Package Name</option>
<?php
while($row_query = mysqli_fetch_assoc($sq_query)){
?>
    <option value="<?= $row_query['package_id'] ?>"><?= $row_query['package_name'] ?></option>
<?php
}
?>