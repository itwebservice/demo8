<?php 
include "../../model/model.php"; 
include "../../model/business_rules/tcs.php";

$tcs_master = new tcs(); 
$tcs_master->save();
?>