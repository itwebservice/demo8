<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('B2C Quotation','') ?>
<?php
if($b2c_flag == '1'){ ?>
<div class="app_panel_content Filter-panel mg_bt_20">
	<div class="row">
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
			<input type="text" class="form-control" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date_filter');">
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
			<input type="text" class="form-control" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date_filter' , 'to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<button class="btn btn-sm btn-info ico_right" onclick="quotation_list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
	</div></div>
</div>
<div id="div_quotation_list_reflect" class="main_block loader_parent">
	<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
		<table id="package_table" class="table table-hover" style="width:100% !important;margin: 20px 0 !important;">         
		</table>
	</div></div></div>
</div>
<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });

var column = [
	{ title : "S_No."},
	{ title : "Service"},
	{ title : "QUOTATION_ID"},
	{ title : "Quotation_Date&Time"},
	{ title : "Customer_name"},
	{ title : "Package_Name"},
	{ title : "QUOTATION_Cost"},
	{ title : "Actions" , className:"text-center action_width"}
];
function quotation_list_reflect(){
	$('#div_quotation_list_reflect').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();

	$.post('quotations_list_reflect.php', { from_date : from_date,to_date : to_date }, function(data){
		pagination_load(data, column, true, false, 20, 'package_table');
		$('.loader').remove();
	})
}
quotation_list_reflect();

function delete_quotation(quotation_id){
	var base_url = $('#base_url').val();
	$('#vi_confirm_box').vi_confirm_box({
        message: 'Are you sure you want to delete?',
        callback: function(data1){
            if(data1=="yes"){
				$.post(base_url+'controller/b2c_settings/b2c/delete_quotation.php', {quotation_id : quotation_id }, function(data){
					var msg = data.split('--');
					if(msg[0] === "error"){
						error_msg_alert(msg[1]);
						return false;
					}else{
						msg_alert(msg[0]);
						quotation_list_reflect();
					}
				});
			}
		}
	});
}

</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php'); 
?>
<?php } else{ ?>
    <div class="alert alert-danger" role="alert">
        Please upgrade the subscription to use this feature.
    </div>
<?php }?>
<style>
.action_width{
	width:250px;
}
</style>