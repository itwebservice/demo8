<?php
include '../../model/model.php';
$sq_settings = mysqli_fetch_assoc(mysqlQuery("select payment_gateway,credentials from b2b_settings_second"));
$payment_gateway = json_decode($sq_settings['payment_gateway']);
$credentials = json_decode($sq_settings['credentials']);
if($payment_gateway[0]->name == 'RazorPay'){
    // $api_key = 'rzp_test_FpvQHBZSZbbNA3';
    // $api_secret = 'Y8hKyjznOxlTp9BbIPqoSMC0';
    $api_key = $credentials[0]->api_key;
    $api_secret = $credentials[0]->api_secret;
}
elseif($payment_gateway[0]->name == 'CCAvenue'){
    $merchant_id = $credentials[0]->merchant_id;
    $access_code = $credentials[0]->access_code;
    $enc_key = $credentials[0]->enc_key;
}
?>