<?php
include '../crm/model/model.php';
$register_id = $_POST['register_id'];
$sq_reg = mysqli_fetch_assoc(mysqlQuery("select cart_data from b2b_registration where register_id='$register_id'"));
echo ($sq_reg['cart_data']);
?>