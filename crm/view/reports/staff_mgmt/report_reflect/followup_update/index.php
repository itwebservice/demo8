<?php
include "../../../../../model/model.php";
// $branch_status = $_GET['branch_status'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='reports/staff_mgmt/index.php'"));
$branch_status_follow = $sq['branch_status'];

?>
<div class="row text-right mg_bt_10">
	<div class="col-md-12">
		<button class="btn btn-excel btn-sm pull-right" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>
<input type="hidden" id="branch_status_follow" name="branch_status_follow" value="<?= $branch_status_follow ?>" >
<div class="app_panel_content Filter-panel">
	<div class="row">
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="from_date_filteru" id="from_date_filteru" placeholder="From Date" title="From Date" value="<?=date('d-m-Y 00:00')?>" onchange="get_to_datetime(this.id,'to_date_filteru');">
		</div>
		<div class="col-md-3 mg_bt_10_xs">
			<input type="text" name="to_date_filteru" id="to_date_filteru" placeholder="To Date" title="To Date" value="<?=date('d-m-Y 23:00')?>" onchange="validate_validDatetime('from_date_filteru','to_date_filteru');">
		</div>
		<div class="col-md-3">
			<button class="btn btn-sm btn-info ico_right" onclick="report_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>

<hr>

<div id="div_report" class="main_block mg_tp_10"></div>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="group_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script type="text/javascript">
$('#emp_id_filter').select2();
$('#from_date_filteru, #to_date_filteru').datetimepicker({ format:'d-m-Y H:i' });
var column = [
{ title : "S_No."},
{ title:"Customer_Name"},
{ title : "Assigned_To"},
{ title : "Followup_Date"},
{ title : "Followup_Type"},
{ title : "followup_status"},
{ title : "Followup_Description"}	
]; 
function report_reflect()
{
	var from_date = $('#from_date_filteru').val();
	var to_date = $('#to_date_filteru').val();
	var branch_status = $('#branch_status_follow').val();
	$.post('report_reflect/followup_update/report_reflect.php', { from_date : from_date, to_date : to_date,branch_status : branch_status}, function(data){
		pagination_load(data, column, true, false, 20, 'group_tour_report');
	});
}

function excel_report()
{
	var from_date = $('#from_date_filteru').val();
	var to_date = $('#to_date_filteru').val();
	var branch_status = $('#branch_status_follow').val(); 
	window.location = 'report_reflect/followup_update/excel_report.php?from_date='+from_date+'&to_date='+to_date+'&branch_status='+branch_status;
}
report_reflect();
</script>