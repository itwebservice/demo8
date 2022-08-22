<?php
include "../../model/model.php"; 
include "../../model/attractions_offers_enquiry/fourth_coming_attraction_master.php"; 

$image_id = $_POST['image_id'];

$fourth_coming_attraction_master = new fourth_coming_attraction_master();
$fourth_coming_attraction_master->img_delete($image_id);

?>