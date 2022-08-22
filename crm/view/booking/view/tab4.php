<?php

//paid
$query = mysqli_fetch_assoc(mysqlQuery("SELECT sum(amount) as sum,sum(credit_charges) as sumc from payment_master where tourwise_traveler_id='$sq_group_info[id]' and clearance_status != 'Pending' and clearance_status != 'Cancelled'"));
$paid_amount = $query['sum']+$query['sumc'];
$paid_amount = ($paid_amount == '')?'0':$paid_amount;
$sale_total_amount=$sq_group_info['net_total'] +$query['sumc'];
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

$pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$sq_group_info[id]'"));
$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$sq_group_info[id]' and status='Cancel'"));    

if($sq_group_info['tour_group_status'] == 'Cancel'){
	//Group Tour cancel
	$cancel_tour_count2=mysqli_num_rows(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$sq_group_info[id]'"));
	if($cancel_tour_count2 >= '1'){
		$cancel_tour=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_tour_estimate where tourwise_traveler_id='$sq_group_info[id]'"));
		$cancel_amount2 = $cancel_tour['cancel_amount'];
	}
	else{ $cancel_amount2 = 0; }

	if($cancel_esti_count1 >= '1'){
		$cancel_amount = $cancel_amount1;
	}else{
		$cancel_amount = $cancel_amount2;
	}	
}
else{
	// Group booking cancel
	$cancel_esti_count1=mysqli_num_rows(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$sq_group_info[id]'"));
	if($pass_count==$cancelpass_count){
		$cancel_esti1=mysqli_fetch_assoc(mysqlQuery("SELECT * from refund_traveler_estimate where tourwise_traveler_id='$sq_group_info[id]'"));
		$cancel_amount = $cancel_esti1['cancel_amount'];
	}
	else{ $cancel_amount = 0; }
}

$cancel_amount = ($cancel_amount == '')?'0':$cancel_amount;
if($sq_group_info['tour_group_status'] == 'Cancel'){
	if($cancel_amount > $paid_amount){
		$balance_amount = $cancel_amount - $paid_amount;
	}
	else{
		$balance_amount = 0;
	}
}else{
	if($pass_count==$cancelpass_count){
		if($cancel_amount > $paid_amount){
			$balance_amount = $cancel_amount - $paid_amount;
		}
		else{
			$balance_amount = 0;
		}
	}
	else{
		$balance_amount = $sale_total_amount - $paid_amount;
	}
}
include "../../../model/app_settings/generic_sale_widget.php";
?>


<div class="row">

	<div class="col-md-12">

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

					 $query2 = "SELECT * from payment_master where tourwise_traveler_id='$id'";		

					 $sq_group_payment = mysqlQuery($query2);	

					 $bg="";



					 while($row_group_payment = mysqli_fetch_assoc($sq_group_payment)){

					 	if($row_group_payment['amount'] != '0')

					 	{

							$count++;

							$bg = '';

							if($row_group_payment['clearance_status']=="Pending"){ $bg="warning";}

						    else if($row_group_payment['clearance_status']=="Cancelled"){ $bg="danger";} 

							?>



							<tr class="<?php echo $bg; ?>">

						        <td><?php echo $count; ?></td>

						        <td><?php echo get_date_user($row_group_payment['date']); ?></td>

						        <td><?php echo $row_group_payment['payment_mode']; ?></td>

						        <td><?php echo $row_group_payment['bank_name']; ?></td>

						        <td><?php echo $row_group_payment['transaction_id']; ?></td>

						        <td class="text-right"><?php echo number_format($row_group_payment['amount']+$row_group_payment['credit_charges'],2); ?></td>

						    </tr>

					    <?php   } 

					    }	 ?>

					</tbody>

				</table>

			</div>

		</div>

	</div>

</div>

