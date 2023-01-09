<?php
include '../crm/model/model.php';

$register_id = $_SESSION['register_id'];
$sq_reg = mysqli_fetch_assoc(mysqlQuery("select state from b2b_registration where register_id ='$register_id'"));
$sq = mysqli_fetch_assoc(mysqlQuery("select id from state_master where id ='$sq_reg[state]'"));

$sq_state = mysqli_fetch_assoc(mysqlQuery("select * from app_settings where setting_id ='1'"));
$state_id = $sq_state['state_id'];

echo $sq['id'].'-'.$state_id;
?>