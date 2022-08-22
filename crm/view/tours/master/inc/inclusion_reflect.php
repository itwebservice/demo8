<?php
include "../../../../model/model.php";

$tour_type = $_POST['tour_type'];
$type = $_POST['type'];

$includes = '';
if($type == 'package'){
	$sq_inc = mysqlQuery("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('Package','Both') and type='Inclusion' and tour_type in ('$tour_type', 'Both')");
}
else{
	$sq_inc = mysqlQuery("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('Group','Both') and type='Inclusion' and tour_type in ('$tour_type', 'Both')");
}
while($row_inc = mysqli_fetch_assoc($sq_inc)){
	$includes .= $row_inc['inclusion']."<br>";
}


$excludes = '';
if($type == 'package'){
	$sq_exc = mysqlQuery("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('Package','Both') and type='Exclusion' and tour_type in ('$tour_type', 'Both')");
}
else{
	$sq_exc = mysqlQuery("select * from inclusions_exclusions_master where active_flag='Active' and for_value in('Group','Both') and type='Exclusion' and tour_type in ('$tour_type', 'Both')");
}
while($row_exc = mysqli_fetch_assoc($sq_exc)){
	$count++;
	$excludes .= $row_exc['inclusion']."<br>";
}

$arr = array('includes' => $includes,
			'excludes' => $excludes);
echo json_encode($arr);
?>