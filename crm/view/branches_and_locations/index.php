<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Locations And Branches',2) ?>

<div class="alert alert-danger hidden" role="alert" id="package_permission">
Please upgrade the subscription to add more branches.
<button type="button" class="close" onclick="remove_hidden_class()"><span>x</span></button>
</div>

<div class="row text-center text_left_sm_xs mg_bt_20">
  <label for="rd_locations" class="app_dual_button mg_bt_10 active">
      <input type="radio" id="rd_locations" name="app_locations" checked onchange="content_reflect()">
      &nbsp;&nbsp;Location
  </label>
  <label for="rd_branches" class="app_dual_button mg_bt_10">
      <input type="radio" id="rd_branches" name="app_locations" onchange="content_reflect()">
      &nbsp;&nbsp;Branches
  </label>
</div>

<div id="div_bl_content"></div>

<?= end_panel() ?>

<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script>
function content_reflect()
{
	var id = $('input[name="app_locations"]:checked').attr('id');
	if(id=="rd_locations"){
		$.post('locations/index.php', {}, function(data){
			$('#div_bl_content').html(data);
		});
	}
	if(id=="rd_branches"){
		$.post('branches/index.php', {}, function(data){
			$('#div_bl_content').html(data);
		});
	}
}
content_reflect();

</script>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>