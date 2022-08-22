<?php
include "../../../../model/model.php";

$exc_id = $_POST['exc_id'];
$from_date = $_POST['payment_from_date'];
$to_date = $_POST['payment_to_date'];

$query = "select * from exc_refund_master where 1 ";
if($exc_id!=""){
	$query .=" and exc_id='$exc_id'";
}
if($from_date!='' && $to_date!=''){
			$from_date = get_date_db($from_date);
			$to_date = get_date_db($to_date);
			$query .=" and refund_date between '$from_date' and '$to_date'";
}
?>
<div class="row mg_tp_20"> <div class="col-xs-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_refund" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Passenger_name&nbsp;&nbsp;&nbsp;&nbsp;</th>
			<th>Refund_ID</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="text-right">Refund_Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = 0;
		$count = 0;
		$bg;
		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$Total_payment=0;
		$sq_refund = mysqlQuery($query);
		while($row_refund = mysqli_fetch_assoc($sq_refund)){
			$cust_name = "";
			$sq_entry_info = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id=(select customer_id from excursion_master where exc_id='$row_refund[exc_id]')"));
			$sq_date =  mysqli_fetch_assoc(mysqlQuery("select * from excursion_master where exc_id='$row_refund[exc_id]'"));
			$date = $sq_date['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$yr1 = explode("-", $row_refund['refund_date']);
			$year1 =$yr[0];
			$cust_name .= $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'];												
		
			$total_refund = $total_refund+$row_refund['refund_amount']; 
			
			if($row_refund['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $sq_pending_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']=="Cancelled"){ $bg='danger';
				$sq_cancel_amount = $sq_cancel_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']=="Cleared"){ $bg='success';
				$sq_paid_amount = $sq_paid_amount + $row_refund['refund_amount'];
			}
			if($row_refund['clearance_status']==""){ $bg='';
				$sq_paid_amount = $sq_paid_amount + $row_refund['refund_amount'];
			}
			?>
			<tr class="<?= $bg;?>">
				<td><?= ++$count ?></td>
				<td><?= get_exc_booking_id($row_refund['exc_id'],$year); ?></td>
				<td><?= $cust_name ?></td>
				<td><?= get_exc_booking_refund_id($row_refund['refund_id'],$year1); ?></td>
				<td><?= date('d-m-Y', strtotime($row_refund['refund_date'])) ?></td>
				<td><?= $row_refund['refund_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td class="text-right success"><?= number_format($row_refund['refund_amount'],2) ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th class="text-right info" colspan="3">Refund : <?= ($total_refund=="") ? number_format(0,2) : number_format($total_refund,2) ?></th>
			<th colspan="2" class="text-right warning">Pending : <?= ($sq_pending_amount=='')?number_format(0,2):number_format($sq_pending_amount,2);?></th>
			<th colspan="2" class="text-right danger">Cancelled: <?= ($sq_cancel_amount=='')?number_format(0,2):number_format($sq_cancel_amount,2);?> </th>
			<th colspan="2" class="text-right success">Total_Refund : <?= ($sq_paid_amount=='')?number_format(0,2):number_format($sq_paid_amount,2); ?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script>
$('#tbl_refund').dataTable({
		"pagingType": "full_numbers"
	});
</script>