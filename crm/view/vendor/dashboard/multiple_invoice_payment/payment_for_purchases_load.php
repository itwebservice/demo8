<?php
include "../../../../model/model.php";
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='vendor/dashboard/index.php'"));
$branch_status = $sq['branch_status'];

$vendor_type = $_POST['vendor_type'];
$vendor_type_id = $_POST['vendor_type_id'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];

$sq_ledger_count = mysqli_num_rows(mysqlQuery("select * from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type' and group_sub_id='105'"));
if($sq_ledger_count != '0'){
	$sq_advance = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`) as sum FROM `vendor_advance_master` WHERE `vendor_type`='$vendor_type' and `vendor_type_id`='$vendor_type_id' and `clearance_status`!='Pending' and `clearance_status`!='Cancelled'"));
	$sq_payment = mysqli_fetch_assoc(mysqlQuery("SELECT sum(`payment_amount`)as sum FROM `vendor_payment_master` WHERE payment_mode='Advance' and `vendor_type`='$vendor_type' and `vendor_type_id`='$vendor_type_id' and `clearance_status`!='Pending' and `clearance_status`!='Cancelled'"));
?>
<!-- ==============================================PrePurchase Advance ============================================================ -->
<div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
    <legend>Advance Details</legend>
		<div class="row mg_tp_20">
			<div class="col-md-4">
				<?php
				$balance = 0;
				$sq_ledger = mysqli_fetch_assoc(mysqlQuery("select ledger_name,ledger_id from ledger_master where customer_id='$vendor_type_id' and user_type='$vendor_type' and group_sub_id='105'"));
				$balance = $sq_advance['sum'] - $sq_payment['sum'];
				$balance = (floatval($balance) < 0) ? 0 : $balance;
				echo 'Advances to '. $sq_ledger['ledger_name'].' : (DR)'.$sq_advance['payment_amount'];
				?>
			</div>
			<div class="col-md-2">
				<input type="text" class="form-control" id="advance_amount" title="Advance Amount" name="advance_amount" value="<?= ($balance) ?>" readonly>
			</div>
			<div class="col-md-6">
				<input type="text" placeholder="Advances to be nullify" title="Advances to be nullify" class="form-control" id="advance_nullify" name="advance_nullify" onchange="pay_amount_nullify('advance_amount',this.id)">
			</div>
		</div>
</div>
<?php } ?>
<!-- ===============================================Debit Note=================================================================== -->
<?php
$sq_debit_count = mysqli_num_rows(mysqlQuery("select * from debit_note_master where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id'"));
if($sq_debit_count != '0')
{
	$sq_debit_note = mysqlQuery("select * from debit_note_master where vendor_type='$vendor_type' and vendor_type_id='$vendor_type_id'");
	while($row_debit_note = mysqli_fetch_assoc($sq_debit_note)){
		$total_debit_amount += $row_debit_note['payment_amount'];
	}
	if($total_debit_amount != '0')
	{
	?>
	<div class="panel panel-default panel-body app_panel_style mg_tp_20 feildset-panel">
	<legend>Debit Note Details</legend>
		<div class="row mg_tp_20">
			<div class="col-md-3">
				<?php echo "Debit Note Amount : " ?>
			</div>
	 		<div class="col-md-3">
				<input type="text" class="form-control" id="debit_note_amount" name="debit_note_amount" title="Debit Note Amount" value="<?= ($total_debit_amount) ?>" readonly>
			</div>
		</div>
	</div>
<?php } } ?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>