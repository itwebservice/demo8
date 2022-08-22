<?php
include "../../../../../model/model.php"; 
$tour_id = $_POST['tour_id'];
$group_id = $_POST['group_id'];
$id = $_POST['id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$branch_id= $_GET['branch_id_filter'];

$array_s = array();
$temp_arr = array();
$count=0;
$bg;
$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;

$query="select * from refund_traveler_cancelation where 1";
if($id!='')
{
	$query .=" and tourwise_traveler_id='$id'";
}
if($tour_id != ''){
	$query .= " and tourwise_traveler_id in(select id from tourwise_traveler_details where tour_id='$tour_id') ";
}
if( $group_id != ''){
	$query .= " and tourwise_traveler_id in(select traveler_group_id from tourwise_traveler_details where tour_group_id='$group_id') ";
}
if($branch_id!=""){

	$query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where branch_admin_id = '$branch_id')";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where branch_admin_id = '$branch_admin_id')";
}

$sq1_q = mysqlQuery($query);
while($row1 = mysqli_fetch_assoc($sq1_q))
{
	$row_span_count = mysqli_num_rows(mysqlQuery(" select * from refund_traveler_cancalation_entries where refund_id='$row1[refund_id]' "));
	$first_time=true;
	$row2 = mysqli_fetch_assoc(mysqlQuery(" select * from refund_traveler_cancalation_entries where refund_id='$row1[refund_id]' "));
		$count++;

		$sq_traveler_name= mysqli_fetch_assoc(mysqlQuery("select first_name, last_name from travelers_details where traveler_id='$row2[traveler_id]' "));
		$traveler_name = $sq_traveler_name['first_name']." ".$sq_traveler_name['last_name'];
		
		$refunded = $refunded + $row1['total_refund'];
		if($row1['clearance_status']=="Pending"){ $bg='warning';
			$sq_pending_amount = $sq_pending_amount + $row1['total_refund'];
		}

		if($row1['clearance_status']=="Cancelled"){ $bg='danger';
			$sq_cancel_amount = $sq_cancel_amount + $row1['total_refund'];
		}

		if($row1['clearance_status']=="Cleared"){ $bg='success';
			$sq_paid_amount = $sq_paid_amount + $row1['total_refund'];
		}

		if($row1['clearance_status']==""){ $bg='';
			$sq_paid_amount = $sq_paid_amount + $row1['total_refund'];
		}

		$sq_tourwise_details = mysqli_fetch_assoc(mysqlQuery("select form_date from tourwise_traveler_details where id='$row1[tourwise_traveler_id]'"));
		$date = $sq_tourwise_details['form_date'];
		$yr = explode("-", $date);
		$year = $yr[0];
		$temp_arr = array( "data" => array(
			(int)($count),
			get_date_user($row1['refund_date']),
			get_group_booking_id($row1['tourwise_traveler_id'],$year),
			$traveler_name,
			$row1['transaction_id'],
			$row1['bank_name'],
			$row1['refund_mode'],
			$row1['total_refund']
			), "bg" =>$bg);
			array_push($array_s,$temp_arr);
		}
		$footer_data = array("footer_data" => array(
			'total_footers' => 4,
			
			'foot0' => "Refund Amount : ".    number_format((($refunded=='')?0:$refunded), 2),
			'col0' => 3,
			'class0' =>"text-right success",
		
			'foot1' => "Pending Clearance : ".number_format((($sq_pending_amount=='')?0:$sq_pending_amount), 2),
			'col1' => 2,
			'class1' =>"text-right warning",
			'foot2' => "Cancelled : ".number_format((($sq_cancel_amount=='')?0:$sq_cancel_amount), 2),
			'col2' => 1,
			'class2' =>"text-right danger",
			'foot3' => "Total Refund : ".number_format(($refunded - $sq_pending_amount - $sq_cancel_amount), 2),
			'col3' => 2,
			'class3' =>"text-right success"
			)
		);
		array_push($array_s, $footer_data);
		echo json_encode($array_s);
	?>