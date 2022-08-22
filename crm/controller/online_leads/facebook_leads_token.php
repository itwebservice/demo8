<?php 
include "../../model/model.php"; 
include_once('../../model/online_leads/facebook_leads_token.php');

$facebook_leads_token = new facebook_leads_token(); 
$facebook_leads_token->save_token();
?>