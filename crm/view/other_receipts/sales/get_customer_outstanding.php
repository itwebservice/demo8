<?php
include "../../../model/model.php";
$customer_id = $_POST['cust_id'];
if($customer_id != ''){
?>
<div class="row"> <div class="col-md-12"> <div class="table-responsive">
<table class="table table-bordered cust_table" id="tbl_list_sales" style="padding: 0 !important; background: #fff;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Sale</th>
			<th>Sale ID</th>
			<th class="text-right">Amount</th>
			<th class="text-center">Select</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		//Get Booking rows
		include "get_customer_booking.php"; ?>
	</tbody>
</table>
</div> </div> </div>

<div class="row mg_tp_20">
	<div class="col-md-3 col-md-offset-7">
		<input type="text" placeholder="Total outstanding" title="Total outstanding" value="0.00" class="form-control text-right" id="total_purchase" name="total_purchase" readonly>
	</div>
</div>

<?php 
$sq_ledger_count = mysqli_num_rows(mysqlQuery("select * from ledger_master where customer_id='$customer_id' and user_type='customer' "));
$utilized_advance = 0;

if($sq_ledger_count != '0'){
	
	$tdebit_amount = 0;
	$tcredit_amount = 0;
	$sq_ledger = mysqli_fetch_assoc(mysqlQuery("select * from ledger_master where customer_id='$customer_id' and user_type='customer'"));

	$sq_advance = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `corporate_advance_master` WHERE `cust_id`='$customer_id' and `clearance_status`!='Pending' and `clearance_status`!='Cancelled'"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`amount`) as sum FROM `payment_master` WHERE tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id='$customer_id' and tour_group_status!='Cancel') and tourwise_traveler_id not in (select tourwise_traveler_id from refund_traveler_estimate where 1) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	
	$sq_cancel_tour = mysqli_fetch_assoc(mysqlQuery("select sum(`cancel_amount`) as sum_c1 from refund_tour_estimate where tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id='$customer_id')"));
	$sq_cancel_travel = mysqli_fetch_assoc(mysqlQuery("select sum(`cancel_amount`) as sum_c1 from refund_traveler_estimate where tourwise_traveler_id in (select id from tourwise_traveler_details where customer_id='$customer_id')"));
	
	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`amount`) as sum FROM `package_payment_master` WHERE booking_id in (select booking_id from package_tour_booking_master where customer_id='$customer_id') and booking_id not in (select booking_id from package_refund_traveler_estimate where 1) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$cancel_est = mysqli_fetch_assoc(mysqlQuery("select sum(`cancel_amount`) as sum_c from package_refund_traveler_estimate where booking_id in (select booking_id from package_tour_booking_master where customer_id='$customer_id')"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `hotel_booking_payment` WHERE booking_id in (select booking_id from hotel_booking_master where customer_id='$customer_id' and cancel_flag=0) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$sq_cancel1 = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`cancel_amount`) as sum_c FROM hotel_booking_master where customer_id='$customer_id' and cancel_flag=1"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `ticket_payment_master` WHERE ticket_id in (select ticket_id from ticket_master where customer_id='$customer_id' and cancel_flag=0) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$sq_cancel2 = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`cancel_amount`) as sum_c FROM ticket_master where customer_id='$customer_id' and cancel_flag=1"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `train_ticket_payment_master` WHERE train_ticket_id in (select train_ticket_id from train_ticket_master where customer_id='$customer_id' and cancel_flag=0) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$sq_cancel3 = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`cancel_amount`) as sum_c FROM train_ticket_master where customer_id='$customer_id' and cancel_flag=1"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `visa_payment_master` WHERE visa_id in (select visa_id from visa_master where customer_id='$customer_id' and cancel_flag=0) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$sq_cancel4 = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`cancel_amount`) as sum_c FROM visa_master where customer_id='$customer_id' and cancel_flag=1"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `bus_booking_payment_master` WHERE booking_id in (select booking_id from bus_booking_master where customer_id='$customer_id' and cancel_flag=0) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$sq_cancel5 = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`cancel_amount`) as sum_c FROM bus_booking_master where customer_id='$customer_id' and cancel_flag=1"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `car_rental_payment` WHERE booking_id in (select booking_id from car_rental_booking where customer_id='$customer_id' and cancel_flag=0) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$sq_cancel6 = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`cancel_amount`) as sum_c FROM car_rental_booking where customer_id='$customer_id' and cancel_flag=1"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `exc_payment_master` WHERE exc_id in (select exc_id from excursion_master where customer_id='$customer_id' and cancel_flag=0) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$sq_cancel7 = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`cancel_amount`) as sum_c FROM excursion_master where customer_id='$customer_id' and cancel_flag=1"));

	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `miscellaneous_payment_master` WHERE misc_id in (select misc_id from miscellaneous_master where customer_id ='$customer_id' and cancel_flag=0) and `clearance_status`!='Pending' and `clearance_status`!='Cancelled' and payment_mode='Advance'"));
	$utilized_advance += $sq_payment['sum'];
	$sq_cancel8 = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`cancel_amount`) as sum_c FROM miscellaneous_master where customer_id='$customer_id' and cancel_flag=1"));
?>
<div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
    <legend>Advance Details</legend>
	<div class="row mg_tp_20">
		<div class="col-md-5">
			<?php
			$cancel_amount_total = $sq_cancel1['sum_c'] + $sq_cancel2['sum_c'] + $sq_cancel3['sum_c'] + $sq_cancel4['sum_c'] + $sq_cancel5['sum_c'] + $sq_cancel6['sum_c'] + $sq_cancel7['sum_c'] + $sq_cancel8['sum_c'] + $cancel_est['sum_c'] + $sq_cancel_tour['sum_c1'] + $sq_cancel_travel['sum_c1'];
			$cancel_amount_total = (floatval($cancel_amount_total) < 0) ? 0 : $cancel_amount_total;

			$total_debit = 0;
			$total_credit = 0;
			$balance = 0;
			$balance = $sq_advance['sum'] - floatval($utilized_advance);
			$balance = (floatval($balance) < 0) ? 0 : $balance;
			$balance = $balance - $cancel_amount_total;
			echo $sq_ledger['ledger_name'].' : '.'('.$sq_ledger['dr_cr'].')';
			$balance = (floatval($balance) < 0) ? 0 : $balance;
			?>
		</div>
		<div class="col-md-2">
			<input type="text" class="form-control" id="advance_amount" title="Advance Amount" name="advance_amount" value="<?= ($balance) ?>" readonly>
		</div>
		<div class="col-md-5">
		<input type="text" placeholder="Advances to be nullified" title="Advances to be nullified" class="form-control" id="advance_nullify" name="advance_nullify" onchange="pay_amount_nullify('advance_amount',this.id)">
		</div>
	</div>
</div>
<?php } ?>

<!-- ======================================================================================================================== -->
<?php
$sq_credit_count = mysqli_num_rows(mysqlQuery("select * from credit_note_master where customer_id='$customer_id'"));
if($sq_credit_count != '0')
{
	$sq_credit_note = mysqlQuery("select * from credit_note_master where customer_id='$customer_id'");
	while($row_credit_note = mysqli_fetch_assoc($sq_credit_note)){
		$total_credit_amount += $row_credit_note['payment_amount'];
	}
	if($total_credit_amount != '0'){
	?>
	<div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
	<legend>Credit Note Details</legend>
		<div class="row mg_tp_20">
			<div class="col-md-3">
				<?php echo "Credit Note Amount : " ?>
			</div>
			<div class="col-md-3">
				<input type="text" class="form-control" id="credit_note_amount" name="credit_note_amount" title="Credit Note Amount" value="<?= ($total_credit_amount) ?>" readonly>
			</div>
		</div>
	</div>
<?php } 
} ?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>
<?php } ?>