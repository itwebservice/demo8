<?php
include "../../../model/model.php";
?>
 <div class="table-responsive">
    <table id="tbl_list_group" class="table table-hover" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-grouping-row">
			<th>Group Id</th>
			<th>Group_Name</th>
			<th>Group/SubGroup_Name</th>
			<th>Head_Name</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_group = mysqlQuery("select * from subgroup_master where 1");
		while($row_gr = mysqli_fetch_assoc($sq_group)){
			$count++;
			if($count <= '112'){ 
				$sq_group1 = mysqli_fetch_assoc(mysqlQuery("select * from group_master where group_id='$row_gr[group_id]'"));
				$sq_head = mysqli_fetch_assoc(mysqlQuery("select * from head_master where head_id='$sq_group1[head_id]'"));
			}
			else{
				$sq_group1 = mysqli_fetch_assoc(mysqlQuery("select * from subgroup_master where subgroup_id='$row_gr[group_id]'"));
				$sq_group2 = mysqli_fetch_assoc(mysqlQuery("select * from group_master where group_id='$sq_group1[group_id]'"));
				$sq_head1 = mysqli_fetch_assoc(mysqlQuery("select * from head_master where head_id='$sq_group2[head_id]'"));
			}
			?>
			<tr>
				<td><?= $row_gr['subgroup_id'] ?></td>
				<td><?= $row_gr['subgroup_name'] ?></td>
				<?php if($count <= '112'){ 
				?>
				<td><?= $sq_group1['group_name'] ?></td>
				<td><?= $sq_head['head_name'] ?></td>
				<?php }
				else{
					?>
				<td><?= $sq_group1['subgroup_name'] ?></td>
				<td><?= $sq_head1['head_name'] ?></td>	
				<?php } ?>

				<?php if($count >= '114'){ ?>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_gr['subgroup_id'] ?>)" title="Update Group"><i class="fa fa-pencil-square-o"></i></button>
				</td>
				<?php } 
				else { ?>
				<td></td>
					<?php } ?>

			</tr>
			<?php
		}
		?>
	</tbody>
</table>

</div> 

<script>
$('#tbl_list_group').dataTable({
		"pagingType": "full_numbers"
	});
</script>