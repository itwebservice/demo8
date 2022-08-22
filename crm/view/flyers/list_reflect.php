<?php
include "../../model/model.php";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">

<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Flyer_name</th>
			<th>Created_at</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$count = 0;
		$sq_flyer = mysqlQuery("select * from flyers where active_flag='Active' order by iid desc");
		while($row_flyer = mysqli_fetch_assoc($sq_flyer)){
			?>
			<tr>
				<td><?= ++$count ?></td>
				<td><?= $row_flyer['flyer_name'] ?></td>
				<td><?= get_date_user($row_flyer['created_at']) ?></td>
				<td>
					<form  style="display:inline-block" data-toggle="tooltip" action="update/tab1.php" id="<?= $row_flyer['iid'] ?>" method="GET">
						<input type="hidden" id="iid" name="iid" value="<?= $row_flyer['iid'] ?>">
						<button class="btn btn-info btn-sm" title="Update Flyer"><i class="fa fa-pencil-square-o"></i></button>
					</form><button type="button" class="btn btn-danger btn-sm" title="Delete Flyer" id="btn_delete<?= $row_flyer['iid'] ?>" onclick="delete_flyer('<?= $row_flyer['iid'] ?>')"><i class="fa fa-trash"></i></button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
</div> </div> </div>

<script>
$('#tbl_list').dataTable({
	"pagingType": "full_numbers"
});
</script>