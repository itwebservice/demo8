<?php 
include "../../model/model.php"; 

$taxation_id = $_POST['taxation_id'];
if($taxation_id==0){
	echo "0";
	exit;
}

$sq_taxation = mysqli_fetch_assoc(mysqlQuery("select * from taxation_master where taxation_id='$taxation_id'"));

echo $sq_taxation['tax_in_percentage'];
exit;
?>