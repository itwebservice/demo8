<?php
include_once('../../../model/model.php');
include_once('../../../model/promotional_email/email_send.php');

$sms_message = new sms_message;
$sms_message->sms_message_send();

?>