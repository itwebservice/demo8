<?php
include "../../../model/model.php";
$city_id = $_POST['city_id'];
?>
<option value="">*Select Activity</option>
<?php if($city_id != 0){
$sq_exc = mysqlQuery("select entry_id,excursion_name from excursion_master_tariff where city_id = '$city_id' and active_flag!='Inactive'");
    while($row_exc = mysqli_fetch_assoc($sq_exc)){ ?>
      <option value="<?php echo $row_exc['entry_id']; ?>"><?php echo  $row_exc['excursion_name']; ?></option>
  <?php } 
} ?>
