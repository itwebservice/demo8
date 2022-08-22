<?php
include "../../../model/model.php"; 
include "../../../model/package_tour/quotation/quotation_email_send.php"; 

$email_option = $_POST['email_option'];

$quotation_email_send = new quotation_email_send;
if($email_option=='By HTML'){
    $quotation_email_send->quotation_email();	
}else{
    $quotation_email_send->quotation_email_body();
}

?>