<?php
include_once("../../../model/model.php");
$query = mysqlQuery("SELECT * FROM `b2c_testimonials` order by entry_id desc");
?>

<div class="row"> <div class="col-md-12"> <div class="table-responsive">
	
<table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
	<thead>
		<tr class="table-heading-row">
			<th>S_No.</th>
			<th>Customer Name(Designation)</th>
			<th>Edit</th>
		</tr>
	</thead>
	<tbody>
    <?php
    $count = 0;
	while($row_query = mysqli_fetch_assoc($query)){

		$url = $row_query['image'];
		$designation = $row_query['designation'];
		$name = $row_query['name'];
		$name1 = ($designation !='') ? $name. '('.$designation.')' : $name;
		?>
			<tr class="<?= $bg ?>">
				<td><?= ++$count ?></td>
				<td><?= $name1 ?></td>
				<td>
					<button class="btn btn-info btn-sm" onclick="update_modal(<?= $row_query['entry_id'] ?>)" title="Edit"><i class="fa fa-pencil-square-o"></i></button>
				</td>
			</tr>
		<?php
		} ?>
	</tbody>
</table>

</div> </div> </div>
      <!-- // $pos = strstr($url,'uploads');
      // if ($pos != false){
      //   $newUrl1 = preg_replace('/(\/+)/','/',$url); 
      //   $newUrl = BASE_URL.str_replace('../', '', $newUrl1);
      // }
      // else{
      //   $newUrl =  $url; 
      // } -->
<script>
$('#tbl_image_list').dataTable({
		"pagingType": "full_numbers"
});
</script>