<?php 
include "../../../model/model.php";
include "../../../model/hotel/quotation_master.php";

$quotation_master = new quotation_master();
$quotation_master->quotation_update();
?>