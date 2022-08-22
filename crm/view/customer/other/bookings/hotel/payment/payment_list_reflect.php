<?php
include "../../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$customer_id = $_SESSION['customer_id'];

$query = "select * from hotel_booking_payment where 1 and payment_amount!=0 ";
if($booking_id!=""){
	$query .=" and booking_id='$booking_id'";
}
$query .= " and booking_id in (select booking_id from hotel_booking_master where customer_id='$customer_id')";
?>
<div class="row mg_tp_20"><div class="col-xs-12">
<div class="table-responsive">
<table class="table table-bordered table-hover cust_table" id="tbl_payment_list" style="margin:20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Booking_ID</th>
			<th>Payment_Date</th>
			<th>Mode</th>
			<th>Bank</th>
			<th>Cheque_No/ID</th>
			<th class="success">Amount</th>
			<th>Receipt</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_pending_amount=0;
		$sq_cancel_amount=0;
		$sq_paid_amount=0;
		$Total_payment=0;
		$bg;
		$sq_payment = mysqlQuery($query);
		while($row_payment = mysqli_fetch_assoc($sq_payment))
		{
			$date = $row_payment['payment_date'];
			$yr = explode("-", $date);
			$year1 =$yr[0];

			$sq_cancel_amount = 0;
			$sq_pending_amount = 0;
			
			$count++;
			$sq_booking = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_master where booking_id='$row_payment[booking_id]'"));
			$sq_pay = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum,sum(credit_charges) as sumc from hotel_booking_payment where clearance_status!='Cancelled' and clearance_status!='Pending' and booking_id='$row_payment[booking_id]'"));
			$total_sale = $sq_booking['total_fee'];
			$sq_pay = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from hotel_booking_payment where clearance_status!='Cancelled' and booking_id='$row_payment[booking_id]'"));
			$total_pay_amt = $sq_pay['sum'];
			$outstanding =  $total_sale - $total_pay_amt;

			$date = $sq_booking['created_at'];
			$yr = explode("-", $date);
			$year =$yr[0];

			$sq_customer = mysqli_fetch_assoc(mysqlQuery("select * from customer_master where customer_id='$sq_booking[customer_id]'"));

			$sq_check_date = mysqli_fetch_assoc(mysqlQuery("select * from hotel_booking_entries where booking_id = '$row_payment[booking_id]'"));
			
			if($row_payment['clearance_status']=="Pending"){ $bg='warning';
				$sq_pending_amount = $row_payment['payment_amount']+ $row_payment['credit_charges'];
			}

			if($row_payment['clearance_status']=="Cancelled"){ $bg='danger';
				$sq_cancel_amount = $row_payment['payment_amount']+ $row_payment['credit_charges'];
			}

			if($row_payment['clearance_status']=="Cleared"){ $bg='success';
				$sq_paid_amount = $row_payment['payment_amount']+ $row_payment['credit_charges'];
			}

			if($row_payment['clearance_status']==""){ $bg='';
				$sq_paid_amount = $row_payment['payment_amount']+ $row_payment['credit_charges'];
			}

			$payment_id_name = "Hotel Payment ID";
			$payment_id = get_hotel_booking_payment_id($row_payment['payment_id'],$year1);
			$receipt_date = date('d-m-Y');
			$booking_id = get_hotel_booking_id($row_payment['booking_id'],$year);
			$customer_id = $sq_booking['customer_id'];
			$booking_name = "Hotel Booking";
			$travel_date = date('d-m-Y', strtotime($sq_check_date['check_in']));
			$payment_amount = $row_payment['payment_amount']+ $row_payment['credit_charges'];
			$payment_mode1 = $row_payment['payment_mode'];
			$transaction_id = $row_payment['transaction_id'];
			$payment_date = date('d-m-Y',strtotime($row_payment['payment_date']));
			$bank_name = $row_payment['bank_name'];
			$receipt_type ="Hotel Receipt";
			
			$paid_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$row_payment['payment_amount']+ $row_payment['credit_charges']);
			$paid_amount1_string = explode(' ',$paid_amount1);
			$footer_paid_total = str_replace(',', '', $paid_amount1_string[1]);
			$total_paid += $footer_paid_total;

			$sq_pending_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$sq_pending_amount);
			$sq_pending_amount_string = explode(' ',$sq_pending_amount1);
			$footer_pending_total += str_replace(',', '', $sq_pending_amount_string[1]);
			$sq_cancel_amount1 = currency_conversion($currency,$sq_booking['currency_code'],$sq_cancel_amount);
			$sq_cancel_amount_string = explode(' ',$sq_cancel_amount1);
			$footer_cancel_total += str_replace(',', '', $sq_cancel_amount_string[1]);

			$url1 = BASE_URL."model/app_settings/print_html/receipt_html/receipt_body_html.php?payment_id_name=$payment_id_name&payment_id=$payment_id&receipt_date=$receipt_date&booking_id=$booking_id&customer_id=$customer_id&booking_name=$booking_name&travel_date=$travel_date&payment_amount=$payment_amount&transaction_id=$transaction_id&payment_date=$payment_date&bank_name=$bank_name&confirm_by=$confirm_by&receipt_type=$receipt_type&payment_mode=$payment_mode1&branch_status=$branch_status&outstanding=$outstanding&table_name=hotel_booking_payment&customer_field=booking_id&in_customer_id=$row_payment[booking_id]&currency_code=$sq_booking[currency_code]";
			?>
			<tr class="<?= $bg;?>">				
				<td><?= $count ?></td>
				<td><?= get_hotel_booking_id($sq_booking['booking_id'],$year) ?></td>
				<td><?= date('d-m-Y', strtotime($row_payment['payment_date'])) ?></td>
				<td><?= $row_payment['payment_mode'] ?></td>
				<td><?= $row_payment['bank_name'] ?></td>
				<td><?= $row_payment['transaction_id'] ?></td>	
				<td class="success"><?= $paid_amount1 ?></td>				
				<td>
					<a onclick="loadOtherPage('<?= $url1 ?>')" class="btn btn-info btn-sm" title="Download Reciept"><i class="fa fa-print"></i></a>
				</td>
			</tr>
			<?php
		
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">		
			<th colspan="2" class="text-right info">Paid Amount : <?= number_format($total_paid,2); ?></th>
			<th colspan="2" class="warning text-right">Pending Clearance: <?= number_format($footer_pending_total,2) ?></th>
			<th colspan="2" class="danger text-right">Cancelled : <?= number_format($footer_cancel_total,2)?></th>
			<th colspan="2" class="success text-right">Total Payment : <?= number_format(($total_paid-$footer_pending_total-$footer_cancel_total),2); ?></th>
		</tr>
	</tfoot>	
</table>
</div>
</div></div>
<script type="text/javascript">	
$('#tbl_payment_list').dataTable({
	"pagingType": "full_numbers"
});
</script>