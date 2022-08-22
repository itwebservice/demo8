<?php
include "../../../model/model.php";
$city_id = $_POST['city_id'];
$branch_status = $_POST['branch_status'];
$branch_admin_id = $_POST['branch_admin_id'];
$active_flag = $_POST['active_flag'];
$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$emp_id = $_SESSION['emp_id'];
$query = "select * from excursion_inventory_master where 1 ";
if($city_id != ''){
	$query .= " and city_id = '$city_id'";
}
if($active_flag != ''){
	$query .= " and active_flag ='$active_flag' ";
}
include "../../../model/app_settings/branchwise_filteration.php";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table class="table" id="table_hotel_inv" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>City_name</th>
			<th>Activity_name</th>
			<th>Rate</th>
			<th>Total_Tickets</th>
			<th>Tickets_Available</th>
			<th>Valid_From</th>
			<th>Valid_To</th>
			<th>Edit</th>
			<th>Download</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$count = 0;
		$sq_serv = mysqlQuery($query);
		while($row_ser = mysqli_fetch_assoc($sq_serv)){
			$total_pax = 0;
			$total_pax1 = 0;
			$bg = ($row_ser['active_flag'] == 'Inactive')?'danger':'';
			$sq_city = mysqli_fetch_assoc(mysqlQuery("select city_name from city_master where city_id='$row_ser[city_id]'"));
			$sq_exc = mysqli_fetch_assoc(mysqlQuery("select entry_id, excursion_name from excursion_master_tariff where entry_id='$row_ser[exc_id]'"));

			//Excursion Booking
			$sq_hotel_c = mysqlQuery("select total_adult, total_child from excursion_master_entries where city_id= '$row_ser[city_id]' and exc_name = '$row_ser[exc_id]' and status!='Cancel' and (exc_date between '$row_ser[valid_from_date]' and '$row_ser[valid_to_date]')");
			while($row_hotel_c = mysqli_fetch_assoc($sq_hotel_c)){
				$total_pax += $row_hotel_c['total_adult'] + $row_hotel_c['total_child'];
			}
			//Package booking
			$sq_hotel_c1 = mysqlQuery("select * from package_tour_excursion_master where city_id= '$row_ser[city_id]' and exc_id = '$row_ser[exc_id]' and booking_id in(select booking_id from package_tour_booking_master where tour_from_date between '$row_ser[valid_from_date]' and '$row_ser[valid_to_date]')");

			while($row_hotel_c1= mysqli_fetch_assoc($sq_hotel_c1)){
				
				$cancel_est = mysqli_num_rows(mysqlQuery("select * from package_refund_traveler_estimate where booking_id='$row_hotel_c1[booking_id]'"));
				if($cancel_est == 0){
					$pax = $row_hotel_c1['adult'] + $row_hotel_c1['chwb'] + $row_hotel_c1['chwob'] + $row_hotel_c1['infant'];
					$total_pax1 = $total_pax1 + $pax;
				}
			}
			$total_avail =  intval($row_ser['total_tickets']) - intval($total_pax) - intval($total_pax1);
		?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $sq_city['city_name'] ?></td>
				<td><button class="btn btn-info btn-sm" style="color:red !important;cursor:pointer!important;" onclick="history_modal(<?= $row_ser['entry_id'] ?>)" style="color:#009898;" id="hhistory<?= $row_ser['entry_id'] ?>" title="Show history"><?= $sq_exc['excursion_name'] ?></button></td>
				<td><?= $row_ser['rate'] ?></td>
				<td><?= $row_ser['total_tickets'] ?></td>
				<td><?= ($total_avail <= 0) ? 0 : $total_avail ?></td>
				<td><?= date("d-m-Y", strtotime($row_ser['valid_from_date'])) ?></td>
				<td><?= date("d-m-Y", strtotime($row_ser['valid_to_date'])) ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_ser['entry_id'] ?>)" title="Update"><i class="fa fa-pencil-square-o"></i></button></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="excel_report(<?= $row_ser['entry_id'] ?>)" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button></td>
			</tr>
			<?php } ?>
	</tbody>
</table>
</div> </div> </div>
<script type="text/javascript">
$('#table_hotel_inv').dataTable({
	"pagingType": "full_numbers"
});
</script>