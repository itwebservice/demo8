<?php
include "../../../../../../model/model.php";

$customer_id = $_SESSION['customer_id'];
$booking_id = $_POST['booking_id'];

$query = "select * from hotel_booking_master where 1 ";
$query .=" and customer_id='$customer_id'";
if($booking_id!=""){
	$query .=" and booking_id='$booking_id'";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-bordered cust_table" id='tbl_booking_list' style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Booking_Date</th>
			<th>View</th>
			<th class="text-right info">Total Amount</th>
			<th class="text-right success">Paid Amount</th>
			<th class="text-right danger">Cancellation Charges</th>
			<th class="text-right warning">Balance</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$available_bal=0;
		$pending_bal=0;
		$sq_booking = mysqlQuery($query);
		while($row_booking = mysqli_fetch_assoc($sq_booking)){

			$date = $row_booking['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];
			$pass_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id='$row_booking[booking_id]'"));
			$cancel_count = mysqli_num_rows(mysqlQuery("select * from hotel_booking_entries where booking_id='$row_booking[booking_id]' and status='Cancel'"));
			if($pass_count==$cancel_count){
				$bg="danger";
			}
			else {
				$bg="#fff";
			}

			$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$row_booking[customer_id]'"));
			$cancel_amount = $row_booking['cancel_amount'];
			$sq_payment_total = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum,sum(`credit_charges`) as sumc from hotel_booking_payment where booking_id='$row_booking[booking_id]' and clearance_status!='Pending' AND clearance_status!='Cancelled'"));

			$credit_card_charges = $sq_payment_total['sumc'];
			$paid_amount = $sq_payment_total['sum']+$credit_card_charges;
			$paid_amount = ($paid_amount == '')?'0':$paid_amount;		

			$sale_total_amount = $row_booking['total_fee']+$credit_card_charges;
			
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

			$sale_total_amount1 = currency_conversion($currency,$row_booking['currency_code'],$sale_total_amount);
			$paid_amount1 = currency_conversion($currency,$row_booking['currency_code'],$paid_amount);
			$cancel_amount1 = currency_conversion($currency,$row_booking['currency_code'],$cancel_amount);
			$balance_amount1 = currency_conversion($currency,$row_booking['currency_code'],$balance_amount);
			
			$net_total1_string = explode(' ',$sale_total_amount1);
			$footer_net_total = str_replace(',', '', $net_total1_string[1]);
			$paid_amount1_string = explode(' ',$paid_amount1);
			$footer_paid_amount = str_replace(',', '', $paid_amount1_string[1]);
			$cancel_amount1_string = explode(' ',$cancel_amount1);
			$footer_cancel_amount = str_replace(',', '', $cancel_amount1_string[1]);
			$balance_amount1_string = explode(' ',$balance_amount1);
			$footer_balance_amount = str_replace(',', '', $balance_amount1_string[1]);

			//Total
			$total_amount += $footer_net_total;
			$total_paid += $footer_paid_amount;
			$total_cancel += $footer_cancel_amount;
			$total_balance += $footer_balance_amount;
			?>
			<tr class="<?=$bg?>">
				<td><?= ++$count ?></td>
				<td><?= get_hotel_booking_id($row_booking['booking_id'],$year) ?></td>
				<td><?= date('d-m-Y', strtotime($row_booking['created_at'])) ?></td>	
				<td>
					<button class="btn btn-info btn-sm" onclick="booking_display_modal(<?= $row_booking['booking_id'] ?>)" title="View Details"><i class="fa fa-eye"></i></button>
				</td>		
				<td class="text-right  info"><?= $sale_total_amount1 ?></td>
				<td class="text-right  success"><?= $paid_amount1 ?></td>
				<td class="text-right danger"><?= $cancel_amount1 ?></td>
				<td class="text-right warning"><?= $balance_amount1 ?></td>	
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="4" class="text-right">Total</th>
			<th class="text-right info"><?= number_format($total_amount,2) ?></th>
			<th class="text-right success"><?= number_format($total_paid,2) ?></th>
			<th class="text-right danger"><?= number_format($total_cancel,2) ?></th>
			<th class="text-right warning"><?= number_format(($total_balance),2) ?></th>
		</tr>
	</tfoot>
</table>

</div> </div> </div>
<script type="text/javascript">
$('#tbl_booking_list').dataTable({
	"pagingType": "full_numbers"
});
</script>