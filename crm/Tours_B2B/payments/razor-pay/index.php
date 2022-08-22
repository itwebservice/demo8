<?php
include '../../../model/model.php';
include '../constants.php';
global $encrypt_decrypt, $secret_key;

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$customer_id = $_SESSION['customer_id'];
$payment_amount = $_SESSION['payment_amount'];
// echo 'p'.$customer_id;
$global_currency = $_SESSION['global_currency'];
//Default selected currency
$sq_currency = mysqli_fetch_assoc(mysqlQuery("SELECT currency_code FROM `currency_name_master` WHERE `id` = '$global_currency'"));
$payment_amount = str_replace(".", "", $payment_amount);
$curr_code = $sq_currency['currency_code'];
//2.Create An order
$api = new Api($api_key, $api_secret);
$order = $api->order->create(array(
    'receipt' => uniqid(),
    'amount' => $payment_amount,
    'payment_capture' => 1,
    'currency' => $curr_code
));

//Customers mobile no and email id
$sq_customer = mysqli_fetch_assoc(mysqlQuery("SELECT email_id,contact_no,company_name FROM `customer_master` WHERE `customer_id` = '$customer_id'"));
$email_id = $encrypt_decrypt->fnDecrypt($sq_customer['email_id'], $secret_key);
$contact_no = $encrypt_decrypt->fnDecrypt($sq_customer['contact_no'], $secret_key);
?>
<html>
<head>
    <title>Payment Gateway Integration</title>
</head>
<body>
    <form action="success.php" method="POST">
    <script
        src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="<?php echo $api_key; ?>" 
        data-amount="<?php echo $payment_amount; ?>" 
        data-currency="<?php echo $curr_code; ?>"
        data-order_id="<?php echo $order['id']; ?>"
        data-buttontext="Pay with Razorpay!"
        data-name="<?php echo $app_name; ?>"
        data-description="Secure Payment..."
        data-image="<?php echo $admin_logo_url; ?>"
        data-prefill.name="<?php echo $sq_customer['company_name']; ?>"
        data-prefill.email="<?php echo $email_id; ?>"
        data-prefill.contact="<?php echo '+91'.$contact_no; ?>"
    ></script>
    <input type="hidden" custom="Hidden Element" name="hidden">
    </form>
</body>
</html>