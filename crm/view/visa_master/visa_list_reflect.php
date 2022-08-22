<?php
include "../../model/model.php";

$country_name = $_POST['country_name'];
$visa_type = $_POST['visa_type'];
$query = "select * from visa_crm_master where 1";

if($country_name!=""){
	$query .=" and country_id='$country_name' ";
}
if($visa_type!=""){
	$visa_type = addslashes($visa_type);
	$query .=" and visa_type='$visa_type' ";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table" id="tbl_emp_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Country_Name</th>
			<th>Visa_Type</th>
			<th>Total_Amount</th>
			<th>Time Taken</th>
			<th>View</th>
			<th>Edit</th>
			<th>Send</th>
			<th>Download_Form</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0; $total_amt = 0;
		$sq_emp = mysqlQuery($query);
		while($row_emp = mysqli_fetch_assoc($sq_emp)){
			
			$sq_location = mysqli_fetch_assoc(mysqlQuery("select * from locations where location_id='$row_emp[location_id]'"));
			$sq_branch = mysqli_fetch_assoc(mysqlQuery("select * from branches where branch_id='$row_emp[branch_id]'"));
			$total_amt = $row_emp['fees'] + $row_emp['markup'];
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= $row_emp['country_id'] ?></td>
				<td><?= $row_emp['visa_type'] ?></td>
				<td><?= number_format($total_amt,2) ?></td>
				<td><?= $row_emp['time_taken']?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="display_modal(<?= $row_emp['entry_id'] ?>)" title="View Visa"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_emp['entry_id'] ?>)" title="Edit Visa"><i class="fa fa-pencil-square-o"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" id="send-<?= $row_emp['entry_id'] ?>" onclick="send(<?= $row_emp['entry_id'] ?>)" title="Send via email and whatsapp"><i class="fa fa-paper-plane-o"></i></button>
				</td>
				<td>
				<?php 
					$download_url = preg_replace('/(\/+)/','/',$row_emp['upload_url']);
					$download_url2 = BASE_URL.str_replace('../', '', $download_url);
					$download_url1 = preg_replace('/(\/+)/','/',$row_emp['upload_url2']);
					$download_url3 = BASE_URL.str_replace('../', '', $download_url1);
				?>        
					<?php if($row_emp['upload_url']!=""): ?>
					<a href="<?= $download_url2 ?>" class="btn btn-info btn-sm ico_left" style="padding: 15px 24px;" title="Download Form1" download><i class="fa fa-download"></i></a>
					<?php endif; ?>
					<?php if($row_emp['upload_url2']!=""): ?>
					<a href="<?= $download_url3 ?>" class="btn btn-info btn-sm ico_left" style="padding: 15px 24px;" title="Download Form2" download><i class="fa fa-download"></i></a>
					<?php endif; ?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div> </div> </div>

<script>
$('#tbl_emp_list').dataTable({
		"pagingType": "full_numbers"
	});
</script>