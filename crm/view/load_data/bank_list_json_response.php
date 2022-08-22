<?php
include_once('../../model/model.php');

$bank_arr = array();
$sq_banks = mysqlQuery("select * from bank_list_master");
while($row_banks = mysqli_fetch_assoc($sq_banks)){
	array_push($bank_arr, $row_banks['bank_name']);
}

echo json_encode($bank_arr);
?>