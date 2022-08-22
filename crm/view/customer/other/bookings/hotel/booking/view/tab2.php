 <?php
 //sale 

//Cancel
$cancel_amount=$sq_hotel_info['cancel_amount'];
$pass_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id='$sq_hotel_info[booking_id]'"));
$cancel_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id='$sq_hotel_info[booking_id]' and status='Cancel'"));

$paid_amount = $query['sum']+ $query['sumc'];
$paid_amount = ($paid_amount == '')?'0':$paid_amount;

$sale_total_amount=$sq_hotel_info['total_fee'] + $query['sumc'];
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

if($pass_count == $cancel_count){
	if($paid_amount > 0){
		if($cancel_amount >0){
			if($paid_amount > $cancel_amount){
				$balance_amount = 0;
			}else{
				$balance_amount = $cancel_amount - $paid_amount;
			}
		}else{
			$balance_amount = 0;
		}
	}
	else{
		$balance_amount = $cancel_amount;
	}
}
else{
	$balance_amount = $sale_total_amount - $paid_amount;
}

$sale_total_amount1 = currency_conversion($currency,$sq_hotel_info['currency_code'],$sale_total_amount);
$paid_amount1 = currency_conversion($currency,$sq_hotel_info['currency_code'],$paid_amount);
$cancel_amount1 = currency_conversion($currency,$sq_hotel_info['currency_code'],$cancel_amount);
$balance_amount1 = currency_conversion($currency,$sq_hotel_info['currency_code'],$balance_amount);

$sale_total_amount1 = explode(' ',$sale_total_amount1);
$sale_total_amount = str_replace(',', '', $sale_total_amount1[1]);
$paid_amount1_string = explode(' ',$paid_amount1);
$paid_amount = str_replace(',', '', $paid_amount1_string[1]);
$cancel_amount1_string = explode(' ',$cancel_amount1);
$cancel_amount = str_replace(',', '', $cancel_amount1_string[1]);
$balance_amount1_string = explode(' ',$balance_amount1);
$balance_amount = str_replace(',', '', $balance_amount1_string[1]);

include "../../../../../../../model/app_settings/generic_sale_widget.php";
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
						<th>Amount</th>
				    </tr>
				</thead>
				<tbody>
				<?php 
					$count = 0;
					$query = "select * from hotel_booking_payment where booking_id='$booking_id' ";
					$sq_payment = mysqlQuery($query);
					while($row_payment = mysqli_fetch_assoc($sq_payment))
					{
						if($row_payment['payment_amount'] != '0'){
						    $count++;
							$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_master where booking_id='$row_payment[booking_id]'"));
			                $sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));
			                
			                $bg="";

							if($row_payment['clearance_status']=="Pending"){ 
								$bg='warning';
							}
							else if($row_payment['clearance_status']=="Cancelled"){ 
								$bg='danger';
							}
							else{ $bg = 'success';}
				
							$paid_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$row_payment['payment_amount'] + $row_payment['credit_charges']);

						?>
						<tr class="<?= $bg;?>">				
							<td><?= $count ?></td>
							<td><?= get_date_user($row_payment['payment_date']) ?></td>
							<td><?= $row_payment['payment_mode'] ?></td>
							<td><?= $row_payment['bank_name'] ?></td>
							<td><?= $row_payment['transaction_id'] ?></td>
							<td><?= $paid_amount1 ?></td>
						</tr>
						<?php
					}
				}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
