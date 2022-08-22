<?php
include "../../../../model/model.php";
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];

$branch_status = $_POST['branch_status']; 
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
$bank_id = $_POST['bank_id'];
$financial_year_id = $_SESSION['financial_year_id'];

$query = "select * from receipt_payment_master where 1 and payment_amount!='0' ";
if($from_date!="" && $to_date!=""){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);

	$query .= " and payment_date between '$from_date' and '$to_date'";
}
if($bank_id!=""){
	$query .= " and bank_id='$bank_id' ";
}
if($financial_year_id!=""){
	$query .=" and financial_year_id='$financial_year_id'";
}
$query .= " order by id desc";
include "../../../../model/app_settings/branchwise_filteration.php";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
<table class="table table-hover" id="deposit_table" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Transaction_Type</th>
			<th>Date</th>
			<th class="text-right">Amount</th>
			<th>Payment_mode</th>
			<th>Evidence</th>
			<th>Created_by</th>
			<th class="text-center">Edit</th>
		</tr>	
	</thead>
	<tbody>
		<?php
		$count = 0;
		$total_amount=0;
		$sq_deposit = mysqlQuery($query);
		while($row_deposit = mysqli_fetch_assoc($sq_deposit)){

			$sq_bank = mysqli_fetch_assoc(mysqlQuery("select * from bank_master where bank_id='$row_deposit[bank_id]'"));
			$sq_emp = mysqli_fetch_assoc(mysqlQuery("select first_name,last_name from emp_master where emp_id='$row_deposit[emp_id]'"));

			$total_amount = $total_amount + $row_deposit['payment_amount'];
			if($row_deposit['url']!=""){
				$url = explode('uploads', $row_deposit['url']);
				$url = BASE_URL.'uploads'.$url[1];
			}
			else{
				$url = "";
			}
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $row_deposit['receipt_type'] ?></td>
				<td><?= get_date_user($row_deposit['payment_date']) ?></td>
				<td class="text-right success"><?= number_format($row_deposit['payment_amount'],2) ?></td>
				<td><?= $row_deposit['payment_mode'] ?></td>
				<td>
					<?php
					if($url!=""){
						?>
						<a href="<?= $url ?>" class="btn btn-info btn-sm" download title="download"><i class="fa fa-download"></i></a>
						<?php
					}
					?>
				</td>
				<td><?= ($sq_emp['first_name'] !='')?$sq_emp['first_name'].' '.$sq_emp['last_name']:'Admin' ?></td>
				<td class="text-center">
					<button class="btn btn-info btn-sm form-control" onclick="update_modal(<?= $row_deposit['id'] ?>)" title="Edit Details"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr class="active">
			<th colspan="3"></th>
			<th class="text-right success">Total : <?= number_format($total_amount,2) ?></th>
			<th colspan="4"></th>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
	$('#deposit_table').dataTable({
		"pagingType": "full_numbers"
	});
</script>

</div> </div> </div>