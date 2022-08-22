<?php 
include "../../../model/model.php"; 

$tour_id = $_POST['tour_id'];

$sq_tour = mysqli_fetch_assoc(mysqlQuery("select tour_type from tour_master where tour_id='$tour_id'"));
echo $sq_tour['tour_type'];
?>