<?php 
include_once('../../../model/model.php');

$group_id = $_POST['group_id'];
$train_info_arr = array();

$sq_group = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where group_id='$group_id'"));

$query = "select * from group_train_entries where tour_id='$sq_group[tour_id]'";
$sq_train = mysqlQuery($query);

	while($row_train = mysqli_fetch_assoc($sq_train)){
		$departure_date = date('d-m-Y H:i', strtotime($sq_group['from_date']));
		$arr = array(
			'from_location' => $row_train['from_location'],
			'to_location' => $row_train['to_location'],
			'class' => $row_train['class'],
			'dapart_time'=>$departure_date
		);
		array_push($train_info_arr, $arr);
	}


echo json_encode($train_info_arr);
?>