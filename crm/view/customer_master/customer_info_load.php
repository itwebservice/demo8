<?php
include "../../../../model/model.php";

$customer_id = $_POST['customer_id'];
$sq_cust_info = mysqli_fetch_assoc(mysqlQuery("select contact_no, email_id, company_name from customer_master where customer_id='$customer_id'"));

echo json_encode($sq_cust_info);
?>