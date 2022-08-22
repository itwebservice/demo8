<?php include "../../../../../model/model.php"; 
$count=1;
$traveler_id = $_POST['traveler_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$array_s = array();
$temp_arr = array();


$query = "select * from customer_master where 1";
if($traveler_id!=""){
	$query .=" and customer_id ='$traveler_id' and active_flag='Active'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
	$query .=" and branch_admin_id = '$branch_admin_id'";
}
$group_count = 0;
$package_count = 0;
// echo $query;
$sq = mysqlQuery($query);
while($row = mysqli_fetch_assoc($sq))
{
	$traveler_id_arr = array();
	$group_collection = array();
	$package_collection = array();

	if($row['type']=='Corporate'||$row['type']=='B2B'){
		$first_name = $row['company_name'];
	}else{
		$first_name = $row['first_name']." ".$row['last_name'];
	}
	//Group
	$group_count = 0;
	$group_tours = mysqlQuery("select * from tourwise_traveler_details where tour_group_status!='Cancel' and customer_id = '$row[customer_id]'");
	while($row1 = mysqli_fetch_assoc($group_tours)){
		
		$pass_count = (int)mysqli_num_rows(mysqlQuery("select * from travelers_details where status!='Cancel' and traveler_group_id = ".$row1['id']));
		$cancel_pass_count = (int)mysqli_num_rows(mysqlQuery("select * from travelers_details where status='Cancel' and traveler_group_id = ".$row1['id']));
		if($pass_count != $cancel_pass_count){
			$group_count++;
			array_push($group_collection,$row1['traveler_group_id']);
		}
	}
	$group_collection = implode(',',$group_collection);
	$traveler_id_arr['group'] = $group_collection;
	
	$temp_arr = array( "data" => array(
		(int)($count++),
		$first_name,
		($row['birth_date'] != '1970-01-01'&&$row['birth_date'] != '') ? get_date_user($row['birth_date']) : 'NA',
		$row['gender'],
		$group_count,
		'<button id="btn_group_id'.$count.'" value=\''. json_encode($traveler_id_arr).'\' class="btn btn-info btn-sm" onclick="travelers_details(this.id)" title="View Details"><i class="fa fa-eye"></i></button>'
		), "bg" =>$bg);
		array_push($array_s,$temp_arr);
}
echo json_encode($array_s);
?>