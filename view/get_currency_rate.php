<?php
include '../crm/model/model.php';
global $currency;
$currency1 = $_POST['currency'];
$currency_id = $_POST['currency_id'];
$currency1 = ($currency1 == '0') ? $currency : $currency1;
$sq_currency= mysqli_fetch_assoc(mysqlQuery("select default_currency from currency_name_master where id='$currency_id'"));

$sq_from = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency1'"));
$sq_to = mysqli_fetch_assoc(mysqlQuery("select * from roe_master where currency_id='$currency_id'"));

echo $sq_to['currency_rate'].','.$sq_from['currency_rate'].','.$sq_currency['default_currency'];
?>