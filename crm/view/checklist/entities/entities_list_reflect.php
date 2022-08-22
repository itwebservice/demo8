<?php
include "../../../model/model.php";
$entity_for = $_POST['entity_for'];

?>
<div class="row mg_tp_10"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	<table class="table table-bordered" id="checklist_entities_tbl">
		<thead>
			<tr class="active table-heading-row">
				<th>S_No.</th>
				<th>Service &nbsp;&nbsp;&nbsp;</th>
				<th>View</th>
				<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0; 
			$query = "select * from checklist_entities where 1 ";
			if($entity_for != ''){
				$query .= " and entity_for='$entity_for'";
			}
			$sq_entity = mysqlQuery($query);
			while($row_entity = mysqli_fetch_assoc($sq_entity)){
				
				$sq_tour =mysqli_fetch_assoc(mysqlQuery("select * from tour_master where tour_id='$row_entity[tour_id]'"));
				$sq_tour_group =mysqli_fetch_assoc(mysqlQuery("select * from tour_groups where tour_id='$row_entity[tour_id]' and group_id='$row_entity[tour_group_id]'"));
				$sq_pckg_tour=mysqli_fetch_assoc(mysqlQuery("select * from package_tour_booking_master where booking_id='$row_entity[booking_id]'"));
				$sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_name from destination_master where dest_id='$row_entity[destination_name]'"));
				if($row_entity['entity_for'] == 'Package Tour'||$row_entity['entity_for'] == 'Group Tour') {
					$entity_for1 = $row_entity['entity_for'].' ('.$sq_dest['dest_name'].')';
				}else if($row_entity['entity_for'] == 'Excursion Booking'){
					$entity_for1 = 'Activity Booking';
				}
				else{
					$entity_for1 = $row_entity['entity_for'];
				}
				?>
				<tr>
					<td><?= ++$count ?></td>
					<td><?= $entity_for1 ?></td>
					<td><button class="btn btn-info btn-sm" onclick="view_modal(<?= $row_entity['entity_id']  ?>)" title="View Checklist"><i class="fa fa-eye"></i></button></td>
					<td>					
						<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_entity['entity_id'] ?>)" title="Edit Checklist"><i class="fa fa-pencil-square-o"></i></button>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>	
</div> </div> </div>


<script>
$('#checklist_entities_tbl').dataTable({"pagingType": "full_numbers"});
</script>