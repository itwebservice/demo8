<?php 
include_once('../../../model/model.php');
include_once('../../../model/visa_password_ticket/ticket/ticket_master/ticket_save.php');

$ticket_save = new ticket_save;
$ticket_save->pnr_check();
?>