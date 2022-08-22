<?php
include_once('../../model/model.php');
include_once('../../model/rent_bike/master.php');

$transfer_tariff = new master;
$transfer_tariff->tariff_csv_save();
?>