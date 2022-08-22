<?php 
include "../../model/model.php"; 
include "../../model/custom_packages/tariff.php"; 

$package_clone = new package_master_tariff;
$package_clone->tariff_csv_save();
?>