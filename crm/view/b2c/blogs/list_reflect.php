<?php
include_once("../../../model/model.php");
$query = mysqlQuery("SELECT * FROM `b2c_blogs` where active_flag='0' order by entry_id desc");
?>
<div class="row"> <div class="col-md-12"> <div class="table-responsive">

<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Blog Title</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
    <?php
    $count = 0;
	while($row_query = mysqli_fetch_assoc($query)){

		$url = $row_query['image'];
		$description = $row_query['description'];
		$title = $row_query['title'];
		$bg = ($row_query['active_flag'] == '1') ? 'danger' : '';
		?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $title ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_query['entry_id'] ?>)" title="Edit"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
		<?php
	} ?>
	</tbody>
</table>

</div> </div> </div>
<script>
$('#tbl_image_list').dataTable({
	"pagingType": "full_numbers"
});
</script>