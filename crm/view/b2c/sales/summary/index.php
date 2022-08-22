<?php 
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$emp_id = $_SESSION['emp_id'];
$role_id = $_SESSION['role_id'];
?>
<div class="row mg_bt_20">
	<div class="col-md-12 text-right">
		<button class="btn btn-excel btn-sm" onclick="excel_report()" data-toggle="tooltip" title="Generate Excel"><i class="fa fa-file-excel-o"></i></button>
	</div>
</div>

<div class="app_panel_content Filter-panel">
	<div class="row">
        <div class="col-md-3 col-sm-6 mg_bt_10_xs">
            <select name="cust_filter" id="cust_filter" style="width:100%" data-toggle="tooltip" title="Select Customer" onchange="booking_id_dropdown_load(this.id,'booking_id_filter')">
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
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
			<select name="booking_id_filter" id="booking_id_filter" title="Booking ID" style="width: 100%">
				<option value="">Select Booking</option>
		        <?php get_b2c_booking_dropdown(); ?>
		    </select>
		</div>
		<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
			<input type="text" class="form-control" id="from_date_filter" name="from_date_filter" placeholder="From Date" title="From Date" onchange="get_to_date(this.id,'to_date_filter');">
		</div>
		<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_10">
			<input type="text" class="form-control" id="to_date_filter" name="to_date_filter" placeholder="To Date" title="To Date" onchange="validate_validDate('from_date_filter' , 'to_date_filter');">
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
			<button class="btn btn-sm btn-info ico_right" onclick="list_reflect()">Proceed&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
		</div>
	</div>
</div>	
	
		
<div id="div_list" class="main_block">
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
<table id="exc_tour_report" class="table table-hover" style="margin: 20px 0 !important;">         
</table>
</div></div></div>
</div>
<div id="div_exc_content_display"></div>

<script>
$('#cust_filter, #booking_id_filter').select2();
$('#from_date_filter,#to_date_filter').datetimepicker({ timepicker:false, format:'d-m-Y' });
dynamic_customer_load('','');

var column = [
	{ title : "S_No."},
	{ title : "Booking_ID"},
	{ title : "Customer_Name"},
	{ title : "Contact"},
	{ title : "EMAIL_ID"},
	{ title : "Service"},
	{ title : "booking_date"},
	{ title : "View"},
	{ title : "Basic_amount&nbsp;&nbsp;&nbsp;", className : "info"},
	{ title : "tax&nbsp;&nbsp;&nbsp;", className : "info"},
	{ title : "Coupon_amount", className:"info text-right"},
	{ title : "Credit_card_charges", className:"info text-right"},
	{ title : "sale", className:"info text-right"},
	{ title : "cancel", className:"danger text-right"},
	{ title : "Total", className:"info text-right"},
	{ title : "Paid", className:"success text-right"},
	{ title : "View"},
	{ title : "outstanding_balance", className:"warning text-right"},
	{ title : "Purchase"},
	{ title : "Purchased_from"},
	{ title : "Booked_By"},
];
function list_reflect()
{
	var customer_id = $('#cust_filter').val();
	var booking_id = $('#booking_id_filter').val();
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var base_url = $('#base_url').val();
	$.post(base_url+'view/b2c/sales/summary/list_reflect.php', { customer_id : customer_id, booking_id : booking_id, from_date : from_date, to_date : to_date}, function(data){
		pagination_load(data, column, true, true, 20, 'exc_tour_report');
		$('.loader').remove();
	});
}
list_reflect();

function excel_report()
{
	var customer_id = $('#cust_filter').val();
	var booking_id = $('#booking_id_filter').val();
	var from_date = $('#from_date_filter').val();
	var to_date = $('#to_date_filter').val();
	var base_url = $('#base_url').val();
	window.location = base_url+'view/b2c/sales/summary/excel_report.php?customer_id='+customer_id+'&booking_id='+booking_id+'&from_date='+from_date+'&to_date='+to_date;
}
function exc_view_modal(booking_id)
{
var base_url = $('#base_url').val();
$.post(base_url+'view/b2c/sales/summary/view/index.php', { booking_id : booking_id }, function(data){
	$('#div_exc_content_display').html(data);
});
}
function booking_id_dropdown_load(customer_id_filter, booking_id_filter)
{
	var customer_id = $('#'+customer_id_filter).val();
	var base_url = $('#base_url').val();
	$.post(base_url+"view/b2c/sales/summary/booking_id_dropdown_load.php", { customer_id : customer_id }, function(data){	  	
	$('#'+booking_id_filter).html(data);	   
	});
}
function supplier_view_modal(booking_id)
{
var base_url = $('#base_url').val();
$.post(base_url+'view/b2c/sales/summary/view/supplier_view_modal.php', { booking_id : booking_id }, function(data){
	$('#div_exc_content_display').html(data);
});
}
function payment_view_modal(booking_id)
{
	var base_url = $('#base_url').val();
	$.post(base_url+'view/b2c/sales/summary/view/payment_view_modal.php', { booking_id : booking_id }, function(data){	
		$('#div_exc_content_display').html(data);
	});
}
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>