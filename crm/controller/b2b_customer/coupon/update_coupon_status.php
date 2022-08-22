<?php include "../../../model/model.php";
$customer_id = $_POST['user_id'];
$coupon_code = $_POST['coupon_code'];
$used_at = date("Y-m-d H:i");

$sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from b2b_coupons_applied"));
$entry_id = $sq_max['max'] + 1;
$sq_ledger = mysqlQuery("insert into b2b_coupons_applied (entry_id, customer_id, coupon_code, status, used_at) values ('$entry_id', '$customer_id','$coupon_code','used','$used_at')");
?>