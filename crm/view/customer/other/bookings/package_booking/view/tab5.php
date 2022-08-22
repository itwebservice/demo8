<!-- Tour Payment details-->
<?php
$query = mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum,sum(`credit_charges`) as sumc from package_payment_master where booking_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$credit_card_amount = $query['sumc'];
$paid_amount = $query['sum'] + $credit_card_amount;
$paid_amount = ($paid_amount == '') ? '0' : $paid_amount;
$sale_total_amount = $sq_package_info['net_total'] + $credit_card_amount;
if ($sale_total_amount == "") {
	$sale_total_amount = 0;
}
$cancel_est = mysqli_fetch_assoc(mysqlQuery("select * from package_refund_traveler_estimate where booking_id='$sq_package_info[booking_id]'"));
$cancel_amount = $cancel_est['cancel_amount'];
if ($cancel_amount != '') {
	if ($cancel_amount <= $paid_amount) {
		$balance_amount = 0;
	} else {
		$balance_amount =  $cancel_amount - $paid_amount;
	}
} else {
	$cancel_amount = ($cancel_amount == '') ? '0' : $cancel_amount;
	$balance_amount = $sale_total_amount - $paid_amount;
}
$sale_total_amount1 = currency_conversion($currency,$sq_package_info['currency_code'],$sale_total_amount);
$paid_amount1 = currency_conversion($currency,$sq_package_info['currency_code'],$paid_amount);
$cancel_amount1 = currency_conversion($currency,$sq_package_info['currency_code'],$cancel_amount);
$balance_amount1 = currency_conversion($currency,$sq_package_info['currency_code'],$balance_amount);

$sale_total_amount1 = explode(' ',$sale_total_amount1);
$sale_total_amount = str_replace(',', '', $sale_total_amount1[1]);
$paid_amount1_string = explode(' ',$paid_amount1);
$paid_amount = str_replace(',', '', $paid_amount1_string[1]);
$cancel_amount1_string = explode(' ',$cancel_amount1);
$cancel_amount = str_replace(',', '', $cancel_amount1_string[1]);
$balance_amount1_string = explode(' ',$balance_amount1);
$balance_amount = str_replace(',', '', $balance_amount1_string[1]);

include "../../../../../../model/app_settings/generic_sale_widget.php";
?>
<div class="row">
	<div class="col-xs-12">
		<div class="profile_box main_block" style="margin-top: 25px">
			<h3 class="editor_title">Summary</h3>
			<div class="table-responsive">
				<table class="table table-bordered no-marg">
					<thead>
						<tr class="table-heading-row">
							<th>S_No.</th>
							<th>Date</th>
							<th>Mode</th>
							<th>Bank_Name</th>
							<th>Cheque_No/ID</th>
							<th class="text-right">Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 0;
						$query2 = "SELECT * from package_payment_master where booking_id='$booking_id' and amount != '0'";
						$sq_package_payment = mysqlQuery($query2);
						$bg = "";

						while ($row_package_payment = mysqli_fetch_assoc($sq_package_payment)) {

							$count++;
							$bg = '';
							if ($row_package_payment['clearance_status'] == "Pending") {
								$bg = "warning";
							} else if ($row_package_payment['clearance_status'] == "Cancelled") {
								$bg = "danger";
							}
							$paid_amount1 = currency_conversion($currency,$sq_package_info['currency_code'],$row_package_payment['amount'] + $row_package_payment['credit_charges']);
							?>
							<tr class="<?php echo $bg; ?>">
								<td><?php echo $count; ?></td>
								<td><?php echo get_date_user($row_package_payment['date']); ?></td>
								<td><?php echo $row_package_payment['payment_mode']; ?></td>
								<td><?php echo $row_package_payment['bank_name']; ?></td>
								<td><?php echo $row_package_payment['transaction_id']; ?></td>
								<td class="text-right"><?php echo $paid_amount1; ?></td>
							</tr>
						<?php }  ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>