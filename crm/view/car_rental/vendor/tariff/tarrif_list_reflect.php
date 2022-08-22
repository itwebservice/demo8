<?php
include "../../../../model/model.php";
$active_flag = $_POST['active_flag'];
$vehicle_name = $_POST['vehicle_name'];

$query = "select * from car_rental_tariff_entries where 1 ";
if($active_flag!=""){
	if($active_flag == 'Active'){
		$query .= " and (status='Active' or status='')";
	}else{
		$query .= " and status='$active_flag' ";
	}
}
if($vehicle_name!=""){
	$vehicle_name = addslashes($vehicle_name);
	$query .= " and vehicle_name='$vehicle_name' ";
}
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> 
<div class="table-responsive">
<table class="table table-bordered table-hover" id="tbl_vendor_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Vehicle_Name</th>
			<th>Travel_Type</th>
			<th>View</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_vendor = mysqlQuery($query);
		while($row_venndor = mysqli_fetch_assoc($sq_vendor))
		{
			$count++;

			$sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_venndor[city_id]'"));
			$bg = ($row_venndor['status']=="Inactive") ? "danger" : "";
			?>
			<tr class="<?= $bg ?>">
				<td><?= $count ?></td>
				<td><?= $row_venndor['vehicle_name'] ?></td>
				<td><?= $row_venndor['tour_type'] ?></td>
				
				<td>
					<button class="btn btn-info btn-sm" onclick="vendor_view_modal(<?= $row_venndor['entry_id'] ?>)" title="View vendor"><i class="fa fa-eye"></i></button>
				</td>
				<td>
					<button class="btn btn-info btn-sm" onclick="vendor_update_modal(<?= $row_venndor['entry_id'] ?>)" title="Edit vendor"><i class="fa fa-pencil-square-o"></i> </button>
				</td>
			</tr>
			<?php
		}
		?>

	</tbody>

</table>

</div>

</div></div>

<script>

$('#tbl_vendor_list').dataTable({
		"pagingType": "full_numbers"
	});

</script>