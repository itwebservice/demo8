<?php include "../../../../../model/model.php"; 

$array_s = array();
$temp_arr = array();
$tour_id= $_POST['tour_id'];
$group_id= $_POST['group_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$count=0;

$query = "select * from tourwise_traveler_details where 1";

if($tour_id!="")
{
	$query .= " and tour_id = '$tour_id'";
}
if($group_id!="")
{
	$query .= " and tour_group_id = '$group_id'";
}
if($branch_id!=""){

	$query .= " and branch_admin_id = '$branch_id'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query .= " and  branch_admin_id = '$branch_admin_id'";
}
 
$sq_tourwise_det = mysqlQuery($query);
while($row_tourwise_det = mysqli_fetch_assoc($sq_tourwise_det))
{
	$pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_tourwise_det[id]'"));
	$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$row_tourwise_det[id]' and status='Cancel'"));
	$bg="";
	if($row_tourwise_det['tour_group_status']=="Cancel"){
		$bg="danger";
	}
	else{
		if($pass_count==$cancelpass_count){
			$bg="danger";
		}
	}

	$count++;
	$date = $row_tourwise_det['form_date'];
	$yr = explode("-", $date);
	$year =$yr[0];

	$sq_total_member_count = mysqli_num_rows(mysqlQuery("select traveler_id from travelers_details where traveler_group_id='$row_tourwise_det[traveler_group_id]' and status!='Cancel'"));

	$tour_name1 = mysqli_fetch_assoc(mysqlQuery("select tour_name from tour_master where tour_id= '$row_tourwise_det[tour_id]'"));
	$tour_name = $tour_name1['tour_name'];
	$tour_group1 = mysqli_fetch_assoc(mysqlQuery("select from_date, to_date from tour_groups where group_id= '$row_tourwise_det[tour_group_id]'"));
	$tour_group = date("d-m-Y", strtotime($tour_group1['from_date']))." to ".date("d-m-Y", strtotime($tour_group1['to_date']));

	$sq_adjust_with = mysqli_fetch_assoc(mysqlQuery("select first_name, last_name from travelers_details where traveler_id='$row_tourwise_det[s_adjust_with]'"));
	$adjust_with = $sq_adjust_with['first_name']." ".$sq_adjust_with['last_name'];
	$temp_arr = array( "data" => array(
		(int)($count),
		$tour_name,
		$tour_group,
		get_group_booking_id($row_tourwise_det['id'],$year),
		$sq_total_member_count,
		$row_tourwise_det['s_single_bed_room'],
		$row_tourwise_det['s_double_bed_room'],
		$row_tourwise_det['s_extra_bed'],
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
	}
	echo json_encode($array_s);
?>