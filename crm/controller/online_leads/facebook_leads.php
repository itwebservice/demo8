<?php 
include "../../model/model.php"; 
include_once('../../model/online_leads/facebook_leads.php');

$facebook_leads = new facebook_leads(); 
$facebook_leads->webhook();
?>