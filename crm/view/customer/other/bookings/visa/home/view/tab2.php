<?php
//Sale
$sale_total_amount=$sq_visa_info['visa_total_cost'];
if($sale_total_amount==""){  $sale_total_amount = 0 ;  }

//Cancel
$cancel_amount=$sq_visa_info['cancel_amount'];
$pass_count = mysqli_num_rows(mysqlQuery("select * from visa_master_entries where visa_id='$sq_visa_info[visa_id]'"));
$cancel_count = mysqli_num_rows(mysqlQuery("select * from visa_master_entries where visa_id='$sq_visa_info[visa_id]' and status='Cancel'"));

$paid_amount = $query['sum'] + $query['sumc'];
$paid_amount = ($paid_amount == '')?'0':$paid_amount;

$sale_total_amount = $sale_total_amount + $query['sumc'];

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

$sale_total_amount1 = currency_conversion($currency,$sq_visa_info['currency_code'],$sale_total_amount);
$paid_amount1 = currency_conversion($currency,$sq_visa_info['currency_code'],$paid_amount);
$cancel_amount1 = currency_conversion($currency,$sq_visa_info['currency_code'],$cancel_amount);
$balance_amount1 = currency_conversion($currency,$sq_visa_info['currency_code'],$balance_amount);

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
	        <table id="tbl_dynamic_visa_update" name="tbl_dynamic_visa_update" class="table table-bordered no-marg">
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
				 $query = "SELECT * from visa_payment_master where visa_id='$visa_id'";		
				 $sq_visa_payment = mysqlQuery($query);	
				 $bg="";

				 while($row_visa_payment = mysqli_fetch_assoc($sq_visa_payment)){
				 	if($row_visa_payment['payment_amount'] != '0'){
						$count++;
						$bg = '';
						if($row_visa_payment['clearance_status']=="Pending"){ $bg="warning";}
					    else if($row_visa_payment['clearance_status']=="Cancelled"){ $bg="danger";} 
					    else { $bg = 'success';}
						$pay_amount = currency_conversion($currency,$sq_visa_info['currency_code'],$row_visa_payment['payment_amount'] + $row_visa_payment['credit_charges']);
						?>

						<tr class="<?php echo $bg; ?>">
					        <td><?php echo $count; ?></td>
					        <td><?php echo get_date_user($row_visa_payment['payment_date']); ?></td>
					        <td><?php echo $row_visa_payment['payment_mode']; ?></td>
					        <td><?php echo $row_visa_payment['bank_name']; ?></td>
					        <td><?php echo $row_visa_payment['transaction_id']; ?></td>
					        <td class="text-right"><?php echo $pay_amount; ?></td>
					    </tr>
				    <?php   } 
				    } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
