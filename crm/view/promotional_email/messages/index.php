<?php
include "../../../model/model.php";
$branch_status = $_POST['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];

$query1 = "select * from email_group_master where 1";
if($branch_status=='yes' && $role=='Branch Admin'){
	$query1 .=" and branch_admin_id = '$branch_admin_id'";
}
$sq_email = mysqlQuery($query1);
?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<input type="hidden" id="branch_admin_id" name="branch_admin_id" value="<?= $branch_admin_id ?>" >
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3">
		<?php $sq_template = mysqlQuery("select DISTINCT template_id,template_type from email_template_master order by template_type");	?>
			<select name="template_type" id="template_type" class="form-control"  title="Template Type">
				<option value="">Select Template Type</option>
				<?php
				while($row_template = mysqli_fetch_assoc($sq_template)){
				?>
					<option value="<?php echo $row_template['template_id']; ?>"><?php echo $row_template['template_type']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-3">
			<select name="group_name" class="form-control" id="group_name" title="Group Name">
				<option value="">Select Email Group</option>
			<?php 
			while($row_email = mysqli_fetch_assoc($sq_email)){   ?>
				<option value="<?php echo $row_email['email_group_id']; ?>"><?php echo $row_email['email_group_name']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-3">
			<input type="text" id="subject" name="subject" placeholder="Subject" title="Subject">
		</div>
		<div class="col-md-3">
			<button class="btn btn-success btn-sm" id="send" onclick="mail_send()"><i class="fa fa-paper-plane-o"></i>&nbsp;&nbsp;Send</button>
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
<?php include_once('message_save_modal.php'); ?>
<script>
$('#template_type').select2();
function mail_send(){

	var template_type = $('#template_type').val();
	var group_name = $('#group_name').val();
	var branch_admin_id = $('#branch_admin_id').val();
	var subject = $('#subject').val();
	var base_url = $('#base_url').val();
	if(template_type==''){
		error_msg_alert('Template Type is required!');
		return false;
	}
	if(group_name==''){
		error_msg_alert('Group Name is required!');
		return false;
	}
	if(subject==''){
		error_msg_alert('Please Enter Subject!');
		return false;
	}
	$('#send').button('loading');
	$.ajax({
		type:'post',
		url:base_url+'controller/promotional_email/message/mail_send.php',
		data:{ template_type : template_type, group_name : group_name, branch_admin_id:branch_admin_id,subject:subject },
		success:function(result){
			msg_alert(result);
			$('#send').button('reset');
			list_reflect();
		}
	});
}
var columns = [
	{ title : "S_No." },
	{ title : "Template_Type" },
	{ title : "Group_Name" },
	{ title : "Subject" },
	{ title : "Email_Date", className:"text-center" }
]
function list_reflect(){

  $('#div_customer_list').append('<div class="loader"></div>');
  var template_type = $('#template_type').val();

  $.post('messages/list_reflect.php', {template_type:template_type}, function(data){
        pagination_load(data,columns, true, false, 20, 'tbl_list');
		$('.loader').remove();
	});
}
list_reflect();
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>