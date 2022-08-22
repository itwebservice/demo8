<?php
include "../../../model/model.php";
/*======******Header******=======*/
require_once('../../layouts/admin_header.php');
?>
<?= begin_panel('B2C Bookings','') ?>
<?php
if($b2c_flag == '1'){ ?>
	<div class="row">
		<div class="col-md-12 text-right text_left_sm_xs">
			<button class="btn btn-excel btn-sm mg_bt_20" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>&nbsp;&nbsp;
		</div>
	</div>
<div class="app_panel_content Filter-panel mg_bt_20">
	<div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="cust_filter_b2c" id="cust_filter_b2c" style="width:100%" data-toggle="tooltip" title="Select Customer">
            <?php
            $sq_rc = mysqlQuery("select * from customer_master where type='Walkin' and active_flag='Active'"); ?>
            <option value="">Select Customer</option>
            <?php
            while($row_rc = mysqli_fetch_assoc($sq_rc)){
				?>
				<option value="<?= $row_rc['customer_id'] ?>"><?=  $row_rc['first_name'].' '.$row_rc['last_name'] ?></option>
				<?php } ?>
            </select>
        </div>
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
<div id="div__list_reflect" class="main_block loader_parent">
	<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
		<table id="book_table" class="table table-hover" style="width:100% !important;margin: 20px 0 !important;">         
		</table>
	</div></div></div>
</div>
<div id="voucher_modal"></div>
<div id="div_package_content_display"></div>

<script src="<?= BASE_URL ?>js/app/field_validation.js"></script>
<script>
$('#from_date_filter, #to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
$('#cust_filter_b2c').select2();
var columns = [
	{ title : "S_No"},
	{ title : "Booking_ID"},
	{ title : "Service"},
	{ title : "Customer_name"},
	{ title : "Booking_date"},
	{ title : "total_amount", className : "warning"},
	{ title : "cancel_amount", className : "danger"},
	{ title : "net_amount", className : "info"},
	{ title : "paid_amount", className : "success"},
	{ title : "Balance_amount", className : "info"},
	{ title : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", className : "text-center"}
];
function quotation_list_reflect(){
	$('#div__list_reflect').append('<div class="loader"></div>');
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var cust_id = $('#cust_filter_b2c').val();
	$.post('list_reflect.php', { from_date : from_date,to_date : to_date,cust_id:cust_id }, function(data){
		pagination_load(data, columns, true, true, 20, 'book_table');
		$('.loader').remove();
	})
}
quotation_list_reflect();
function voucher_modal(booking_id){
	$.get("voucher_modal.php", {booking_id : booking_id}, function(data){
		$('#voucher_modal').html(data);
	});
}
function package_view_modal(booking_id){
    $.post('view/index.php', { booking_id : booking_id }, function(data){
    	$('#div_package_content_display').html(data);
    });
}
function excel_report(){

	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var cust_id = $('#cust_filter_b2c').val();
    
	window.location = 'excel_report.php?customer_id='+cust_id+'&from_date='+from_date+'&to_date='+to_date;
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