<?php
include '../../model/model.php';
$country_id = $_POST['country_id'];

$sq_currency= mysqli_fetch_assoc(mysqlQuery("select * from country_list_master where country_id='$country_id'"));

echo $sq_currency['phone_code'];
?>