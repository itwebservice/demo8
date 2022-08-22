<?php
include "../../../../../model/model.php";
$customer_id = $_GET['customer_id'];
$booking_type = $_GET['booking_type'];
$booking_id = $_GET['booking_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$array_s = array();
$temp_arr = array();
$query = "select * from customer_feedback_master where 1 ";
if($booking_type!=""){
	$query .=" and booking_type='$booking_type'";
}
if($booking_id!=''){
	$query .=" and booking_id='$booking_id'";
}
if($customer_id!=""){
    $query.=" and customer_id='$customer_id'";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query .= " and customer_id in(select customer_id from customer_master where branch_admin_id = '$branch_admin_id')";
}   

$count = 0; 
$sq = mysqlQuery($query);
while($row = mysqli_fetch_assoc($sq)){

    $sq_query_cust = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id ='$row[customer_id]'"));
    if($row['booking_type']=="Group Booking"){ 
        $sq_booking =mysqli_fetch_assoc(mysqlQuery("select * from tourwise_traveler_details where id='$row[booking_id]'"));  
        $sq_tour_group_name = mysqlQuery("select from_date,to_date from tour_groups where group_id='$sq_booking[tour_group_id]'");
        $row_tour_group_name = mysqli_fetch_assoc($sq_tour_group_name);
        $tour_date = date("d-m-Y", strtotime($row_tour_group_name['from_date'])).' To '.date("d-m-Y", strtotime($row_tour_group_name['to_date']));
        $date = $sq_booking['form_date'];
        $yr = explode("-", $date);
        $year = $yr[0];
        $booking_id = get_group_booking_id($row['booking_id'],$year);
    }
    else{
        $sq_booking =mysqli_fetch_assoc(mysqlQuery("select * from package_tour_booking_master where booking_id='$row[booking_id]'")); 
        $tour_date = date("d-m-Y", strtotime($sq_booking['tour_from_date'])).' To '.date("d-m-Y", strtotime($sq_booking['tour_to_date']));
        $date = $sq_booking['booking_date'];
        $yr = explode("-", $date);
        $year = $yr[0];        
        $booking_id = get_package_booking_id($row['booking_id'],$year);
    }
	$cust_name = ($sq_query_cust['type'] == 'Corporate' || $sq_query_cust['type'] == 'B2B') ? $sq_query_cust['company_name'] : $sq_query_cust['first_name'].' '.$sq_query_cust['last_name'];
    
    $temp_arr = array( "data" => array(
        (int)(++$count),
        $cust_name,
        $booking_id,
        $row['booking_type'],
        $tour_date,
        '<button class="btn btn-info btn-sm" onclick="view_modal('. $row['feedback_id'] .')" title="View Information"><i class="fa fa-eye"></i></button>'
        ), "bg" =>$bg);
    array_push($array_s,$temp_arr);
}
echo json_encode($array_s);
?>