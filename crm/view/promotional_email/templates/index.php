<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<div class="row text-right mg_bt_10">
    <button class="btn btn-info btn-sm ico_left" data-toggle="modal" data-target="#email_template_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;New Template</button>
</div>

<div class="app_panel_content Filter-panel">
    <div class="row">
		<div class="col-md-3 col-md-offset-4" onchange="list_reflect()">
			<?php $sq_template = mysqlQuery("select DISTINCT template_id,template_type from email_template_master");	?>
				<select name="template_type" id="template_type" class="form-control"  title="Template Type">
					<option value="">Template Type</option>
					<?php 
					while($row_template = mysqli_fetch_assoc($sq_template)){
					?>
						<option value="<?=$row_template['template_type']; ?>"><?php echo $row_template['template_type']; ?></option>
					<?php } ?>
				</select>
			</div>
	</div>
        
    </div>
</div>

<div id="div_customer_list" class="main_block loader_parent mg_tp_20">
    <div class="table-responsive">
        <table id="tbl_list" class="table table-hover" style="margin: 20px 0 !important;width:100%">         
        </table>
    </div>
</div>

<div id="div_customer_update_modal"></div>
<div id="div_view_modal"></div>
<?php include_once('email_template_save_modal.php'); ?>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>

var columns = [
	{ title : "S_No." },
	{ title : "Template_Type" },
	{ title : "Created_at" },
	{ title : "View", className:"text-center" }
]
function list_reflect(){

  $('#div_customer_list').append('<div class="loader"></div>');
  var template_type = $('#template_type').val();

  $.post('templates/list_reflect.php', {template_type:template_type}, function(data){
        pagination_load(data,columns, true, false, 20, 'tbl_list');
		$('.loader').remove();
	});
}
list_reflect();
function view_modal(id)
{
    $.post('templates/view_modal.php', { id:id }, function(data){
    	$('#div_view_modal').html(data);
    });
}

</script>


<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
