<?php
include "../../../../../../model/model.php";

$visa_id = $_POST['visa_id'];
$customer_id = $_SESSION['customer_id'];
global $currency;

$query = "select * from visa_refund_master where 1 ";
if($visa_id!=""){
	$query .=" and visa_id='$visa_id'";
}
$query .=" and visa_id in ( select visa_id from visa_master where customer_id='$customer_id' )";

?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered table-hover bg_white cust_table" id="tbl_refund" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>Sr. No</th>
			<th>Booking_ID</th>
			<th>Passenger_name</th>
			<th>Refund_Date</th>
			<th>Mode</th>
			<th>Bank_Name</th>
			<th>Cheque_No/ID</th>
			<th class="success text-right">Refund_Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_refund = 0;
		$count = 0;
		$bg;
		$sq_refund = mysqlQuery($query);
		$footer_refund_total = 0;
		while($row_refund = mysqli_fetch_assoc($sq_refund)){

			$pen_amt = 0;
			$can_amt = 0;
			$traveler_name = "";
			$sq_visa = mysqli_fetch_assoc(mysqlQuery("select * from visa_master where visa_id='$row_refund[visa_id]'"));
			$date = $sq_visa['created_at'];
			$yr = explode("-", $date);
			$year1 =$yr[0];
			$sq_refund_entries = mysqlQuery("select * from visa_refund_entries where refund_id='$row_refund[refund_id]'");
			while($row_refund_entry = mysqli_fetch_assoc($sq_refund_entries)){

				$sq_entry_info = mysqli_fetch_assoc(mysqlQuery("select * from visa_master_entries where entry_id='$row_refund_entry[entry_id]'"));
				$traveler_name .= $sq_entry_info['first_name'].' '.$sq_entry_info['last_name'].', ';
			}
			$traveler_name = trim($traveler_name, ", ");

			$total_refund = $total_refund+$row_refund['refund_amount'];
			$bg='';

			if($row_refund['clearance_status']=="Pending"){$bg='warning'; $pen_amt=$row_refund['refund_amount'];}
			if($row_refund['clearance_status']=="Cancelled"){$can_amt= $row_refund['refund_amount'];$bg='danger';}

			$date = $row_refund['refund_date'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$v_voucher_no = get_visa_booking_refund_id($row_refund['refund_id'],$year);
			$v_refund_date = $row_refund['refund_date'];
			$v_refund_to = $traveler_name;
			$v_service_name = "Visa Booking";
			$v_refund_amount = $row_refund['refund_amount'];
			$v_payment_mode = $row_refund['refund_mode'];
			$url = BASE_URL."model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode";	

			$refund_amount = currency_conversion($currency,$sq_visa['currency_code'],$row_refund['refund_amount']);
			$total_refund_amt_string = explode(' ',$refund_amount);
			$footer_refund_total += str_replace(',', '', $total_refund_amt_string[1]);

			$sq_pending_amount1 = currency_conversion($currency,$sq_visa['currency_code'],$pen_amt);
			$sq_pending_amount_string = explode(' ',$sq_pending_amount1);
			$footer_pending_total += str_replace(',', '', $sq_pending_amount_string[1]);

			$sq_can_amount1 = currency_conversion($currency,$sq_visa['currency_code'],$can_amt);
			$sq_can_amount_string = explode(' ',$sq_can_amount1);
			$footer_canc_total += str_replace(',', '', $sq_can_amount_string[1]);
			?>
			<tr class="<?= $bg;?>">
				<td><?= ++$count ?></td>
				<td><?= get_visa_booking_id($row_refund['visa_id'],$year1); ?></td>
				<td><?= $traveler_name ?></td>
				<td><?= date('d-m-Y', strtotime($row_refund['refund_date'])) ?></td>
				<td><?= $row_refund['refund_mode'] ?></td>
				<td><?= $row_refund['bank_name'] ?></td>
				<td><?= $row_refund['transaction_id'] ?></td>
				<td class="success text-right"><?= $refund_amount ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="2"  class="text-right info">Refund : <?= number_format($footer_refund_total,2);?></th>
			<th colspan="2" class="text-right warning">Pending : <?= number_format($footer_pending_total,2);?></th>	
			<th colspan="2" class="text-right danger">Cancelled : <?= number_format($footer_canc_total,2); ?></th>
			<th colspan="2" class="text-right success">Total Refund: <?= number_format(($footer_refund_total-$footer_pending_total-$footer_canc_total),2)?></th>						
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script type="text/javascript">
$('#tbl_refund').dataTable({
	"pagingType": "full_numbers"
});
</script>