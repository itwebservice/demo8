<?php
include '../../model/model.php';
$sq_settings = mysqli_fetch_assoc(mysqlQuery("select book_enquiry_button from b2c_settings"));
$payment_gateway = json_decode($sq_settings['book_enquiry_button']);

if($payment_gateway[0]->p_gateway == 'RazorPay'){
    // $api_key = 'rzp_test_FpvQHBZSZbbNA3';
    // $api_secret = 'Y8hKyjznOxlTp9BbIPqoSMC0';
    $api_key = $payment_gateway[0]->cred_array[0]->api_key;
    $api_secret = $payment_gateway[0]->cred_array[0]->api_secret;
}
elseif($payment_gateway[0]->name == 'CCAvenue'){
    $merchant_id = $payment_gateway[0]->cred_array[0]->merchant_id;
    $access_code = $payment_gateway[0]->cred_array[0]->access_code;
    $enc_key = $payment_gateway[0]->cred_array[0]->enc_key;
}
?>