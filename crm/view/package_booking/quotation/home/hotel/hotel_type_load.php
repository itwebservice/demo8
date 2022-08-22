<?php include "../../../../../model/model.php"; ?>
<?php 
$hotel_id = $_GET['hotel_id'];

$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id = '$hotel_id' "));
echo $sq_hotel['rating_star'];
?>