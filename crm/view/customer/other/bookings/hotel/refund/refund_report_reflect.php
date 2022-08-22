<?php
include "../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from hotel_booking_refund_master where 1 ";
if ($booking_id != "") {
	$query .= " and booking_id='$booking_id'";
}
$query .= " and booking_id in ( select booking_id from hotel_booking_master where customer_id='$customer_id' )";

$sq_hotel_info = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_master where booking_id='$booking_id'"));

$sq_payment_total = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from hotel_booking_payment where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));


$sq_ref_pay_total = mysqli_fetch_assoc(mysqlQuery("select sum(refund_amount) as sum from hotel_booking_refund_master where booking_id='$booking_id' and clearance_status!='Pending' and clearance_status!='Cancelled'"));

$sq_ref_pen_total = mysqli_fetch_assoc(mysqlQuery("select sum(refund_amount) as sum from hotel_booking_refund_master where booking_id='$booking_id' and clearance_status='Pending'"));



$paid_amount = $sq_payment_total['sum'];


$sale_amount = $sq_hotel_info['total_cost'] - $sq_hotel_info['total_refund_amount'];

$bal_amount = $paid_amount - $sale_amount;

?>
<div class="row mg_tp_20">
	<div class="col-md-12">
		<div class="table-responsive">

			<table class="table table-bordered table-hover" id="tbl_refund" style="margin: 20px 0 !important">
				<thead>
					<tr>
						<th>S_No.</th>
						<th>Booking_ID</th>
						<th>Refund_ID</th>
						<th>Refund_Date</th>
						<th>Mode</th>
						<th>Bank Name</th>
						<th>Cheque_No/ID</th>
						<th class="text-right success">Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$total_refund = 0;
					$count = 0;
					$bg;
					$sq_refund = mysqlQuery($query);
					while ($row_refund = mysqli_fetch_assoc($sq_refund)) {

						$sq_booking = mysqli_fetch_assoc(mysqlQuery("select currency_code from hotel_booking_master where booking_id='$row_refund[booking_id]'"));

						$date = $row_refund['refund_date'];
						$yr = explode("-", $date);
						$year = $yr[0];
						$hotel_name = "";
						$sq_refund_entries = mysqlQuery("select * from hotel_booking_refund_entries where refund_id='$row_refund[refund_id]'");
						while ($row_refund_entry = mysqli_fetch_assoc($sq_refund_entries)) {

							$sq_entry_info = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_entries where entry_id='$row_refund_entry[entry_id]'"));
							$sq_hotel_info = mysqli_fetch_assoc(mysqlQuery("select * from hotel_master where hotel_id='$sq_entry_info[hotel_id]'"));
							$hotel_name .= $sq_hotel_info['hotel_name'] . ', ';
						}
						$hotel_name = trim($hotel_name, ", ");

						if ($row_hotel_refund['clearance_status'] == "Pending") {
							$bg = "warning";
						} else if ($row_hotel_refund['clearance_status'] == "Cancelled") {
							$bg = "danger";
						} else {
							$bg = "";
						}

						$v_voucher_no = get_hotel_booking_refund_id($row_refund['refund_id'], $year);
						$v_refund_date = $row_refund['refund_date'];
						$v_refund_to = $hotel_name;
						$v_service_name = "Hotel Booking";
						$v_refund_amount = $row_refund['refund_amount'];
						$v_payment_mode = $row_refund['refund_mode'];
						$url = BASE_URL . "model/app_settings/generic_refund_voucher_pdf.php?v_voucher_no=$v_voucher_no&v_refund_date=$v_refund_date&v_refund_to=$v_refund_to&v_service_name=$v_service_name&v_refund_amount=$v_refund_amount&v_payment_mode=$v_payment_mode";

						$total_refund = $total_refund + $row_refund['refund_amount'];

						if ($row_refund['clearance_status'] == "Pending") {
							$bg = 'warning';
							$sq_pending_amount = $sq_pending_amount + $row_refund['refund_amount'];
						}
						if ($row_refund['clearance_status'] == "Cleared") {
							$bg = 'success';
							$sq_paid_amount = $row_refund['refund_amount'];
						}
						if ($row_refund['clearance_status'] == "Cancelled") {
							$bg = 'danger';
							$sq_can_amount = $row_refund['refund_amount'];
						}
						if ($row_refund['clearance_status'] == "") {
							$bg = '';
							$sq_paid_amount = $sq_paid_amount + $row_refund['refund_amount'];
						}
						$total_refund_amt += $row_refund['refund_amount'];
						$total_refund_amt1 = currency_conversion($currency,$sq_booking['currency_code'],$row_refund['refund_amount']);
						$total_refund_amt_string = explode(' ',$total_refund_amt1);
						$footer_refund_total += str_replace(',', '', $total_refund_amt_string[1]);

						$sq_pending_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$sq_pending_amount);
						$sq_pending_amount_string = explode(' ',$sq_pending_amount1);
						$footer_pending_total += str_replace(',', '', $sq_pending_amount_string[1]);

						$sq_can_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$sq_can_amount);
						$sq_can_amount_string = explode(' ',$sq_can_amount1);
						$footer_canc_total += str_replace(',', '', $sq_can_amount_string[1]);

						$refund_amount = currency_conversion($currency,$sq_booking['currency_code'],$row_refund['refund_amount']);
					?>
						<tr class="<?= $bg; ?>">
							<td><?= ++$count ?></td>
							<td><?= get_hotel_booking_id($row_refund['booking_id'], $year); ?></td>
							<td><?= get_hotel_booking_refund_id($row_refund['refund_id'], $year) ?></td>
							<td><?= date('d-m-Y', strtotime($row_refund['refund_date'])) ?></td>
							<td><?= $row_refund['refund_mode'] ?></td>
							<td><?= $row_refund['bank_name'] ?></td>
							<td><?= $row_refund['transaction_id'] ?></td>
							<td class="text-right success"><?= $refund_amount ?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
				<tfoot>
					<tr class="active">
						<th colspan="2" class="text-right info">Refund : <?= number_format($footer_refund_total, 2); ?></th>
						<th colspan="2" class="text-right warning">Pending : <?= number_format($footer_pending_total, 2); ?></th>
						<th colspan="2" class="text-right danger">Cancelled : <?= number_format($footer_canc_total, 2); ?></th>
						<th colspan="2" class="text-right success">Total Refund: <?= number_format(($footer_refund_total - $footer_pending_total - $footer_canc_total), 2); ?></th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>
</div>
<script>
	$('#tbl_refund').dataTable({
		"pagingType": "full_numbers"
	});
</script>