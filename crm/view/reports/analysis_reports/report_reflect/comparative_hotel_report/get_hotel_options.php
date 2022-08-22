<?php
include "../../../../../model/model.php";
$cityid = $_POST['cityid'];
$query = "SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id where hotel_master.city_id='".$cityid."'";
$option = '';
$res = mysqlQuery($query);
while($db = mysqli_fetch_assoc($res))
{
     echo '<option value="'.$db['hotel_id'].'">'.$db['hotel_name'].'</option>';
}

// echo json_encode($option);
?>

 
