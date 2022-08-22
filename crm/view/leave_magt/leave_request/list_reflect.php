<?php
include "../../../model/model.php";
$emp_id= $_SESSION['emp_id'];
$role= $_SESSION['role'];
$role_id= $_SESSION['role_id'];
$branch_admin_id= $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query = "select * from leave_request where 1 ";
if($from_date!='' && $to_date!=''){
	$from_date = get_date_db($from_date);
	$to_date = get_date_db($to_date);
	$query .=" and created_date between '$from_date' and '$to_date'";
}
if($branch_status=='yes'){
	if($role=='Branch Admin' || $role=='Hr' || $role=='Accountant' || $role_id>'7'){
		$query .= " and emp_id in(select emp_id from emp_master where branch_id = '$branch_admin_id')";
	}
	elseif($role!='Admin' && $role!='Branch Admin' && $role_id!='7' && $role_id<'7' && $role!='Hr'){
		$query .= " and emp_id='$emp_id' and emp_id in(select emp_id from emp_master where branch_id = '$branch_admin_id')";
	}
}
$query .=" order by request_id desc";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad mg_tp_20"> <div class="table-responsive">

<table class="table table-hover" id="tbl_lreq" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>User_Name</th>
			<th>Request_date</th>
			<th>Status</th>
			<th>Total_days</th>
			<th>Reason</th>
			<th>Comment</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_req = mysqlQuery($query);
		while($row_req = mysqli_fetch_assoc($sq_req)){
			   $sq_emp = mysqli_fetch_assoc(mysqlQuery("select * from emp_master where emp_id='$row_req[emp_id]'"));
				 if($row_req['status'] == 'Reject'){ $bg = 'danger'; }
				 else if($row_req['status'] == 'Approved'){ $bg = 'success'; }
			   else { $bg = ''; }
			?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $sq_emp['first_name'].' '.$sq_emp['last_name']  ?></td>
				<td><?= date('d/m/Y', strtotime($row_req['created_date'])) ?></td>
				<td><?= ($row_req['status']=='')?'Not Processed': $row_req['status'] ?></td>
				<td><?=  $row_req['no_of_days'] ?></td>
				<td><?= $row_req['reason_for_leave'] ?></td>
				<td><?= ($row_req['comments'] == '')?'NA': $row_req['comments']?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>	

</div> </div> </div>
<script>
$('#tbl_lreq').dataTable({
		"pagingType": "full_numbers"
	});
</script>