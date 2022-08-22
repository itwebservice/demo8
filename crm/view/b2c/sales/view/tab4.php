<?php
$total_cost = $costing_data[0]->total_cost;
$total_tax = $costing_data[0]->total_tax;
$taxes = explode(',',$total_tax);
$tax_amount = 0;
$tax_string = '';
for($i=0; $i<sizeof($taxes);$i++){
	$single_tax = explode(':',$taxes[$i]);
	$tax_amount += floatval($single_tax[1]);
	$temp_tax = explode(' ',$single_tax[1]);
	$tax_string .= $single_tax[0].$temp_tax[1];
}
$grand_total = $costing_data[0]->grand_total;
$coupon_amount = $costing_data[0]->coupon_amount;
$coupon_amount = ($coupon_amount!='')?$coupon_amount:0;
$net_total = $costing_data[0]->net_total;
?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 mg_bt_20_xs">
		<div class="profile_box main_block" style="min-height: 141px;">
			<!-- <h3>Costing details</h3> -->
			<div class="row">
				<div class="col-sm-12 col-xs-12 right_border_none_sm_xs" style="border-right: 1px solid #ddd">
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Total Cost <em>:</em></label> ".$total_cost; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>".$tax_name." <em>:</em></label> ".$total_tax; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Grand Total  <em>:</em></label> ".$grand_total; ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Coupon Amount  <em>:</em></label> ".number_format($coupon_amount,2); ?>
					</span>
					<span class="main_block">
						<i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
						<?php echo "<label>Net Total<em>:</em></label><b> ".$net_total.'</b>'; ?>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
