<?php 
include_once('../../../model/model.php');

$group_id = $_POST['group_id'];
$cruise_info_arr = array();

$sq_group = mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where group_id='$group_id'"));

$query = "select * from group_cruise_entries where tour_id='$sq_group[tour_id]'";
$sq_cruise = mysqlQuery($query);

	while($row_cruise = mysqli_fetch_assoc($sq_cruise)){

		$departure_date = date('d-m-Y H:i', strtotime($sq_group['from_date']));

		$arr = array(
			'dept_datetime' => $departure_date,
			'arrival_datetime' => $arrival_datetime,
			'route' => $row_cruise['route'],
			'cabin' => $row_cruise['cabin'],
			'dapart_time'=>$departure_date
		);
		array_push($cruise_info_arr, $arr);
	}


echo json_encode($cruise_info_arr);
?>