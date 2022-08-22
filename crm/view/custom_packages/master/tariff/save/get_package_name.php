<?php
include "../../../../../model/model.php";
$dest_id = $_POST['dest_id'];
$sq_tours = mysqlQuery("select * from custom_package_master where dest_id = '$dest_id' and status!='Inactive'");
?>
<option value=""><?php echo "*Select Package";  ?></option>
<?php
while($row_tours = mysqli_fetch_assoc($sq_tours)){
    ?>
    <option value="<?= $row_tours['package_id'] ?>"><?php echo $row_tours['package_name'] ." (". $row_tours['total_days']."D/".$row_tours['total_nights']."N )" ?></option>';
<?php
}
?>