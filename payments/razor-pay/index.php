<?php
include '../../config.php';
include '../constants.php';
global $encrypt_decrypt, $secret_key, $currency, $currency_code, $app_name, $admin_logo_url;

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$name = $_SESSION['name'];
$email_id = $_SESSION['email_id'];
$country_code = $_SESSION['country_code'];
$phone = $_SESSION['phone'];
$costing_arr = $_SESSION['costing_arr'];
$payment_amount = ($costing_arr[0]['payment_amount']);
$payment_amount = floatval(str_replace(".", "", $payment_amount));

//2.Create An order
$api = new Api($api_key, $api_secret);
$order = $api->order->create(array(
    'receipt' => uniqid(),
    'amount' => $payment_amount,
    'payment_capture' => 1,
    'currency' => $currency_code
));

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
        data-currency="<?php echo $currency_code; ?>"
        data-order_id="<?php echo $order['id']; ?>"
        data-buttontext="Pay with Razorpay!"
        data-name="<?php echo $app_name; ?>"
        data-description="Secure Payment..."
        data-image="<?php echo $admin_logo_url; ?>"
        data-prefill.name="<?php echo $name; ?>"
        data-prefill.email="<?php echo $email_id; ?>"
        data-prefill.contact="<?php echo $country_code.$phone; ?>"
    ></script>
    <input type="hidden" custom="Hidden Element" name="hidden">
    </form>
</body>
</html>