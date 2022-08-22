<?php
include_once('../../../model/model.php');
include_once('../../../model/b2c_settings/enquiry_form.php');

$enq_master = new enquiry_master;
$enq_master->actions_enq();
?>