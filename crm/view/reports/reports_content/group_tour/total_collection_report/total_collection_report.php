<?php include "../../../../../model/model.php";
$tour_id = $_POST['tour_id'];
$group_id = $_POST['group_id'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
$id = $_POST['id'];
$count=0;
$sq_pending_amount=0;
$sq_cancel_amount=0;
$sq_paid_amount=0;
$Total_payment=0;
$total = 0;
$array_s = array();
$temp_arr = array();
$query1 = "select * from payment_master where 1";

if($tour_id != ''){
	$query1 .= " and tourwise_traveler_id in(select id from tourwise_traveler_details where tour_id='$tour_id') ";
}
if( $group_id != ''){
	$query1 .= " and tourwise_traveler_id in(select traveler_group_id from tourwise_traveler_details where tour_group_id='$group_id') ";
}

if($branch_id!=""){

	$query1 .= " and tourwise_traveler_id in (select id from tourwise_traveler_details where branch_admin_id = '$branch_id')";
}
if($branch_status=='yes' && $role=='Branch Admin'){
    $query1 .= " and branch_admin_id = '$branch_admin_id'";
}
if($id != "")
{
	$query1 .= " and tourwise_traveler_id in(select traveler_group_id from tourwise_traveler_details where id='$id') ";
}
$sq_payment_det = mysqlQuery($query1);
while($row_payment_det = mysqli_fetch_assoc($sq_payment_det))
{
	$bg1 = '';
	$total += $row_payment_det['amount'];
	$sq_tourwise_details = mysqli_fetch_assoc(mysqlQuery("select * from tourwise_traveler_details where id='$row_payment_det[tourwise_traveler_id]'"));
	$date = $sq_tourwise_details['form_date'];
	$yr = explode("-", $date);
	$year = $yr[0];

	$sq_tour_det = mysqli_fetch_assoc(mysqlQuery("select tour_name from tour_master where tour_id='$sq_tourwise_details[tour_id]'"));
	$sq_tour_group_det = mysqli_fetch_assoc(mysqlQuery("select from_date, to_date from tour_groups where group_id='$sq_tourwise_details[tour_group_id]'"));
	$tour_group = date("d-m-Y", strtotime($sq_tour_group_det['from_date']))." to ".date("d-m-Y", strtotime($sq_tour_group_det['to_date']));

	$count++;
	if($row_payment_det['clearance_status']=="Pending"){ $bg='warning';
		$sq_pending_amount = $sq_pending_amount + $row_payment_det['amount'];
	}

	if($row_payment_det['clearance_status']=="Cancelled"){ $bg='danger';
		$sq_cancel_amount = $sq_cancel_amount + $row_payment_det['amount'];
	}

	if($row_payment_det['clearance_status']=="Cleared"){ $bg='success';
		$sq_paid_amount = $sq_paid_amount + $row_payment_det['amount'];
	}

	if($row_payment_det['clearance_status']==""){ $bg='';
		$sq_paid_amount = $sq_paid_amount + $row_payment_det['amount'];
	}
	
	$pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$sq_tourwise_details[id]'"));
	$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$sq_tourwise_details[id]' and status='Cancel'"));

	if($sq_tourwise_details['tour_group_status'] == 'Cancel'){
		//Group Tour cancel
		$cancel_tour_count2=mysqli_num_rows(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$sq_tourwise_details[id]'"));
		if($cancel_tour_count2 >= '1'){
			$cancel_tour=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$sq_tourwise_details[id]'"));
			$cancel_amount2 = $cancel_tour['cancel_amount'];
		}
		else{ $cancel_amount2 = 0; }

		if($cancel_esti_count1 >= '1'){
			$cancel_amount = $cancel_amount1;
		}else{
			$cancel_amount = $cancel_amount2;
		}
	}
	else{
		// Group booking cancel
		$cancel_esti_count1 = mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$sq_tourwise_details[id]'"));
		if($pass_count == $cancelpass_count){
			$cancel_esti1=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$sq_tourwise_details[id]'"));
			$cancel_amount = $cancel_esti1['cancel_amount'];
		}
		else{ $cancel_amount = 0; }
	}

	$cancel_amount = ($cancel_amount == '')?'0':$cancel_amount;
	$paid_amount1 = $row_payment_det['amount'];
	if($sq_tourwise_details['tour_group_status'] == 'Cancel'){

		$bg1 = 'danger';
		if($cancel_amount > $paid_amount1){
			$balance_amount = $cancel_amount - $paid_amount1;
		}
		else{
			$balance_amount = 0;
		}
	}else{
		if($pass_count == $cancelpass_count){
			$bg1 = 'danger';
			if($cancel_amount > $paid_amount1){
				$balance_amount = $cancel_amount - $paid_amount1;
			}
			else{
				$balance_amount = 0;
			}
		}
		else{
			$balance_amount = $sq_tourwise_details['net_total'] - $paid_amount1;
		}
	}

	$temp_arr = array( "data" => array(
		(int)($count),
		$sq_tour_det['tour_name'],
		$tour_group,
		get_group_booking_id($row_payment_det['tourwise_traveler_id'],$year),
		date("d-m-Y", strtotime($row_payment_det['date'])),
		$row_payment_det['payment_mode'],
		$sq_tourwise_details['net_total'],
		($row_payment_det['amount'] == "") ? number_format(0,2) : $row_payment_det['amount'],
		number_format($balance_amount,2)
	),"bg" => $bg1);
	array_push($array_s,$temp_arr);
}
$footer_data = array("footer_data" => array(

	'total_footers' => 4,	
	'foot0' => "Paid Amount : ".  number_format($total, 2),
	'col0' => 3,
	'class0' =>"text-right info",

	'foot1' => "Pending Clearance : ".number_format($sq_pending_amount, 2),
	'col1' => 2,
	'class1' =>"text-right warning",
	'foot2' => "Cancelled : ". number_format($sq_cancel_amount, 2),
	'col2' => 2,
	'class2' =>"text-right danger",
	'foot3' => "Total Paid : ".number_format(($total - $sq_pending_amount - $sq_cancel_amount), 2),
	'col3' => 3,
	'class3' =>"text-right success"
	)
);
array_push($array_s, $footer_data);
echo json_encode($array_s);
?>	