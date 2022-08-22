<?php
include '../../config.php';
$razorpay_payment_id = $_POST['razorpay_payment_id'];
$razorpay_order_id = $_POST['razorpay_order_id'];
$razorpay_signature = $_POST['razorpay_signature'];

$payment_amount = $_SESSION['payment_amount'];
$payment_details = [
    'payment_id' => $razorpay_payment_id,
    'order_id' => $razorpay_order_id,
    'signature'=> $razorpay_signature
];
$_SESSION['payment_details'] = $payment_details;
header("Location: ".BASE_URL ."controller/b2c_settings/b2c/sale_payment_success.php");
?>