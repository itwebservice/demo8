<?php
include_once('../../model/model.php');
include_once('../../model/rent_bike/master.php');

$master = new master;
$master->master_save();
?>