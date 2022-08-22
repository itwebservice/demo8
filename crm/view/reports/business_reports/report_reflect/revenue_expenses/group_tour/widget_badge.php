<?php
include "../../../../../../model/model.php";
$tour_id = $_POST['tour_id'];
$tour_group_id = $_POST['tour_group_id'];

$total_sale = 0; $total_purchase = 0;
$array_s = array();
$temp_arr = array();
//Sale
$q1 = mysqlQuery("select * from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id ='$tour_group_id' and tour_group_status!='Cancel' ");
while($tourwise_details = mysqli_fetch_assoc($q1)){

	$pass_count = mysqli_num_rows(mysqlQuery("select traveler_group_id from travelers_details where traveler_group_id='$tourwise_details[id]'"));
	$cancelpass_count = mysqli_num_rows(mysqlQuery("select traveler_group_id from travelers_details where traveler_group_id='$tourwise_details[id]' and status='Cancel'"));

	if($pass_count != $cancelpass_count){

		$sale_amount = $tourwise_details['net_total'];
		$service_tax_amount = 0;
		if($tourwise_details['service_tax'] !== 0.00 && ($tourwise_details['service_tax']) !== ''){
			$service_tax_subtotal1 = explode(',',$tourwise_details['service_tax']);
			for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
				$service_tax = explode(':',$service_tax_subtotal1[$i]);
				$service_tax_amount +=  $service_tax[2];
			}
		}
		$sale_amount -= $service_tax_amount;
		$total_sale += $sale_amount;
	}
}

// Purchase
$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Group Tour' and estimate_type_id ='$tour_group_id' and status!='Cancel'");
while($row_purchase = mysqli_fetch_assoc($sq_purchase)){
	$total_purchase += $row_purchase['net_total'];
	//Service Tax 
	$service_tax_amount = 0;
	if($row_purchase['service_tax_subtotal'] !== 0.00 && ($row_purchase['service_tax_subtotal']) !== ''){
		$service_tax_subtotal1 = explode(',',$row_purchase['service_tax_subtotal']);
		for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
		$service_tax = explode(':',$service_tax_subtotal1[$i]);
		$service_tax_amount +=  $service_tax[2];
		}
	}
	$total_purchase -= $service_tax_amount;
}

//Other Expense
$sq_other_purchase = mysqli_fetch_assoc(mysqlQuery("select sum(amount) as amount_total from group_tour_estimate_expense where tour_id='$tour_id' and tour_group_id ='$tour_group_id'"));
$total_purchase += $sq_other_purchase['amount_total'];

//Revenue & Expenses
$result = $total_sale - $total_purchase;

if($total_sale > $total_purchase){
	$var = 'Total Profit';
}else{
	$var = 'Total Loss';
}
$profit_loss = $total_sale - $total_purchase;
?>
<div class="main_block mg_bt_30">
	<div class="col-sm-4 mg_bt_10 no-pad-sm">
		<div class="widget_parent-bg-img bg-green mg_bt_10_sm_xs">
			<div class="widget_parent">
				<div class="row">
			         <div class="widget col-sm-12">
			            <div class="title success-col">
			               <span class="succes_name">Total Sale</span> : <span class="succes_count"><?= number_format($total_sale,2) ?></span>
			            </div>
			        </div>    
			    </div>
			    <div class="row"><div class="col-md-12">
			       <div class="widget-badge">
			            <div class="label label-warning"></div>&nbsp;&nbsp;
			        </div> 
			    </div></div>
			    <div class="row"> <div class="col-md-12">
			        <div class="progress mg_bt_0">
			          <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= 100 ?>%"></div>
			        </div>
			    </div> </div>
			</div>
		</div>
	</div>
	<div class="col-sm-4 mg_bt_10 no-pad-sm">
		<?php
	        $percent = ($enquirty_count > 0) ? ($closed_count/$enquirty_count)*100 : 0;
	        $percent = round($percent, 2);
	    ?>
	    <div class="widget_parent-bg-img bg-red mg_bt_10_sm_xs">
	    	<div class="widget_parent">
				<div class="row">
			         <div class="widget col-sm-12">
			            <div class="title success-col">
			            	<span class="succes_name">Total Purchase/Expense</span> : <span class="succes_count"><?= number_format($total_purchase,2) ?></span>
			            </div>
			        </div>
			    </div>
			    <div class="row"><div class="col-md-12">
			       <div class="widget-badge">
			            <div class="label label-warning"></div>&nbsp;&nbsp;
			        </div> 
			    </div></div>
			    <div class="row"> <div class="col-md-12">
			        <div class="progress mg_bt_0">
			          <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= 100 ?>%"></div>
			        </div>
			    </div></div>
			</div>
	    </div>
	</div>
	<div class="col-sm-4 mg_bt_10 no-pad-sm">
		<?php
		   $profit_loss_per = 0;
		   $profit_amount = $total_sale - $total_purchase;
		   $profit_loss_per = ($total_sale>0) ? ($profit_amount / $total_sale) * 100 : 0;
	       $profit_loss_per = round($profit_loss_per, 2);
	    ?>
	    <div class="widget_parent-bg-img bg-img-purp mg_bt_10_sm_xs">
	    	<div class="widget_parent">
				<div class="row">
			         <div class="widget col-sm-12">
			            <div class="title success-col">
			            	<span class="succes_name"><?= $var ?></span> : <span class="succes_count"><?= number_format($profit_loss,2) ?></span>
			            </div>
			        </div>    
			    </div>
			    <div class="row"><div class="col-md-12">
			       <div class="widget-badge">
			            <div class="label label-warning">+ <?= $profit_loss_per ?> %</div>&nbsp;&nbsp;
			        </div> 
			    </div></div>
			    <div class="row"> <div class="col-md-12">
			        <div class="progress mg_bt_0">
			          <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?= $profit_loss_per ?>%"></div>
			        </div>
			    </div> </div>
			</div>
	    </div>
	</div>
</div>