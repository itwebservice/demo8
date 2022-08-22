<?php include "../../model/model.php"; ?>
<?php

$city_id = $_GET['city_id']; ?>
 <option value="">*Sector </option>
 <?php 
$sq = mysqlQuery("select * from airport_master where city_id='$city_id' and flag='Active'");
while($row = mysqli_fetch_assoc($sq))
{
?>
<option value="<?php echo $row['airport_name'].'('.$row['airport_code'].')'  ?>"><?php echo $row['airport_name'].'('.$row['airport_code'].')' ?></option>
<?php	
}
 ?>