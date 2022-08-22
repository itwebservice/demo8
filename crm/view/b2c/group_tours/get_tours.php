<?php
include "../../../model/model.php";
$dest_id = $_POST['dest_id'];
?>
<option value="">*Select Tour</option>
<?php if($dest_id != 0){
$sq_tours = mysqlQuery("select * from tour_master where dest_id = '$dest_id' and active_flag!='Inactive'");
    while($row_tours = mysqli_fetch_assoc($sq_tours)){ ?>
      <option value="<?php echo $row_tours['tour_id']; ?>"><?php echo  $row_tours['tour_name']; ?></option>
  <?php } 
} ?>
