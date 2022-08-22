<?php 
include_once('../../model/model.php');
include_once('../../model/id_proof/visa_ticket_id_proof.php');

$air_ticket_id_proof = new visa_ticket_id_proof();
$air_ticket_id_proof->visa_ticket_pan_card_upload();
?>