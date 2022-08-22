<?php
include "../../../../../../model/model.php";
$booking_id = $_POST['booking_id'];
$branch_status = $_POST['branch_status'];

$total_sale = 0; $total_purchase = 0;
//Sale
$tourwise_details = mysqli_fetch_assoc(mysqlQuery("select * from package_tour_booking_master where booking_id='$booking_id'"));
//Cancel consideration
$sq_tr_refund = mysqli_num_rows(mysqlQuery("select * from package_refund_traveler_cancalation_entries where traveler_id='$tourwise_details[id]'"));
$sq_paid_amount = mysqli_fetch_assoc(mysqlQuery("SELECT sum(credit_charges) as sumc from package_payment_master where booking_id='$tourwise_details[booking_id]' and clearance_status!='Cancelled'"));
$credit_charges = $sq_paid_amount['sumc'];
$tax_amount1 = 0;
$total_sale = $tourwise_details['net_total'];
	
	$service_tax_subtotal1 = explode(',',$tourwise_details['tour_service_tax_subtotal']);
	for($i=0;$i<sizeof($service_tax_subtotal1);$i++){
		$service_tax = explode(':',$service_tax_subtotal1[$i]);
		$service_tax_amount +=  $service_tax[2];
	}

$total_sale -= $service_tax_amount;
$total_sale += $credit_charges;

$pass_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$tourwise_details[booking_id]'"));
$cancle_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$tourwise_details[booking_id]' and status='Cancel'"));
$bg = ($pass_count==$cancle_count) ? 'danger':'';

// Purchase
$sq_purchase = mysqlQuery("select * from vendor_estimate where estimate_type='Package Tour' and estimate_type_id ='$booking_id' and status!='Cancel'");
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
$sq_other_purchase = mysqli_fetch_assoc(mysqlQuery("select sum(amount) as amount_total from package_tour_estimate_expense where booking_id='$booking_id' "));
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
			    </div> </div>
			</div>
	    </div>
	</div>
	<div class="col-sm-4 mg_bt_10 no-pad-sm">
		<?php
		$profit_loss_per = 0;
		$profit_amount = $total_sale - $total_purchase;
		$profit_loss_per = ($total_sale > 0) ? ($profit_amount / $total_sale) * 100 : 0;
		$profit_loss_per = round($profit_loss_per, 2);
	    ?>
	    <div class="widget_parent-bg-img bg-purple mg_bt_10_sm_xs">
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
<div class="row mg_tp_30"> <div class="col-md-12"> <div class="table-responsive">
	<table class="table table-bordered no-marg">
		<thead>
			<tr class="active table-heading-row">
				<th>S_No.</th>
				<th>Booking_date</th>
				<th>Tour_name</th>
				<th>User_name</th>
				<th>Purchase/Expenses</th>
				<th>Other Expense</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$tourwise_details[emp_id]'"));
		$emp = ($tourwise_details['emp_id'] == 0)?'Admin': $sq_emp['first_name'].' '.$sq_emp['last_name'];
		$btn = ($bg == '') ? '<button class="btn btn-info btn-sm" onclick="package_other_expnse_modal('. $booking_id .')" title="Add Other Miscellaneous amount"><i class="fa fa-plus"></i></button>' : 'NA';
		?>
			<tr class="<?=$bg?>">
				<td><?= 1 ?></td>
				<td><?= get_date_user($tourwise_details['booking_date']) ?></td>
				<td><?= $tourwise_details['tour_name'] ?></td>
				<td><?= $emp ?></td>
				<td><button class="btn btn-info btn-sm" onclick="view_purchase_modal('<?= $tourwise_details['booking_id'] ?>')" title="View Purchase"><i class="fa fa-eye"></i></button></td>
                <td><?= $btn ?></td>
			</tr>
		</tbody>	
	</table>

</div></div></div>

<div id="other_package_expnse_display"></div>

<script>
</script>