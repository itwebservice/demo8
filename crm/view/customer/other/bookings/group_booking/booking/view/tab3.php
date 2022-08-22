<?php
$final_amount = $sq_tour_deatils['net_total'] + $credit_card_charges;
$final_amount1 = currency_conversion($currency,$sq_tour_deatils['currency_code'],$final_amount);
?>
<div class="row">
	<div class="col-xs-12">
	    <div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12 right_border_none_sm" style="border-right: 1px solid #ddd">
				<span class="main_block">
					<div class="highlighted_cost"><i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i><?php echo "<label>Total Amount <em>:</em></label> "; ?><?php echo $final_amount1; ?></div>
		        </span>             
			</div>
		</div>
	</div>
</div>