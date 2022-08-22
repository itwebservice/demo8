<?php
include "../../../../model/model.php";
include_once('../../../../model/b2c_settings/cancel/b2c_sale_cancel.php');

$b2c_sale_cancel = new b2c_sale_cancel(); 
$b2c_sale_cancel->cancel();
?>