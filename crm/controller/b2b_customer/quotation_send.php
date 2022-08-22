<?php
include "../../model/model.php"; 
include "../../model/b2b_customer/b2b_customer.php"; 

$b2b_customer1 = new b2b_customer;
$b2b_customer1->quotation_send();
?>