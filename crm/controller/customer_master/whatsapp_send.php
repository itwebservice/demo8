<?php 
include_once('../../model/model.php');
include_once('../../model/customer_master.php');

$customer_whatsapp = new customer_master;
$customer_whatsapp->whatsapp_send();
?>