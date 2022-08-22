<?php
include'../../../../model/model.php';
$taxation_id=$_POST['taxation_id'];

$sq_taxation = mysqli_fetch_assoc(mysqlQuery("select * from taxation_master where taxation_id='$taxation_id'"));
?>
<input type="hidden" name="tax_amount1" id="tax_amount1" value="<?= ($sq_taxation['tax_in_percentage']=='')? 0:$sq_taxation['tax_in_percentage']?>">