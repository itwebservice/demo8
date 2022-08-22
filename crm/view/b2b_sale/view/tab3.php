<?php
$grnd_total = 0;
?>
<div class="container-fluid">
	<!-- Hotel  -->
	<?php if(sizeof($hotel_list_arr)>0){ ?>
	<div class="row">
		<div class="col-md-6">
			<div class="profile_box main_block">
				<legend>Hotel</legend>
				<div class="col-md-12">Price&nbsp; : <strong><?= number_format($price_total,2) ?></strong></div>
				<div class="col-md-12">Tax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?= number_format($tax_total,2) ?></strong></div>
				<div class="col-md-12">Total&nbsp; : <strong><?= number_format($hotel_total,2) ?></strong></div>
			</div>
		</div>
	</div>
	<?php $grnd_total += $hotel_total; }
	?>
	<!-- Transfer  -->
	<?php if(sizeof($transfer_list_arr)>0){ ?>
	<div class="row">
		<div class="col-md-6 mg_tp_10">
			<div class="profile_box main_block">
				<legend>Transfer</legend>
				<div class="col-md-12">Price&nbsp; : <strong><?= number_format($trprice_total,2) ?></strong></div>
				<div class="col-md-12">Tax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?= number_format($trtax_total,2) ?></strong></div>
				<div class="col-md-12">Total&nbsp; : <strong><?= number_format($transfer_total,2) ?></strong></div>
			</div>
		</div>
	</div>
	<?php $grnd_total += $transfer_total; } ?>
	<!-- Activity  -->
	<?php if(sizeof($activity_list_arr)>0){ ?>
	<div class="row">
		<div class="col-md-6 mg_tp_10">
			<div class="profile_box main_block">
				<legend>Activity</legend>
				<div class="col-md-12">Price&nbsp; : <strong><?= number_format($actprice_total,2) ?></strong></div>
				<div class="col-md-12">Tax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?= number_format($acttax_total,2) ?></strong></div>
				<div class="col-md-12">Total&nbsp; : <strong><?= number_format($activity_total,2) ?></strong></div>
			</div>
		</div>
	</div>
	<?php $grnd_total += $activity_total; } ?>
	<!-- Tour  -->
	<?php if(sizeof($tours_list_arr)>0){ ?>
	<div class="row">
		<div class="col-md-6 mg_tp_10">
			<div class="profile_box main_block">
				<legend>Holiday</legend>
				<div class="col-md-12">Price&nbsp; : <strong><?= number_format($toursprice_total,2) ?></strong></div>
				<div class="col-md-12">Tax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?= number_format($tourstax_total,2) ?></strong></div>
				<div class="col-md-12">Total&nbsp; : <strong><?= number_format($tours_total,2) ?></strong></div>
			</div>
		</div>
	</div>
	<?php $grnd_total += $tours_total; } ?>
	<!-- Ferry  -->
	<?php if(sizeof($ferry_list_arr)>0){ ?>
	<div class="row">
		<div class="col-md-6 mg_tp_10">
			<div class="profile_box main_block">
				<legend>Ferry</legend>
				<div class="col-md-12">Price&nbsp; : <strong><?= number_format($ferryprice_total,2) ?></strong></div>
				<div class="col-md-12">Tax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong><?= number_format($ferrytax_total,2) ?></strong></div>
				<div class="col-md-12">Total&nbsp; : <strong><?= number_format($ferry_total,2) ?></strong></div>
			</div>
		</div>
	</div>
	<?php $grnd_total += $ferry_total; } ?>
	<?php
	$text = '';
	if($query['coupon_code'] != ''){
		$sq_hotel_count = mysqli_num_rows(mysqlQuery("select offer,offer_amount from hotel_offers_tarrif where coupon_code='$query[coupon_code]'"));
		$sq_exc_count = mysqli_num_rows(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$query[coupon_code]'"));
		if($sq_hotel_count > 0){
			$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer as offer,offer_amount from hotel_offers_tarrif where coupon_code='$query[coupon_code]'"));
		}else if($sq_exc_count > 0){
			$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from excursion_master_offers where coupon_code='$query[coupon_code]'"));
		}else{
			$sq_coupon = mysqli_fetch_assoc(mysqlQuery("select offer_in as offer,offer_amount from custom_package_offers where coupon_code='$query[coupon_code]'"));
    	}
	
		if($sq_coupon['offer']=="Flat"){
			$grnd_total = $grnd_total - $sq_coupon['offer_amount'];
			$text = 'Promocode('.$query['coupon_code'].') is Applied '.$sq_coupon['offer_amount'].' Off';
		}else{
			$grnd_total = $grnd_total - ($grnd_total*$sq_coupon['offer_amount']/100);
			$text = 'Promocode('.$query['coupon_code'].') is Applied '.$sq_coupon['offer_amount'].'% Off';
		}
	}
	?>
	<div class="row mg_tp_20">
		<div class="profile_box main_block">
			<?php if($text !=''){?><div class="col-md-12"><i><?= $text ?></i></div><?php } ?>
			<div class="col-md-12"><b class="boldText">Grand Total&nbsp; : <?= number_format($grnd_total,2) ?></b></div>
		</div>
	</div>
</div>