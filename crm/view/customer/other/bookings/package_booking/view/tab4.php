<?php
$query = mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum,sum(`credit_charges`) as sumc from package_payment_master where booking_id='$booking_id' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum'];
$credit_card_amount = $query['sumc'];
$net_total1 = currency_conversion($currency,$sq_package_info['currency_code'],$sq_package_info['net_total']+$credit_card_amount);
?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 141px;">
			<div class="row">
				<div class="col-sm-4 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
					<span class="main_block highlighted_cost">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Total Amount <em>:</em></label>" . $net_total1 ?>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>