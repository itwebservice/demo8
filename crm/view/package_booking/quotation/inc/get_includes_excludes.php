<?php
include "../../../../model/model.php";

$tour_type = $_POST['tour_type'];

$includes = '';
$sq_inc = mysqlQuery("select * from inclusions_exclusions_master where active_flag='Active' and type='Inclusion' and tour_type in ('$tour_type', 'Both')");
while($row_inc = mysqli_fetch_assoc($sq_inc)){
	$includes .= '> '.$row_inc['inclusion']."\n";
}


$excludes = '';
$sq_exc = mysqlQuery("select * from inclusions_exclusions_master where active_flag='Active' and type='Exclusion' and tour_type in ('$tour_type', 'Both')");
while($row_exc = mysqli_fetch_assoc($sq_exc)){
	$count++;
	$excludes .= '> '.$row_exc['inclusion']."\n";
}

$arr = array(
			'includes' => $includes,
			'excludes' => $excludes
	   );
echo json_encode($arr);
?>