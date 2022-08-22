<?php
include "../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$from_date = $_POST['payment_from_date'];
$to_date = $_POST['payment_to_date'];
?>
<div class="row mg_tp_20"> <div class="col-xs-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_refund_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Customer_Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
			<th>Refund_ID</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="text-right">Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = $pending_refund = $canceled_refund = 0;
		$query = "select * from car_rental_refund_master where 1 ";
		if($booking_id!=""){
			$query .=" and booking_id='$booking_id'";
		}
		if($from_date!='' && $to_date!=''){
			$from_date = get_date_db($from_date);
			$to_date = get_date_db($to_date);
			$query .=" and refund_date between '$from_date' and '$to_date'";
		}
		$count = 0;
		$sq_car_rental_refund = mysqlQuery($query);
		$sq_cancel_pay=mysqli_fetch_assoc(mysqlQuery("select sum(refund_amount) as sum from car_rental_refund_master where clearance_status='Cleared'"));
		$sq_pend_pay=mysqli_fetch_assoc(mysqlQuery("select sum(refund_amount) as sum from car_rental_refund_master where clearance_status='Pending'"));
		while($row_car_rental_refund = mysqli_fetch_assoc($sq_car_rental_refund)){

			$count++;
			$total_refund = $total_refund+$row_car_rental_refund['refund_amount'];

			$sq_car_rental_info = mysqli_fetch_assoc(mysqlQuery("select * from car_rental_booking where booking_id='$row_car_rental_refund[booking_id]'"));
			$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_car_rental_info[customer_id]'"));
			if($sq_customer['type'] == 'Corporate'||$sq_customer['type']=='B2B'){
				$cust_name = $sq_customer['company_name'];
			}else{
				$cust_name = $sq_customer['first_name'].' '.$sq_customer['last_name'];
			}
			$date = $sq_car_rental_info['created_at'];
			$yr = explode("-", $date);
			$year1 =$yr[0];

			if($row_car_rental_refund['clearance_status']=="Pending"){ 
				$bg = "warning"; 
				$pending_refund = $pending_refund + $row_car_rental_refund['refund_amount'];
			}
			else if($row_car_rental_refund['clearance_status']=="Cancelled"){ 
				$bg = "danger"; 
				$canceled_refund = $canceled_refund + $row_car_rental_refund['refund_amount'];
			}
			else if($row_car_rental_refund['clearance_status']=="Cleared"){ 
				$bg = "success"; 
			}
			else{ $bg = ""; }
			
			$date = $row_car_rental_refund['refund_date'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$v_voucher_no = get_car_rental_booking_refund_id($row_car_rental_refund['refund_id'],$year);
			$v_refund_date = $row_car_rental_refund['refund_date'];
			$v_refund_to = $cust_name;
			$v_service_name = "Car Rental Booking";
			$v_refund_amount = $row_car_rental_refund['refund_amount'];
			$v_payment_mode = $row_car_rental_refund['refund_mode'];
			$customer_id = $sq_car_rental_info['customer_id'];
			$refund_id = $row_car_rental_refund['refund_id'];

			$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode&customer_id=$customer_id&refund_id=$refund_id";

			?>
			<tr class="<?= $bg ?>">			
				<td><?= $count ?></td>
				<td><?= get_car_rental_booking_id($row_car_rental_refund['booking_id'],$year1); ?></td>
				<td><?= $cust_name ?></td>
				<td><?= get_car_rental_booking_refund_id($row_car_rental_refund['refund_id'],$year); ?></td>
				<td><?= date('d/m/Y', strtotime($row_car_rental_refund['refund_date'])) ?></td>
				<td><?= $row_car_rental_refund['refund_mode'] ?></td>
				<td><?= $row_car_rental_refund['bank_name'] ?></td>
				<td><?= $row_car_rental_refund['transaction_id'] ?></td>
				<td class="text-right success"><?= $row_car_rental_refund['refund_amount'] ?></td>
			</tr>
			<?php } ?>
	</tbody>	
	<tfoot>
		<tr class="active">
			<th colspan="1"></th>
			<th colspan="2" class="text-right info">Refund : <?= ($total_refund=="") ? 0 : number_format($total_refund,2) ?></th>
			<th colspan="2" class="text-right warning">Pending : <?= ($pending_refund=="") ? 0 : number_format($pending_refund,2) ?></th>
			<th colspan="2" class="text-right danger">Cancelled : <?= ($canceled_refund=="") ? 0 : number_format($canceled_refund,2) ?></th>
			<th colspan="2" class="text-right success">Total_Refund : <?= number_format($total_refund - $pending_refund - $canceled_refund,2) ?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script>
$('#tbl_refund_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>